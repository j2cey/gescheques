<template>
    <div class="card card-widget">
        <div class="card-header">
            <div class="user-block">
                <span class="text-purple text-sm" data-toggle="collapse" data-parent="#workflowlist" :href="'#collapse-workflows-'+index">
                    {{ workflow.titre }}
                </span>
            </div>
            <!-- /.user-block -->
            <div class="card-tools">
                <button type="button" class="btn btn-tool text-success" data-toggle="tooltip" @click="showFlowchart(workflow)">
                    <i class="fa fa-eye"></i>
                </button>
                <button type="button" class="btn btn-tool" data-toggle="tooltip" @click="editWorkflow(workflow)">
                    <i class="fa fa-pencil-square-o"></i>
                </button>
                <button type="button" class="btn btn-tool" data-toggle="collapse" data-parent="#workflowlist" :href="'#collapse-workflows-'+index"><i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool text-danger" @click="deleteWorkflow(workflow.uuid, index)"><i class="fa fa-trash-o"></i>
                </button>
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div :id="'collapse-workflows-'+index" class="card-body panel-collapse collapse in">

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

                    <liststepbtable></liststepbtable>

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
    import liststepbtable from "../workflowsteps/stepsbtable";

    import WorkflowBus from "./workflowBus";

    export default {
        name: "item",
        props: {
            workflow_prop: {},
            index_prop: {}
        },
        components: {
            WorkflowSteps, AddUpdateStep, liststepbtable
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
            }
        },
        methods: {
            editWorkflow(workflow) {
                WorkflowBus.$emit('edit_workflow', { workflow })
            },
            showFlowchart(workflow) {
                /*WorkflowBus.$emit('show_flowchart', workflow)*/
                window.location = '/workflows.flowchart/' + workflow.id
            }
        }
    }
</script>

<style scoped>

</style>
