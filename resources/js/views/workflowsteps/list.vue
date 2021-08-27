<template>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Liste des Etapes</h3>

            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <b-table
                id="table-transition-example"
                :items="items"
                :fields="fields"
                striped
                small
                primary-key="a"
                :tbody-transition-props="transProps"
            ></b-table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

</template>

<script>
    import StepBus from './stepBus'
    import WorkflowActions from '../workflowactions/list'
    import ActionBus from "../workflowactions/actionBus";
    import draggable from 'vuedraggable'

    let id = 3;

    export default {
        props: {
            workflow: {},
            workflowsteps_prop: {}
        },
        name: "steps",
        display: "Handle",
        instruction: "Drag using the handle icon",
        order: 5,
        components: {
            draggable, WorkflowActions
        },
        mounted() {
            StepBus.$on('workflowaction_created', (add_data) => {
                if (this.workflow.id === add_data.workflowId) {
                    this.createStep(add_data.workflowstep)
                }
            })

            StepBus.$on('workflowstep_updated', (upd_data) => {
                // Step modifiée à mettre à jour sur la liste
                console.log('workflowstep_to_update received at steps.list', upd_data)
                if (this.workflow.id === upd_data.workflowId) {
                    this.updateStep(upd_data.workflowstep)
                }
            })
        },
        data() {
            return {
                workflowsteps: this.workflowsteps_prop,
                enabled: false,
                dragging: false,
                transProps: {
                    // Transition name
                    name: 'flip-list'
                },
                items: [
                    { a: 2, b: 'Two', c: 'Moose' },
                    { a: 1, b: 'Three', c: 'Dog' },
                    { a: 3, b: 'Four', c: 'Cat' },
                    { a: 4, b: 'One', c: 'Mouse' }
                ],
                fields: [
                    { key: 'a', sortable: true },
                    { key: 'b', sortable: true },
                    { key: 'c', sortable: true }
                ]
            };
        },
        computed: {
            draggingInfo() {
                console.log(this.dragging ? "under drag" : "");
            }
        },
        methods: {
            createNewAction(workflowstep) {
                axios.get(`/workflowactions.fetchbystep/${workflowstep.id}`)
                    .then((resp => {
                        ActionBus.$emit('workflowaction_create', workflowstep, resp.data);
                    }));
            },
            editWorkflowstep(workflowstep) {
                axios.get(`/workflowsteps.fetchbyworkflow/${workflowstep.workflow_id}`)
                    .then((resp => {
                        StepBus.$emit('workflowstep_edit', workflowstep, this.workflow, resp.data);
                    }));
            },
            removeAt(idx) {
                this.list.splice(idx, 1);
            },
            add: function() {
                id++;
                this.list.push({ name: "Juan " + id, id, text: "" });
            },
            orderChanged(evt) {
                //console.log('gonna change order',evt, evt.moved.element, evt.moved.oldIndex, evt.moved.newIndex,this.workflowsteps);
                //console.log('lets change order:', this.workflowsteps);
                const fd = undefined;
                let changeForm = new Form({
                    'titre': evt.moved.element.titre,
                    'description': evt.moved.element.description,
                    'workflow_id': evt.moved.element.workflow_id,
                    'profile': evt.moved.element.profile,
                    'posi': evt.moved.newIndex,
                    'oldIndex': evt.moved.oldIndex,
                    'newIndex': evt.moved.newIndex,
                });
                changeForm
                    .put(`/workflowsteps/${evt.moved.element.uuid}`, fd)
                    .then(workflowsteps => {
                        //console.log('orderChanged', workflowsteps);
                        this.workflowsteps = workflowsteps;
                    }).catch(error => {
                    this.loading = false
                });
            },
            createStep(workflowstep) {
                let workflowstepIndex = this.workflowsteps.findIndex(c => {
                    return workflowstep.id === c.id
                })

                // si cette étape n'existe pas déjà, on l'insère dans la liste
                if (workflowstepIndex === -1) {
                    window.noty({
                        message: 'Etape créée avec succès',
                        type: 'success'
                    })

                    this.workflowsteps.push(workflowstep)
                }
            },
            updateStep(workflowstep) {
                // on récupère l'index de session modifiée
                let stepIndex = this.workflowsteps.findIndex(s => {
                    return workflowstep.id === s.id
                })

                this.workflowsteps.splice(stepIndex, 1, workflowstep)

                window.noty({
                    message: 'Etape modifiée avec succès',
                    type: 'success'
                })
            }
        }
    };
</script>
<style scoped>
    table#table-transition-example .flip-list-move {
        transition: transform 1s;
    }
</style>
