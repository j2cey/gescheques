<template>
    <div class="card">
        <header>
            <div class="card-header-title row">
                <div class="col-md-6 col-sm-9 col-12">
                    <span class="text-indigo text-xs" @click="collapseClicked()" data-toggle="collapse" data-parent="#enumvaluelist" :href="'#collapse-enumvalues-'+index">
                        {{ enumvalue.val }}
                    </span>
                </div>
                <div class="col-md-6 col-sm-3 col-12 text-right">
                    <span class="text text-xs">
                        <a type="button" class="btn btn-tool text-warning" data-toggle="tooltip" @click="editEnumValue(enumvalue)">
                            <i class="fa fa-pencil-square-o"></i>
                        </a>
                        <a type="button" class="btn btn-tool" @click="collapseClicked()" data-toggle="collapse" data-parent="#enumvaluelist" :href="'#collapse-enumvalues-'+index">
                            <i :class="currentCollapseIcon"></i>
                        </a>
                        <a type="button" class="btn btn-tool text-danger" @click="deleteEnumValue(enumvalue.uuid, index)">
                            <i class="fa fa-trash"></i>
                        </a>
                    </span>
                </div>
            </div>
            <!-- /.user-block -->
        </header>
        <!-- /.card-header -->
        <div :id="'collapse-enumvalues-'+index" class="card-content panel-collapse collapse in">
            <dl class="row">
                <dt class="col-sm-4 text-xs">Description</dt>
                <dd class="col-sm-8 text-xs">{{ enumvalue.description }}</dd>
                <dt class="col-sm-4 text-xs" v-if="enumvalue.status">Statut</dt>
                <dd class="col-sm-8 text-xs" v-if="enumvalue.status">
                    <b-tag type="is-success is-light" v-if="enumvalue.status.code === 'active'">{{ enumvalue.status.name }}</b-tag>
                    <b-tag type="is-danger is-light" v-else>{{ enumvalue.status.name }}</b-tag>
                </dd>
            </dl>
        </div>
        <!-- /.card-body -->
    </div>
</template>

<script>
    import EnumValueBus from "../enumvalues/enumvalueBus";

    export default {
        name: "enumvalue-item",
        props: {
            enumvalue_prop: {},
            index_prop: {}
        },
        components: {
        },
        mounted() {
            EnumValueBus.$on('enumvalue_updated', (upd_data) => {
                if (this.enumvalue.id === upd_data.enumvalue.id) {
                    this.updateEnumValue(upd_data.enumvalue)
                }
            })
        },
        data() {
            return {
                enumvalue: this.enumvalue_prop,
                index: this.index_prop,
                collapse_icon: 'fas fa-chevron-down',
                isOpen: true
            }
        },
        methods: {
            editEnumValue(enumvalue) {
                EnumValueBus.$emit('enumvalue_edit', enumvalue);
            },
            updateEnumValue(enumvalue) {
                this.enumvalue = enumvalue
            },
            deleteEnumValue(id, key) {
                this.$swal({
                    html: '<small>Voulez-vous vraiment supprimer cette Valeur ?</small>',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Non'
                }).then((result) => {
                    if(result.value) {

                        axios.delete(`/enumvalues/${id}`)
                            .then(resp => {

                                let enumvalue = resp.data.enumvalue
                                let enumtype = resp.data.enumtype

                                console.log('enumvalues delete resp: ', resp)

                                this.$swal({
                                    html: '<small>Valeur supprimée avec succès !</small>',
                                    icon: 'success',
                                    timer: 3000
                                }).then(() => {
                                    EnumValueBus.$emit('enumvalue_deleted', {key, enumvalue, enumtype})
                                })
                            }).catch(error => {
                            window.handleErrors(error)
                        })

                    } else {
                        // stay here
                    }
                })
            },
            collapseClicked() {
                if (this.collapse_icon === 'fas fa-chevron-down') {
                    this.collapse_icon = 'fas fa-chevron-up';
                } else {
                    this.collapse_icon = 'fas fa-chevron-down';
                }
            }
        },
        computed: {
            currentCollapseIcon() {
                return this.collapse_icon;
            }
        }
    }
</script>

<style scoped>

</style>
