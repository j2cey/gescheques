<template>
    <div>

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Workflows</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active">Workflows</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="card card-default">
                    <div class="card-header">
                        <div class="form-inline float-left">
                            <span class="help-inline pr-1 text-sm"> Liste des Workflows </span>
                            <b-button size="is-small" type="is-info is-light" @click="createNewWorkflow()"><i class="fas fa-plus"></i></b-button>
                        </div>

                        <div class="card-tools">

                            <div class="input-group input-group-sm" style="width: 150px;">
                                <!--<input type="text" name="table_search" class="form-control float-right" placeholder="Search">-->

                                <!--<div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                </div>-->
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div id="workflowlist">

                            <WorkflowItem v-for="(workflow, index) in workflows" :key="workflow.id" :workflow_prop="workflow" :index_prop="index"></WorkflowItem>

                        </div>
                    </div>
                    <!-- /.card-body -->

                </div>
                <!-- /.card -->

                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->

        <AddUpdateWorflow></AddUpdateWorflow>
    </div>
</template>

<script>
    //import StepBus from './steps/stepBus'
    import AddUpdateWorflow from './addupdate'

    export default {
        name: "workflows-list",
        mounted() {
            this.$on('new_workflow_created', (workflow) => {
                window.noty({
                    message: 'Workflow créé avec succès',
                    type: 'success'
                })
                // insert la nouvelle workflow dans le tableau des workflows
                this.workflows.push(workflow)
            })
        },
        components: {
            WorkflowItem: () => import('../workflows/item'),
            AddUpdateWorflow
        },
        data() {
            return {
                workflows: []
            }
        },
        created() {
            axios.get('/workflows.fetch')
                .then(({data}) => this.workflows = data);
        },
        methods: {
            createNewWorkflow() {
                this.$emit('create_new_workflow')
            },
            createNewStep(workflow) {
                axios.get(`/workflowsteps.fetchbyworkflow/${workflow.id}`)
                    .then((resp => {
                        this.$emit('workflowstep_create', workflow, resp.data)
                    }));
            },
            deleteWorkflow(id, key) {
                if(confirm('Voulez-vous vraiment supprimer ?')) {
                    axios.delete(`/workflows/${id}`)
                        .then(resp => {
                            this.workflows.splice(key, 1)
                            window.noty({
                                message: 'Campagne supprimée avec succès',
                                type: 'success'
                            })
                        }).catch(error => {
                        window.handleErrors(error)
                    })
                }
            }
        }
    }
</script>

<style scoped>

</style>
