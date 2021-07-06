<template>
    <div class="modal fade" id="addUpdateWorkflowstep" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" v-if="editing">Modifier Etape</h5>
                    <h5 class="modal-title" id="exampleModalLabel" v-else>Créer Nouvelle Etape</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" @submit.prevent @keydown="workflowstepForm.errors.clear()">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="step_titre" class="col-sm-2 col-form-label">Titre</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="step_titre" name="titre" autocomplete="titre" autofocus placeholder="Titre" v-model="workflowstepForm.titre">
                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowstepForm.errors.has('titre')" v-text="workflowstepForm.errors.get('titre')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="m_select_step_actor" class="col-sm-2 col-form-label">Profile Acteur</label>
                                <div class="col-sm-10">
                                    <multiselect
                                        id="m_select_step_actor"
                                        v-model="workflowstepForm.profile"
                                        selected.sync="workflowstep.profile"
                                        value=""
                                        :options="roles"
                                        :searchable="true"
                                        :multiple="false"
                                        label="name"
                                        track-by="id"
                                        key="id"
                                        placeholder="Profile Acteur"
                                    >
                                    </multiselect>
                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowstepForm.errors.has('profile')" v-text="workflowstepForm.errors.get('profile')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="step_description" class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="step_description" name="description" required autocomplete="description" autofocus placeholder="Description" v-model="workflowstepForm.description">
                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowstepForm.errors.has('description')" v-text="workflowstepForm.errors.get('description')"></span>
                                </div>
                            </div>
                            <div class="form-group">
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-primary" @click="updateWorkflowstep(workflowId)" :disabled="!isValidCreateForm" v-if="editing">Enregistrer</button>
                    <button type="button" class="btn btn-primary" @click="createWorkflowstep(workflowId)" :disabled="!isValidCreateForm" v-else>Créer Etape</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'
    import StepBus from './stepBus'
    import ActionBus from "./actions/actionBus";

    class Workflowstep {
        constructor(workflowstep) {
            this.titre = workflowstep.titre || ''
            this.description = workflowstep.description || ''
            this.workflow_id = workflowstep.workflow_id || ''
            this.profile = workflowstep.profile || ''
        }
    }
    export default {
        name: "addupdateStep",
        components: { Multiselect },
        mounted() {
            this.$parent.$on('workflowstep_create', (workflowId) => {

                this.editing = false
                this.workflowId = workflowId
                this.workflowstep = new Workflowstep({})
                this.workflowstep.workflow_id = workflowId
                this.workflowstepForm = new Form(this.workflowstep)

                $('#addUpdateWorkflowstep').modal()
            })

            StepBus.$on('workflowstep_edit', (workflowstep, workflowId) => {
                this.editing = true
                this.workflowstep = new Workflowstep(workflowstep)
                this.workflowstepForm = new Form(this.workflowstep)
                this.workflowstepId = workflowstep.uuid
                this.workflowId = workflowId

                $('#addUpdateWorkflowstep').modal()
            })
        },
        created() {
            axios.get('/roles')
                .then(({data}) => this.roles = data);
        },
        data() {
            return {
                workflowstep: {},
                workflowId: '',
                workflowstepForm: new Form(new Workflowstep({})),
                workflowstepId: null,
                editing: false,
                loading: false,
                roles: []
            }
        },
        methods: {
            createWorkflowstep(workflowId) {
                this.loading = true

                this.workflowstepForm
                    .post('/workflowsteps')
                    .then(workflowstep => {
                        this.loading = false
                        //this.$parent.$emit('new_workflowstep_created', newworkflowstep, this.workflowId)
                        StepBus.$emit('workflowaction_created', {workflowstep, workflowId})
                        $('#addUpdateWorkflowstep').modal('hide')
                    }).catch(error => {
                    this.loading = false
                });
            },
            updateWorkflowstep(workflowId) {
                this.loading = true

                const fd = this.addFileToForm()

                this.workflowstepForm
                    .put(`/workflowsteps/${this.workflowstepId}`, fd)
                    .then(workflowstep => {
                        this.loading = false
                        //let workflowId = this.workflowId
                        StepBus.$emit('workflowstep_updated', {workflowstep, workflowId})
                        $('#addUpdateWorkflowstep').modal('hide')
                    }).catch(error => {
                    this.loading = false
                });
            },
            addFileToForm() {

                if (typeof this.selectedFile !== 'undefined') {
                    const fd = new FormData();
                    fd.append('step_files', this.selectedFile);
                    //console.log("image added", fd);
                    return fd;
                } else {
                    const fd = undefined;
                    //console.log("image not added", fd);
                    return fd;
                }
            },
        },
        computed: {
            roles_comp() {
                return this.roles;
            },
            isValidCreateForm() {
                return !this.loading
            }
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
