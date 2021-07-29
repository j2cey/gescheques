<template>

    <div id="actionlist">

        <div class="card card-widget" v-for="(action, index) in workflowactions" v-if="workflowactions">
            <div class="card-header">
                <div class="user-block">
                    <span class="text-green text-xs" data-toggle="collapse" data-parent="#actionlist" :href="'#collapse-actions-'+index">
                        {{ action.titre }}
                    </span>
                </div>
                <!-- /.user-block -->
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-toggle="tooltip" @click="editAction(action)">
                        <i class="fa fa-pencil-square-o"></i></button>
                    <button type="button" class="btn btn-tool" data-toggle="collapse" data-parent="#actionlist" :href="'#collapse-actions-'+index"><i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" @click="deleteAction(action.id, index)"><i class="fa fa-trash-o"></i>
                    </button>
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div :id="'collapse-actions-'+index" class="panel-collapse collapse in">
                <div class="card-body" >
                    <dl class="row">
                        <dt class="col-sm-4 text-xs" v-if="action.actiontype">Type Champs</dt>
                        <dd class="col-sm-8 text-xs">{{ action.actiontype.name }}</dd>
                        <dd v-if="action.actiontype &&action.actiontype.code === 'FILE_ref'" class="col-sm-8 offset-sm-4">
                            <small>
                              <span class="text-lighter text-xs hidden-sm-down">
                                  <span  v-for="(mimetype, index) in action.mimetypes" v-if="action.mimetypes" class="badge badge-pill badge-default">
                                      {{ mimetype.name }}
                                  </span>
                              </span>
                            </small>
                        </dd>
                        <dt class="col-sm-4 text-xs">Description</dt>
                        <dd class="col-sm-8 text-xs">{{ action.description }}</dd>

                        <!--Champs Facultatif Si les champs sont renseignés-->
                        <dt v-if="action.field_required_without" class="col-sm-4 text-xs"><span class="text-sm">Champs Facultatif si:</span></dt>
                        <dd v-if="action.field_required_without" class="col-sm-8 text-xs">
                            <small>
                              <span class="text-lighter hidden-sm-down">
                                  <span  v-for="(action, index) in action.actionsrequiredwithout" v-if="action.actionsrequiredwithout" class="badge badge-info">
                                      {{ action.titre }}
                                  </span>
                              </span>
                            </small>
                        </dd>
                        <dd v-if="action.field_required_without" class="col-sm-8 offset-sm-4">
                            <small>
                              <span class="text-lighter text-red hidden-sm-down">
                                {{ action.field_required_without_msg }}
                              </span>
                            </small>
                        </dd>

                        <!--Champs Obligatoire Si les champs sont renseignés-->
                        <dt v-if="action.field_required_with" class="col-sm-4 text-xs"><span class="text-sm">Champs Obligatoire si:</span></dt>
                        <dd v-if="action.field_required_with" class="col-sm-8 text-xs">
                            <small>
                              <span class="text-lighter hidden-sm-down">
                                  <span  v-for="(action, index) in action.actionsrequiredwith" v-if="action.actionsrequiredwith" class="badge badge-warning">
                                      {{ action.titre }}
                                  </span>
                              </span>
                            </small>
                        </dd>
                        <dd v-if="action.field_required_with" class="col-sm-8 offset-sm-4">
                            <small>
                              <span class="text-lighter text-red hidden-sm-down">
                                {{ action.field_required_with_msg }}
                              </span>
                            </small>
                        </dd>

                        <!--Champs Réquis-->
                        <dt v-if="!action.field_required_without && !action.field_required_with" class="col-sm-4 text-xs">Facultatif ?</dt>
                        <dd v-if="!action.field_required_without && !action.field_required_with" class="col-sm-8 text-xs">
                            <small>
                              <span class="text-lighter hidden-sm-down">
                                  <span v-if="action.field_required" class="badge badge-pill badge-danger">non</span>
                                <span v-else class="badge badge-pill badge-success">oui</span>
                              </span>
                            </small>
                        </dd>
                        <dd v-if="!action.field_required_without && !action.field_required_with && action.field_required" class="col-sm-8 offset-sm-4 text-xs">
                            <small>
                              <span class="text-lighter text-red hidden-sm-down">
                                {{ action.field_required_msg }}
                              </span>
                            </small>
                        </dd>
                    </dl>
                </div>
            </div>
            <!-- /.card-body -->
        </div>

    </div>

</template>

<script>
    import ActionBus from "./actionBus";
    import StepBus from "../workflowsteps/stepBus";
    export default {
        name: "actions",
        props: {
            workflowstepid_prop: 0,
            workflowactions_prop: {}
        },
        components: {
        },
        mounted() {

            ActionBus.$on('workflowaction_created', (add_data) => {
                if (this.workflowstepId === add_data.workflowstepId) {
                    this.createAction(add_data.workflowaction)
                }
            })

            ActionBus.$on('workflowaction_updated', (upd_data) => {
                if (this.workflowstepId === upd_data.workflowstepId) {
                    this.updateAction(upd_data.workflowaction)
                }
            })
        },
        data() {
            return {
                workflowstepId: this.workflowstepid_prop,
                workflowactions: this.workflowactions_prop,
            };
        },
        methods: {
            editAction(workflowaction) {
                axios.get(`/workflowactions.fetchbystep/${workflowaction.workflow_step_id}`)
                    .then((resp => {
                        ActionBus.$emit('workflowaction_edit', workflowaction, resp.data);
                    }));
            },
            createAction(workflowaction) {
                let workflowactionIndex = this.workflowactions.findIndex(c => {
                    return workflowaction.id === c.id
                })

                // si cette action n'existe pas déjà, on l'insère dans la liste
                if (workflowactionIndex === -1) {
                    window.noty({
                        message: 'Action créée avec succès',
                        type: 'success'
                    })

                    this.workflowactions.push(workflowaction)
                }
            },
            updateAction(workflowaction) {
                // on récupère l'index de l'action modifiée
                let workflowactionIndex = this.workflowactions.findIndex(c => {
                    return workflowaction.id === c.id
                })

                this.workflowactions.splice(workflowactionIndex, 1, workflowaction)
                window.noty({
                    message: 'Action modifiée avec succès',
                    type: 'success'
                })
            }
        }
    }
</script>

<style scoped>

</style>
