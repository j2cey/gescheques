<template>
    <div class="card">
        <header>
            <div class="card-header-title row">
                <div class="col-md-6 col-sm-9 col-12">
                    <span class="text-indigo text-xs" @click="collapseClicked()" data-toggle="collapse" data-parent="#actionlist" :href="'#collapse-actions-'+index">
                        {{ workflowaction.titre }}
                    </span>
                </div>
                <div class="col-md-6 col-sm-3 col-12 text-right">
                    <span class="text text-xs">
                        <a type="button" class="btn btn-tool text-warning" data-toggle="tooltip" @click="editAction(workflowaction)">
                            <i class="fa fa-pencil-square-o"></i>
                        </a>
                        <a type="button" class="btn btn-tool" @click="collapseClicked()" data-toggle="collapse" data-parent="#actionlist" :href="'#collapse-actions-'+index">
                            <i :class="currentCollapseIcon"></i>
                        </a>
                        <a type="button" class="btn btn-tool text-danger" @click="deleteAction(workflowaction.uuid, index)">
                            <i class="fa fa-trash"></i>
                        </a>
                    </span>
                </div>
            </div>
            <!-- /.user-block -->
        </header>
        <!-- /.card-header -->
        <div :id="'collapse-actions-'+index" class="card-content panel-collapse collapse in">
            <dl class="row">
                <dt class="col-sm-4 text-xs" v-if="workflowaction.actiontype">Type Champs</dt>
                <dd class="col-sm-8 text-xs">{{ workflowaction.actiontype.name }}</dd>
                <dd v-if="workflowaction.actiontype.code === 'EnumType'" class="col-sm-8 offset-sm-4">
                    <small>
                        <span class="text-lighter text-xs text-warning hidden-sm-down">
                            {{ workflowaction.enumtype.name }}
                        </span>
                    </small>
                </dd>
                <dt class="col-sm-4 text-xs" v-if="workflowaction.treatmenttype">Type Traitement</dt>
                <dd class="col-sm-8 text-xs">
                    <b-tag type="is-primary is-light" v-if="workflowaction.treatmenttype.code === 'pass'">{{ workflowaction.treatmenttype.name }}</b-tag>
                    <b-tag type="is-danger is-light" v-else-if="workflowaction.treatmenttype.code === 'reject'">{{ workflowaction.treatmenttype.name }}</b-tag>
                    <b-tag type="is-warning is-light" v-else-if="workflowaction.treatmenttype.code === 'allways'">{{ workflowaction.treatmenttype.name }}</b-tag>
                    <b-tag type="is-info is-light" v-else-if="workflowaction.treatmenttype.code === 'expire'">{{ workflowaction.treatmenttype.name }}</b-tag>
                    <b-tag type="is-dark is-light" v-else>{{ workflowaction.treatmenttype.name }}</b-tag>
                </dd>
                <dd v-if="workflowaction.actiontype && workflowaction.actiontype.code === 'FILE_ref'" class="col-sm-8 offset-sm-4">
                    <small>
                        <span class="text-lighter text-xs hidden-sm-down">
                            <span  v-for="(mimetype, index) in workflowaction.mimetypes" v-if="workflowaction.mimetypes" class="badge badge-pill badge-default">
                                {{ mimetype.name }}
                            </span>
                        </span>
                    </small>
                </dd>
                <dt class="col-sm-4 text-xs">Description</dt>
                <dd class="col-sm-8 text-xs">{{ workflowaction.description }}</dd>

                <!--Champs Facultatif Si les champs sont renseignés-->
                <dt v-if="workflowaction.field_required_without" class="col-sm-4 text-xs"><span class="text-sm">Champs Facultatif si:</span></dt>
                <dd v-if="workflowaction.field_required_without" class="col-sm-8 text-xs">
                    <small>
                        <span class="text-lighter hidden-sm-down">
                            <span  v-for="(actionwithout, index) in workflowaction.actionsrequiredwithout" v-if="workflowaction.actionsrequiredwithout" class="badge badge-info">
                                {{ actionwithout.titre }}
                            </span>
                        </span>
                    </small>
                </dd>
                <dd v-if="workflowaction.field_required_without" class="col-sm-8 offset-sm-4">
                    <small>
                        <span class="text-lighter text-red hidden-sm-down">
                            {{ workflowaction.field_required_without_msg }}
                        </span>
                    </small>
                </dd>

                <!--Champs Obligatoire Si les champs sont renseignés-->
                <dt v-if="workflowaction.field_required_with" class="col-sm-4 text-xs"><span class="text-sm">Champs Obligatoire si:</span></dt>
                <dd v-if="workflowaction.field_required_with" class="col-sm-8 text-xs">
                    <small>
                        <span class="text-lighter hidden-sm-down">
                            <span  v-for="(actionwith, index) in workflowaction.actionsrequiredwith" v-if="workflowaction.actionsrequiredwith" class="badge badge-warning">
                                {{ actionwith.titre }}
                            </span>
                        </span>
                    </small>
                </dd>
                <dd v-if="workflowaction.field_required_with" class="col-sm-8 offset-sm-4">
                    <small>
                        <span class="text-lighter text-red hidden-sm-down">
                            {{ workflowaction.field_required_with_msg }}
                        </span>
                    </small>
                </dd>

                <!--Champs Réquis-->
                <dt v-if="!workflowaction.field_required_without && !workflowaction.field_required_with" class="col-sm-4 text-xs">Facultatif ?</dt>
                <dd v-if="!workflowaction.field_required_without && !workflowaction.field_required_with" class="col-sm-8 text-xs">
                    <small>
                        <span class="text-lighter hidden-sm-down">
                            <span v-if="workflowaction.field_required" class="badge badge-pill badge-danger">non</span>
                            <span v-else class="badge badge-pill badge-success">oui</span>
                        </span>
                    </small>
                </dd>
                <dd v-if="!workflowaction.field_required_without && !workflowaction.field_required_with && workflowaction.field_required" class="col-sm-8 offset-sm-4 text-xs">
                    <small>
                        <span class="text-lighter text-red hidden-sm-down">
                            {{ workflowaction.field_required_msg }}
                        </span>
                    </small>
                </dd>
            </dl>

            <b-collapse class="card" :open.sync="isOpen">
                <div slot="trigger" class="card-header">
                    <p class="card-header-title"> Component </p>
                    <a class="card-header-icon">
                        <b-icon :icon="isOpen ? 'arrow_drop_down' : 'arrow_drop_up'"></b-icon>
                    </a>
                </div>
                <div class="card-content">
                    <div class="content">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec iaculis mauris.
                        <a>#buefy</a>.
                    </div>
                </div>
                <footer class="card-footer">
                    <a class="card-footer-item">Save</a>
                    <a class="card-footer-item">Edit</a>
                    <a class="card-footer-item">Delete</a>
                </footer>
            </b-collapse>
        </div>
        <!-- /.card-body -->
    </div>
