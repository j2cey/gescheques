<template>

    <div class="col">

        <draggable tag="ul" :list="workflowsteps"
                   :disabled="!enabled"
                   @change="orderChanged"
                   @start="dragging = true"
                   @end="dragging = false"
                   class="list-group todo-list" handle=".handle" data-widget="todo-list"
        >
            <li
                class="list-group-item"
                v-for="(element, idx) in workflowsteps"
                :key="element.id"
            >
                <i class="fa fa-align-justify handle"></i>

                <span class="text text-sm" data-toggle="collapse" data-parent="#workflowlist" :href="'#collapse-workflowstep-'+element.id">{{ element.titre }}</span>
                <!-- Emphasis label -->
                <small class="badge badge-pill badge-warning" v-if="element.profile"><i class="fa fa-user"></i> {{ element.profile.name }}</small>
                <span v-if="element.actions" class="text text-xs">
                    <small v-if="element.actions.length === 0" class="badge badge-pill badge-danger" ><i class="fa fa-tasks"></i> actions (0)</small>
                    <small v-else class="badge badge-pill badge-success" ><i class="fa fa-tasks"></i> actions ({{ element.actions.length }})</small>
                </span>


                <!-- General tools such as edit or delete-->
                <div class="tools">
                    <i class="fa fa-pencil-square-o" @click="editWorkflowstep(element)"></i>
                    <button type="button" class="btn btn-tool btn-sm" data-toggle="collapse" data-parent="#workflowlist" :href="'#collapse-workflowstep-'+element.id">
                        <i class="fas fa-minus"></i>
                    </button>
                    <i class="fa fa-trash-o"></i>
                </div>

                <!-- Action(s) de l'Etape -->
                <div :id="'collapse-workflowstep-'+element.id" class="panel-collapse collapse in">
                    <div class="card-header">
                        <div class="form-inline float-left">
                            <span class="help-inline pr-1 text-sm"> Action(s) de l'Etape </span>

                            <a class="btn btn-outline-success waves-effect waves-light btn-sm" @click="createNewAction(element)">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <WorkflowActions :workflowstepid_prop="element.id" :workflowactions_prop="element.actions"></WorkflowActions>

                    </div>

                </div>
                <!-- / Action(s) de l'Etape -->

            </li>
        </draggable>
    </div>

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
                enabled: true, // TODO: Nettoyer composant (rétirer les lignes de codes inutiles)
                dragging: false
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
    .button {
        margin-top: 35px;
    }
    .handle {
        float: left;
        padding-top: 8px;
        padding-bottom: 8px;
    }
    .close {
        float: right;
        padding-top: 8px;
        padding-bottom: 8px;
    }
    input {
        display: inline-block;
        width: 50%;
    }
    .text {
        margin: 20px;
    }
</style>
