<template>
    <div class="modal fade" id="addUpdateEnumtype" tabindex="-1" role="dialog" aria-labelledby="exampleenumtypeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-sm" id="exampleenumtypeModalLabel" v-if="editing">Modifier Type Composé</h5>
                    <h5 class="modal-title text-sm" id="exampleenumtypeModalLabel" v-else>Créer Nouveau Type Composé</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" @submit.prevent @keydown="enumtypeForm.errors.clear()">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="enumtype_name" class="col-sm-4 col-form-label text-xs">Nom</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="enumtype_name" name="name" autocomplete="name" autofocus placeholder="Titre" v-model="enumtypeForm.name">
                                    <span class=" invalid-feedback d-block text-xs" role="alert" v-if="enumtypeForm.errors.has('name')" v-text="enumtypeForm.errors.get('name')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="enumtype_description" class="col-sm-4 col-form-label text-xs">Description</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="enumtype_description" name="description" required autocomplete="description" autofocus placeholder="Description" v-model="enumtypeForm.description">
                                    <span class=" invalid-feedback d-block text-xs" role="alert" v-if="enumtypeForm.errors.has('description')" v-text="enumtypeForm.errors.get('description')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="m_select_status" class="col-sm-4 col-form-label text-xs">Statut</label>
                                <div class="col-sm-8">
                                    <multiselect class="text text-xs"
                                                 id="m_select_status"
                                                 v-model="enumtypeForm.status"
                                                 selected.sync="enumtypeForm.status"
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
                                    <span class=" invalid-feedback d-block text-xs" role="alert" v-if="enumtypeForm.errors.has('status')" v-text="enumtypeForm.errors.get('status')"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <b-field label="Valeur(s)" class="col"
                                         label-position="on-border"
                                         :type="enumtypeForm.errors.has('enumvalues') ? 'is-danger' : ''"
                                         :message="enumtypeForm.errors.get('enumvalues')">
                                    <b-taginput
                                        v-model="enumvalues"
                                        autocomplete
                                        :allow-new="true"
                                        :open-on-focus="true"
                                        field="val"
                                        icon="label"
                                        placeholder="Ajouter valeur"
                                        attached
                                        :before-adding="checkNewEnumValue"
                                        :create-tag="createEnumvalue"
                                    >
                                    </b-taginput>
                                </b-field>
                            </div>

                        </div>
                    </form>

                </div>
                <div class="modal-footer justify-content-between">
                    <b-button type="is-dark" size="is-small" data-dismiss="modal">Fermer</b-button>
                    <b-button type="is-primary" size="is-small" :loading="loading" @click="updateEnumType()" :disabled="!isValidCreateForm" v-if="editing">Enregistrer</b-button>
                    <b-button type="is-primary" size="is-small" :loading="loading" @click="createEnumType()" :disabled="!isValidCreateForm" v-else>Créer Etape</b-button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'
    import EnumTypeBus from './enumtypeBus'

    class Enumtype {
        constructor(enumtype) {
            this.name = enumtype.name || ''
            this.description = enumtype.description || ''
            this.status = enumtype.status || ''
            this.enumvalues = enumtype.enumvalues || ''
        }
    }
    export default {
        name: "enumtype-addupdate",
        components: { Multiselect },
        mounted() {
            EnumTypeBus.$on('enumtype_create', () => {
                this.editing = false
                this.enumtype = new Enumtype({})
                this.enumvalues = []
                this.enumtypeForm = new Form(this.enumtype)

                $('#addUpdateEnumtype').modal()
            })

            EnumTypeBus.$on('enumtype_edit', (enumtype) => {
                this.editing = true
                this.enumtype = new Enumtype(enumtype)
                this.enumtypeForm = new Form(this.enumtype)

                this.enumtypeId = enumtype.uuid
                this.enumvalues = enumtype.enumvalues

                $('#addUpdateEnumtype').modal()
            })
        },
        created() {
            axios.get('/statuses.fetch')
                .then(({data}) => this.statuses = data);
        },
        data() {
            return {
                enumtype: {},
                enumvalues: [],
                enumtypeForm: new Form(new Enumtype({})),
                enumtypeId: null,
                editing: false,
                loading: false,
                statuses: [],
                radioButton: ''
            }
        },
        methods: {
            checkNewEnumValue(tagToAdd) {
                let tagIndex = this.enumvalues.findIndex(e => {
                    return tagToAdd.toUpperCase() === e.val.toUpperCase()
                })

                return tagIndex === -1;
            },
            createEnumvalue(tagToAdd) {
                return {
                    'is_default': 0,
                    'val': tagToAdd,
                    'description': "",
                }
            },
            createEnumType() {
                this.loading = true

                this.enumtypeForm.enumvalues = this.enumvalues

                this.enumtypeForm
                    .post('/enumtypes')
                    .then(enumtype => {
                        this.loading = false

                        this.closeModal()

                        this.$swal({
                            html: '<small>Type créé avec succès !</small>',
                            icon: 'success',
                            timer: 3000
                        }).then(() => {
                            EnumTypeBus.$emit('enumtype_created', { enumtype })
                        })
                    }).catch(error => {
                    this.loading = false
                });
            },
            updateEnumType() {
                this.loading = true

                this.enumtypeForm.enumvalues = this.enumvalues

                this.enumtypeForm
                    .put(`/enumtypes/${this.enumtypeId}`)
                    .then(enumtype => {
                        this.loading = false
                        this.resetForm();

                        this.closeModal()

                        this.$swal({
                            html: '<small>Type modifié avec succès !</small>',
                            icon: 'success',
                            timer: 3000
                        }).then(() => {
                            EnumTypeBus.$emit('enumtype_updated', { enumtype })
                        })

                    }).catch(error => {
                    this.loading = false
                });
            },
            closeModal() {
                this.resetForm()
                $('#addUpdateEnumtype').modal('hide')
            },
            resetForm() {
                this.enumtypeForm.reset();
            }
        },
        computed: {
            isValidCreateForm() {
                return !this.loading
            },
        }
    }
</script>

<style scoped>

</style>
