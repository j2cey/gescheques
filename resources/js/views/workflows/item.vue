<template>
    <div class="card">
        <header>
            <div class="card-header-title row">
                <div class="col-md-3 col-sm-8 col-12">
                    <span class="text-purple text-sm" @click="collapseClicked()" data-toggle="collapse" data-parent="#workflowlist" :href="'#collapse-workflows-'+index">
                        {{ workflow.titre }}
                    </span>
                </div>
                <div class="col-md-3 col-sm-4 col-12 text-right">
                    <span class="text text-sm">
                        <a type="button" class="btn btn-tool text-success" data-toggle="tooltip" @click="showFlowchart(workflow)">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a type="button" class="btn btn-tool text-warning" data-toggle="tooltip" @click="editWorkflow(workflow)">
                            <i class="fa fa-pencil-square-o"></i>
                        </a>
                        <a type="button" class="btn btn-tool" @click="collapseClicked()" data-toggle="collapse" data-parent="#workflowlist" :href="'#collapse-workflows-'+index">
                            <i :class="currentCollapseIcon"></i>
                        </a>
                        <a type="button" class="btn btn-tool text-danger" @click="deleteWorkflow(workflow.uuid, index)">
                            <i class="fas fa-trash"></i>
                        </a>
                    </span>
                </div>
            </div>
            <!-- /.user-block -->
        </header>
        <!-- /.card-header -->
        <div :id="'collapse-workflows-'+index" class="card-content panel-collapse collapse in">

            <div class="row">
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="card card-default">
                        <div class="card-body">
                            <dt class="text text-xs">Objet</dt>
                            <dd class="text text-xs">{{ workflow.object.model_type }}</dd>
                            <dt class="text text-xs">Description</dt>
                            <dd class="text text-xs">{{ workflow.description }}</dd>
                            <dt class="text text-xs">Date Création</dt>
                            <dd class="text text-xs">{{ workflow.created_at | formatDate}}</dd>
                            <dd class="col-sm-8 offset-sm-4 text-xs"></dd>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-md-9 col-sm-6 col-12">

                    <WorkflowSteps :workflow="workflow" :workflowsteps_prop="workflow.steps"></WorkflowSteps>

                </div>
                <!-- /.col -->
            </div>

        </div>
        <!-- /.card-body -->
        <AddUpdateStep :workflow_prop="workflow"></AddUpdateStep>
    </div>
</template>

<script>
    import WorkflowSteps from "../workflowsteps/list";
    import AddUpdateStep from "../workflowsteps/addupdate";

    import WorkflowBus from "./workflowBus";

    export default {
        name: "workflow-item",
        props: {
            workflow_prop: {},
            index_prop: {}
        },
        components: {
            WorkflowSteps, AddUpdateStep
        },
        mounted() {
            WorkflowBus.$on('workflow_updated', (updworkflow) => {
                if (this.workflow.id === updworkflow.id) {
                    this.workflow = updworkflow
                    window.noty({
                        message: 'Workflow modifié avec succès',
                        type: 'success'
                    })
                }
            })
        },
        created() {

        },
        data() {
            return {
                workflow: this.workflow_prop,
                index: this.index_prop,
                collapse_icon: 'fas fa-chevron-down'
            }
        },
        methods: {
            editWorkflow(workflow) {
                WorkflowBus.$emit('edit_workflow', { workflow })
            },
            showFlowchart(workflow) {
                /*WorkflowBus.$emit('show_flowchart', workflow)*/
                window.location = '/workflows.flowchart/' + workflow.uuid
            },
            deleteWorkflow(id, key) {
                this.$swal({
                    html: '<small>Voulez-vous vraiment supprimer ce Workflow ?</small>',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Non'
                }).then((result) => {
                    if(result.value) {

                        axios.delete(`/workflows/${id}`)
                            .then(resp => {

                                console.log('workflow delete resp: ', resp)

                                this.$swal({
                                    html: '<small>Workflow supprimé avec succès !</small>',
                                    icon: 'success',
                                    timer: 3000
                                }).then(() => {
                                    WorkflowBus.$emit('workflowaction_deleted', {key, resp})
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
