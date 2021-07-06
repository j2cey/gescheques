<template>
    <div class="modal fade" id="addUpdateWorkflowaction" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" v-if="editing">Modifier Action</h5>
                    <h5 class="modal-title" id="exampleModalLabel" v-else>Créer Nouvelle Action</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" @submit.prevent @keydown="workflowactionForm.errors.clear()">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="action_titre" class="col-sm-2 col-form-label">Titre</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="action_titre" name="titre" placeholder="Titre" v-model="workflowactionForm.titre">
                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowactionForm.errors.has('titre')" v-text="workflowactionForm.errors.get('titre')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="m_select_action_type" class="col-sm-2 col-form-label">Type Action</label>
                                <div class="col-sm-10">
                                    <multiselect
                                        id="m_select_action_type"
                                        v-model="workflowactionForm.type"
                                        selected.sync="workflowaction.type"
                                        value=""
                                        :options="types"
                                        :searchable="true"
                                        :multiple="false"
                                        label="titre"
                                        track-by="id"
                                        key="id"
                                        placeholder="Type Action"
                                    >
                                    </multiselect>
                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowactionForm.errors.has('type')" v-text="workflowactionForm.errors.get('type')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="m_select_action_field" class="col-sm-2 col-form-label">Champs Objet</label>
                                <div class="col-sm-10">
                                    <multiselect
                                        id="m_select_action_field"
                                        v-model="workflowactionForm.objectfield"
                                        selected.sync="workflowaction.objectfield"
                                        value=""
                                        :options="objectfields"
                                        :searchable="true"
                                        :multiple="false"
                                        label="field_label"
                                        track-by="id"
                                        key="id"
                                        placeholder="Champs Objet"
                                    >
                                    </multiselect>
                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowactionForm.errors.has('objectfield')" v-text="workflowactionForm.errors.get('objectfield')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="action_description" class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="action_description" name="description" required autocomplete="description" autofocus placeholder="Description" v-model="workflowactionForm.description">
                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowactionForm.errors.has('description')" v-text="workflowactionForm.errors.get('description')"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="field_required" name="field_required" autocomplete="field_required" autofocus placeholder="Champs Requis ?" v-model="workflowactionForm.field_required">
                                    <label class="form-check-label" for="field_required">Champs Requis ?</label>
                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowactionForm.errors.has('field_required')" v-text="workflowactionForm.errors.get('field_required')"></span>
                                </div>
                            </div>
                            <div class="form-group row" v-if="workflowactionForm.field_required">
                                <label for="field_required_msg" class="col-sm-2 col-form-label">Message Erreur</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="field_required_msg" name="field_required_msg" autocomplete="field_required_msg" placeholder="Message Erreur" v-model="workflowactionForm.field_required_msg">
                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowactionForm.errors.has('field_required_msg')" v-text="workflowactionForm.errors.get('field_required_msg')"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="field_required_without" name="field_required_without" autocomplete="field_required_without" autofocus placeholder="Champs Requis sans le(s) champs spécifié(s) ?" v-model="workflowactionForm.field_required_without">
                                    <label class="form-check-label" for="field_required_without">Champs Requis sans le(s) champ(s) suivant(s) :</label>
                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowactionForm.errors.has('field_required_without')" v-text="workflowactionForm.errors.get('field_required_without')"></span>
                                </div>
                            </div>
                            <div class="form-group row" v-if="workflowactionForm.field_required_without">
                                <label for="m_select_action_field" class="col-sm-2 col-form-label">Liste des champs</label>
                                <div class="col-sm-10">
                                    <multiselect
                                        id="m_select_without_field"
                                        v-model="workflowactionForm.fieldsrequiredwithout"
                                        selected.sync="workflowaction.fieldsrequiredwithout"
                                        value=""
                                        :options="objectfields"
                                        :searchable="true"
                                        :multiple="true"
                                        label="field_label"
                                        track-by="id"
                                        key="id"
                                        placeholder="Liste des champs"
                                    >
                                    </multiselect>
                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowactionForm.errors.has('fieldsrequiredwithout')" v-text="workflowactionForm.errors.get('fieldsrequiredwithout')"></span>
                                </div>
                            </div>
                            <div class="form-group row" v-if="workflowactionForm.field_required_without">
                                <label for="field_required_without_msg" class="col-sm-2 col-form-label">Message Erreur</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="field_required_without_msg" name="field_required_without_msg" autocomplete="field_required_without_msg" placeholder="Message Erreur" v-model="workflowactionForm.field_required_without_msg">
                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowactionForm.errors.has('field_required_without_msg')" v-text="workflowactionForm.errors.get('field_required_without_msg')"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="field_required_with" name="field_required_with" autocomplete="field_required_with" autofocus placeholder="Champs Requis avec le(s) champs spécifié(s)" v-model="workflowactionForm.field_required_with">
                                    <label class="form-check-label" for="field_required_with">Champs Requis avec le(s) champs suivant(s) :</label>
                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowactionForm.errors.has('field_required_with')" v-text="workflowactionForm.errors.get('field_required_with')"></span>
                                </div>
                            </div>
                            <div class="form-group row" v-if="workflowactionForm.field_required_with">
                                <label for="m_select_action_field" class="col-sm-2 col-form-label">Liste des champs</label>
                                <div class="col-sm-10">
                                    <multiselect
                                        id="m_select_with_field"
                                        v-model="workflowactionForm.fieldsrequiredwith"
                                        selected.sync="workflowaction.fieldsrequiredwith"
                                        value=""
                                        :options="objectfields"
                                        :searchable="true"
                                        :multiple="true"
                                        label="field_label"
                                        track-by="id"
                                        key="id"
                                        placeholder="Liste des champs"
                                    >
                                    </multiselect>
                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowactionForm.errors.has('fieldsrequiredwith')" v-text="workflowactionForm.errors.get('fieldsrequiredwith')"></span>
                                </div>
                            </div>
                            <div class="form-group row" v-if="workflowactionForm.field_required_with">
                                <label for="field_required_with_msg" class="col-sm-2 col-form-label">Message Erreur</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="field_required_with_msg" name="field_required_with_msg" autocomplete="field_required_with_msg" placeholder="Message Erreur" v-model="workflowactionForm.field_required_with_msg">
                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowactionForm.errors.has('field_required_with_msg')" v-text="workflowactionForm.errors.get('field_required_with_msg')"></span>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-primary" @click="updateWorkflowaction(workflowstepId)" :disabled="!isValidCreateForm" v-if="editing">Enregistrer</button>
                    <button type="button" class="btn btn-primary" @click="createWorkflowaction(workflowstepId)" :disabled="!isValidCreateForm" v-else>Créer Action</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'
    import ActionBus from "./actionBus";

    class Workflowaction {
        constructor(workflowaction) {
            this.titre = workflowaction.titre || ''
            this.description = workflowaction.description || ''
            this.workflow_step_id = workflowaction.workflow_step_id || ''
            this.type = workflowaction.type || ''
            this.objectfield = workflowaction.objectfield || ''

            this.field_required = workflowaction.field_required || ''
            this.field_required_msg = workflowaction.field_required_msg || ''

            this.field_required_without = workflowaction.field_required_without || ''
            this.fieldsrequiredwithout = workflowaction.fieldsrequiredwithout || ''
            this.field_required_without_msg = workflowaction.field_required_without_msg || ''

            this.field_required_with = workflowaction.field_required_with || ''
            this.fieldsrequiredwith = workflowaction.fieldsrequiredwith || ''
            this.field_required_with_msg = workflowaction.field_required_with_msg || ''
        }
    }
    export default {
        name: "addupdateAction",
        props: {
        },
        components: { Multiselect },
        mounted() {
            ActionBus.$on('workflowaction_create', (create_data) => {

                this.editing = false
                this.workflowstepId = create_data.workflowstepId
                this.workflowaction = new Workflowaction({})
                this.workflowaction.workflow_step_id = create_data.workflowstepId
                this.workflowactionForm = new Form(this.workflowaction)

                $('#addUpdateWorkflowaction').modal()
            })

            ActionBus.$on('workflowaction_edit', (edit_data) => {
                this.editing = true
                this.workflowaction = new Workflowaction(edit_data.workflowaction)
                this.workflowactionForm = new Form(this.workflowaction)
                this.workflowactionId = edit_data.workflowaction.uuid
                this.workflowstepId = edit_data.workflowstepId

                $('#addUpdateWorkflowaction').modal()
            })

            this.$parent.$on('create_new_workflowaction', (workflowstepId) => {

                console.log('create_new_workflowaction--received', workflowstepId)

                this.editing = false
                this.workflowstepId = workflowstepId
                this.workflowaction = new Workflowaction({})
                this.workflowaction.workflow_step_id = workflowstepId
                this.workflowactionForm = new Form(this.workflowaction)

                $('#addUpdateWorkflowaction').modal()
            })

            this.$parent.$on('edit_workflowaction', ({ workflowaction }) => {
                this.editing = true
                this.workflowaction = new Workflowaction(workflowaction)
                this.workflowactionForm = new Form(this.workflowaction)
                this.workflowactionId = workflowaction.uuid
                this.workflowstepId = workflowaction.workflow_step_id

                $('#addUpdateWorkflowaction').modal()
            })
        },
        created() {
            axios.get('/workflowactiontypes')
                .then(({data}) => this.types = data);

            axios.get('/workflowobjectfields')
                .then(({data}) => this.objectfields = data);
        },
        data() {
            return {
                workflowaction: {},
                workflowstepId: '',
                workflowactionForm: new Form(new Workflowaction({})),
                workflowactionId: null,
                editing: false,
                loading: false,
                types: [],
                objectfields: []
            }
        },
        methods: {
            createWorkflowaction(workflowstepId) {
                this.loading = true

                //this.workflowactionForm.workflow_step_id = this.workflowactionId
                //console.log("createWorkflowaction", this.workflowactionId, this.workflowactionForm)

                this.workflowactionForm
                    .post('/workflowactions')
                    .then(workflowaction => {
                        this.loading = false
                        // on émet l'action créé dans le bus Action
                        ActionBus.$emit('workflowaction_created', {workflowaction, workflowstepId})
                        $('#addUpdateWorkflowaction').modal('hide')
                    }).catch(error => {
                    this.loading = false
                });
            },
            updateWorkflowaction(workflowstepId) {
                this.loading = true

                this.workflowactionForm
                    .put(`/workflowactions/${this.workflowactionId}`)
                    .then(workflowaction => {
                        this.loading = false
                        ActionBus.$emit('workflowaction_updated', {workflowaction, workflowstepId})
                        $('#addUpdateWorkflowaction').modal('hide')
                    }).catch(error => {
                    this.loading = false
                });
            }
        },
        computed: {
            isValidCreateForm() {
                return !this.loading
            }
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
