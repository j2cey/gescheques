<template>
    <div class="modal fade" id="addUpdateEnumvalue" tabindex="-1" role="dialog" aria-labelledby="enumvalueModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-sm" id="enumvalueModalLabel" v-if="editing">Modifier Valeur</h5>
                    <h5 class="modal-title text-sm" id="enumvalueModalLabel" v-else>Créer Nouvelle Valeur</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" @submit.prevent @keydown="enumvalueForm.errors.clear()">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="enumvalue_val" class="col-sm-2 col-form-label text-xs text-xs">Valeur</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="enumvalue_val" name="val" placeholder="Titre" v-model="enumvalueForm.val">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="enumvalueForm.errors.has('val')" v-text="enumvalueForm.errors.get('val')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="action_description" class="col-sm-2 col-form-label text-xs">Description</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="action_description" name="description" required autocomplete="description" autofocus placeholder="Description" v-model="enumvalueForm.description">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="enumvalueForm.errors.has('description')" v-text="enumvalueForm.errors.get('description')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="m_select_action_type" class="col-sm-2 col-form-label text-xs">Statut</label>
                                <div class="col-sm-10 text-xs">
                                    <multiselect
                                        id="m_select_action_type"
                                        v-model="enumvalueForm.status"
                                        selected.sync="enumvalue.status"
                                        value=""
                                        :options="statuses"
                                        :searchable="true"
                                        :multiple="false"
                                        label="name"
                                        track-by="id"
                                        key="id"
                                        placeholder="Statut"
                                    >
                                    </multiselect>
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="enumvalueForm.errors.has('status')" v-text="enumvalueForm.errors.get('status')"></span>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer justify-content-between">
                    <b-button type="is-dark" size="is-small" data-dismiss="modal">Fermer</b-button>
                    <b-button type="is-primary" size="is-small" :loading="loading" @click="updateEnumvalue(enumtypeId)" :disabled="!isValidCreateForm" v-if="editing">Enregistrer</b-button>
                    <b-button type="is-primary" size="is-small" :loading="loading" @click="createEnumvalue(enumtypeId)" :disabled="!isValidCreateForm" v-else>Créer Action</b-button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
    import Multiselect from "vue-multiselect";
    import EnumValueBus from "../enumvalues/enumvalueBus";

    class Enumvalue {
        constructor(enumvalue) {
            this.val = enumvalue.val || ''
            this.description = enumvalue.description || ''
            this.enum_type_id = enumvalue.enum_type_id || ''
            this.status = enumvalue.status || ''
        }
    }
    export default {
        name: "enumvalue-addupdate",
        props: {
        },
        components: { Multiselect },
        mounted() {
            EnumValueBus.$on('enumvalue_create', (enumtype) => {

                this.editing = false
                this.enumtypeId = enumtype.id
                this.enumvalue = new Enumvalue({})
                this.enumvalue.enum_type_id = enumtype.id
                this.enumvalueForm = new Form(this.enumvalue)

                $('#addUpdateEnumvalue').modal()
            })

            EnumValueBus.$on('enumvalue_edit', (enumvalue) => {
                this.editing = true
                this.enumvalue = new Enumvalue(enumvalue)
                this.enumvalueForm = new Form(this.enumvalue)
                this.enumvalueId = enumvalue.uuid
                this.enumtypeId = enumvalue.enum_type_id

                $('#addUpdateEnumvalue').modal()
            })
        },
        created() {
            axios.get('/statuses.fetch')
                .then(({data}) => this.statuses = data);
        },
        data() {
            return {
                enumvalue: {},
                enumtypeId: '',
                enumvalueForm: new Form(new Enumvalue({})),
                enumvalueId: null,
                editing: false,
                loading: false,
                statuses: []
            }
        },
        methods: {
            createEnumvalue() {
                this.loading = true

                this.enumvalueForm
                    .post('/enumvalues')
                    .then(resp => {
                        this.loading = false
                        // on émet la valeur créé dans le bus EnumValue
                        console.log('enumvalues post resp: ', resp)
                        let enumvalue = resp.enumvalue
                        let enumtype = resp.enumtype

                        this.closeModal()

                        this.$swal({
                            html: '<small>Valeur créée avec succès !</small>',
                            icon: 'success',
                            timer: 3000
                        }).then(() => {
                            EnumValueBus.$emit('enumvalue_created', {enumvalue, enumtype})
                        })
                    }).catch(error => {
                    this.loading = false
                });
            },
            updateEnumvalue() {
                this.loading = true

                this.enumvalueForm
                    .put(`/enumvalues/${this.enumvalueId}`)
                    .then(resp => {
                        this.loading = false
                        let enumvalue = resp.enumvalue
                        let enumtype = resp.enumtype

                        this.closeModal()

                        this.$swal({
                            html: '<small>Valeur modifiée avec succès !</small>',
                            icon: 'success',
                            timer: 3000
                        }).then(() => {
                            EnumValueBus.$emit('enumvalue_updated', {enumvalue, enumtype})
                        })
                    }).catch(error => {
                    this.loading = false
                });
            },
            closeModal() {
                this.resetForm()
                $('#addUpdateEnumvalue').modal('hide')
            },
            resetForm() {
                this.enumvalueForm.reset();
            }
        },
        computed: {
            isValidCreateForm() {
                return !this.loading
            }
        }
    }
</script>
<style lang="scss" scoped>
    @import "~vue-multiselect/dist/vue-multiselect.min.css";
</style>