</template>

<script>
    import ActionBus from "./actionBus";

    export default {
        name: "action-item",
        props: {
            workflowaction_prop: {},
            index_prop: {}
        },
        components: {
        },
        mounted() {
            ActionBus.$on('workflowaction_updated', (upd_data) => {
                if (this.workflowaction.id === upd_data.action.id) {
                    this.updateAction(upd_data.action)
                }
            })
        },
        data() {
            return {
                workflowaction: this.workflowaction_prop,
                index: this.index_prop,
                collapse_icon: 'fas fa-chevron-down',
                isOpen: true
            }
        },
        methods: {
            editAction(workflowaction) {
                axios.get(`/workflowactions.fetchbystep/${workflowaction.workflow_step_id}`)
                    .then((resp => {
                        ActionBus.$emit('workflowaction_edit', workflowaction, resp.data);
                    }));
            },
            updateAction(workflowaction) {
                this.workflowaction = workflowaction
            },
            deleteAction(id, key) {
                this.$swal({
                    html: '<small>Voulez-vous vraiment supprimer cette Action ?</small>',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Non'
                }).then((result) => {
                    if(result.value) {

                        axios.delete(`/workflowactions/${id}`)
                            .then(resp => {

                                let action = resp.data.action
                                let step = resp.data.step

                                console.log('workflowactions delete resp: ', resp)

                                this.$swal({
                                    html: '<small>Action supprimée avec succès !</small>',
                                    icon: 'success',
                                    timer: 3000
                                }).then(() => {
                                    ActionBus.$emit('workflowaction_deleted', {key, action, step})
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
