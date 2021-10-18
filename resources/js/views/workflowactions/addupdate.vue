<template>
    <div class="modal fade" id="addUpdateWorkflowaction" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-sm" id="exampleModalLabel" v-if="editing">Modifier Action</h5>
                    <h5 class="modal-title text-sm" id="exampleModalLabel" v-else>Créer Nouvelle Action</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" @submit.prevent @keydown="workflowactionForm.errors.clear()">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="action_titre" class="col-sm-2 col-form-label text-xs text-xs">Titre</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="action_titre" name="titre" placeholder="Titre" v-model="workflowactionForm.titre">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="workflowactionForm.errors.has('titre')" v-text="workflowactionForm.errors.get('titre')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="m_select_action_type" class="col-sm-2 col-form-label text-xs">Type Action</label>
                                <div class="col-sm-10 text-xs">
                                    <multiselect
                                        id="m_select_action_type"
                                        v-model="workflowactionForm.actiontype"
                                        selected.sync="workflowaction.actiontype"
                                        value=""
                                        :options="workflowactiontypes"
                                        :searchable="true"
                                        :multiple="false"
                                        label="name"
                                        track-by="id"
                                        key="id"
                                        placeholder="Type Action"
                                    >
                                    </multiselect>
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="workflowactionForm.errors.has('actiontype')" v-text="workflowactionForm.errors.get('actiontype')"></span>
                                </div>
                            </div>
                            <div class="form-group row" v-if="workflowactionForm.actiontype.code === 'EnumType'">
                                <div class="col-sm-2"></div>
                                <label for="m_select_enum_type" class="col-sm-2 col-form-label text-xs">Type composé</label>
                                <div class="col-sm-8 text-xs">
                                    <multiselect
                                        id="m_select_enum_type"
                                        v-model="workflowactionForm.enumtype"
                                        selected.sync="workflowaction.enumtype"
                                        value=""
                                        :options="enumtypes"
                                        :searchable="true"
                                        :multiple="false"
                                        label="name"
                                        track-by="id"
                                        key="id"
                                        placeholder="Selectionez le Type Composé"
                                    >
                                    </multiselect>
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="workflowactionForm.errors.has('enumtype')" v-text="workflowactionForm.errors.get('enumtype')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="m_select_treatment_type" class="col-sm-2 col-form-label text-xs">Type Traitement</label>
                                <div class="col-sm-10 text-xs">
                                    <multiselect
                                        id="m_select_treatment_type"
                                        v-model="workflowactionForm.treatmenttype"
                                        selected.sync="workflowaction.treatmenttype"
                                        value=""
                                        :options="workflowtreatmenttypes"
                                        :searchable="true"
                                        :multiple="false"
                                        label="name"
                                        track-by="id"
                                        key="id"
                                        placeholder="Type Traitement"
                                    >
                                    </multiselect>
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="workflowactionForm.errors.has('treatmenttype')" v-text="workflowactionForm.errors.get('treatmenttype')"></span>
                                </div>
                            </div>
                            <div class="form-group row" v-if="workflowactionForm.actiontype &&workflowactionForm.actiontype.code === 'FILE_ref'">
                                <div class="col-sm-2 text-xs">
                                </div>
                                <label for="m_select_action_type_mimetype" class="col-sm-4 col-form-label text-xs">Type(s) de fichier</label>
                                <div class="col-sm-6 text-xs">
                                    <multiselect
                                        id="m_select_action_type_mimetype"
                                        v-model="workflowactionForm.mimetypes"
                                        selected.sync="workflowaction.mimetypes"
                                        value=""
                                        :options="mimetypes"
                                        :searchable="true"
                                        :multiple="true"
                                        label="name"
                                        track-by="id"
                                        key="id"
                                        placeholder="Type(s) fichier"
                                    >
                                    </multiselect>
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="workflowactionForm.errors.has('mimetypes')" v-text="workflowactionForm.errors.get('mimetypes')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="action_description" class="col-sm-2 col-form-label text-xs">Description</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="action_description" name="description" required autocomplete="description" autofocus placeholder="Description" v-model="workflowactionForm.description">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="workflowactionForm.errors.has('description')" v-text="workflowactionForm.errors.get('description')"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input type="checkbox" class="custom-control-input" id="field_required" name="field_required" autocomplete="field_required" autofocus placeholder="Champs Requis ?" v-model="workflowactionForm.field_required">
                                    <label class="custom-control-label" for="field_required"><span class="text text-xs">Champs Requis ?</span></label>
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="workflowactionForm.errors.has('field_required')" v-text="workflowactionForm.errors.get('field_required')"></span>
                                </div>
                            </div>
                            <div class="form-group row" v-if="workflowactionForm.field_required">
                                <label for="field_required_msg" class="col-sm-4 col-form-label text-xs">Message Erreur</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="field_required_msg" name="field_required_msg" autocomplete="field_required_msg" placeholder="Message Erreur" v-model="workflowactionForm.field_required_msg">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="workflowactionForm.errors.has('field_required_msg')" v-text="workflowactionForm.errors.get('field_required_msg')"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input type="checkbox" class="custom-control-input" id="field_required_without" name="field_required_without" autocomplete="field_required_without" autofocus placeholder="Champs Requis sans le(s) champs spécifié(s) ?" v-model="workflowactionForm.field_required_without">
                                    <label class="custom-control-label" for="field_required_without"><span class="text text-xs">Champs Requis sans le(s) champ(s) suivant(s) :</span></label>
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="workflowactionForm.errors.has('field_required_without')" v-text="workflowactionForm.errors.get('field_required_without')"></span>
                                </div>
                            </div>
                            <div class="form-group row" v-if="workflowactionForm.field_required_without">
                                <label for="m_select_action_without" class="col-sm-4 col-form-label text-xs">Liste des champs</label>
                                <div class="col-sm-8 text-xs">
                                    <multiselect
                                        id="m_select_action_without"
                                        v-model="workflowactionForm.actionsrequiredwithout"
                                        selected.sync="workflowaction.actionsrequiredwithout"
                                        value=""
                                        :options="actionsofstep"
                                        :searchable="true"
                                        :multiple="true"
                                        label="titre"
                                        track-by="id"
                                        key="id"
                                        placeholder="Liste d Actions"
                                    >
                                    </multiselect>
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="workflowactionForm.errors.has('actionsrequiredwithout')" v-text="workflowactionForm.errors.get('actionsrequiredwithout')"></span>
                                </div>
                            </div>
                            <div class="form-group row" v-if="workflowactionForm.field_required_without">
                                <label for="field_required_without_msg" class="col-sm-4 col-form-label text-xs">Message Erreur</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="field_required_without_msg" name="field_required_without_msg" autocomplete="field_required_without_msg" placeholder="Message Erreur" v-model="workflowactionForm.field_required_without_msg">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="workflowactionForm.errors.has('field_required_without_msg')" v-text="workflowactionForm.errors.get('field_required_without_msg')"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input type="checkbox" class="custom-control-input" id="field_required_with" name="field_required_with" autocomplete="field_required_with" autofocus placeholder="Champs Requis avec le(s) champs spécifié(s)" v-model="workflowactionForm.field_required_with">
                                    <label class="custom-control-label" for="field_required_with"><span class="text text-xs">Champs Requis avec le(s) champs suivant(s) :</span></label>
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="workflowactionForm.errors.has('field_required_with')" v-text="workflowactionForm.errors.get('field_required_with')"></span>
                                </div>
                            </div>
                            <div class="form-group row" v-if="workflowactionForm.field_required_with">
                                <label for="m_select_action_with" class="col-sm-4 col-form-label text-xs">Liste des champs</label>
                                <div class="col-sm-8 text-xs">
                                    <multiselect
                                        id="m_select_action_with"
                                        v-model="workflowactionForm.actionsrequiredwith"
                                        selected.sync="workflowaction.actionsrequiredwith"
                                        value=""
                                        :options="actionsofstep"
                                        :searchable="true"
                                        :multiple="true"
                                        label="titre"
                                        track-by="id"
                                        key="id"
                                        placeholder="Liste d Actions"
                                    >
                                    </multiselect>
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="workflowactionForm.errors.has('actionsrequiredwith')" v-text="workflowactionForm.errors.get('actionsrequiredwith')"></span>
                                </div>
                            </div>
                            <div class="form-group row" v-if="workflowactionForm.field_required_with">
                                <label for="field_required_with_msg" class="col-sm-4 col-form-label text-xs">Message Erreur</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="field_required_with_msg" name="field_required_with_msg" autocomplete="field_required_with_msg" placeholder="Message Erreur" v-model="workflowactionForm.field_required_with_msg">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="workflowactionForm.errors.has('field_required_with_msg')" v-text="workflowactionForm.errors.get('field_required_with_msg')"></span>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>
                <div class="modal-footer justify-content-between">
                    <b-button type="is-dark" size="is-small" data-dismiss="modal">Fermer</b-button>
                    <b-button type="is-primary" size="is-small" :loading="loading" @click="updateWorkflowaction(workflowstepId)" :disabled="!isValidCreateForm" v-if="editing">Enregistrer</b-button>
                    <b-button type="is-primary" size="is-small" :loading="loading" @click="createWorkflowaction(workflowstepId)" :disabled="!isValidCreateForm" v-else>Créer Action</b-button>
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
    import StepBus from "../workflowsteps/stepBus";

    class Workflowaction {
        constructor(workflowaction) {
            this.titre = workflowaction.titre || ''
            this.description = workflowaction.description || ''
            this.workflow_step_id = workflowaction.workflow_step_id || ''

            this.actiontype = workflowaction.actiontype || ''
            this.enumtype = workflowaction.enumtype || ''
            this.treatmenttype = workflowaction.treatmenttype || ''
            this.mimetypes = workflowaction.mimetypes || ''

            this.field_required = workflowaction.field_required || false
            this.field_required_msg = workflowaction.field_required_msg || ''

            this.field_required_without = workflowaction.field_required_without || false
            this.actionsrequiredwithout = workflowaction.actionsrequiredwithout || ''
            this.field_required_without_msg = workflowaction.field_required_without_msg || ''

            this.field_required_with = workflowaction.field_required_with || false
            this.actionsrequiredwith = workflowaction.actionsrequiredwith || ''
            this.field_required_with_msg = workflowaction.field_required_with_msg || ''
        }
    }
    export default {
        name: "action-addupdate",
        props: {
        },
        components: { Multiselect },
        mounted() {
            ActionBus.$on('workflowaction_create', (workflowstep, actionsofstep) => {

                this.editing = false
                this.workflowstepId = workflowstep.id
                this.workflowaction = new Workflowaction({})
                this.workflowaction.workflow_step_id = workflowstep.id
                this.workflowactionForm = new Form(this.workflowaction)

                this.actionsofstep = actionsofstep

                $('#addUpdateWorkflowaction').modal()
            })

            ActionBus.$on('workflowaction_edit', (workflowaction, actionsofstep) => {
                this.editing = true
                this.workflowaction = new Workflowaction(workflowaction)
                this.workflowactionForm = new Form(this.workflowaction)
                this.workflowactionId = workflowaction.uuid
                this.workflowstepId = workflowaction.workflow_step_id

                this.actionsofstep = actionsofstep

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
            axios.get('/workflowactiontypes.fetch')
                .then(({data}) => this.workflowactiontypes = data);
            axios.get('/workflowtreatmenttypes.fetch')
                .then(({data}) => this.workflowtreatmenttypes = data);
            axios.get('/mimetypes.fetch')
                .then(({data}) => this.mimetypes = data);
            axios.get('/workflowactions.fetchbystep/0')
                .then(({data}) => this.actionsofstep = data);
            axios.get('/enumtypes.fetch')
                .then(({data}) => this.enumtypes = data);
        },
        data() {
            return {
                workflowaction: {},
                workflowstepId: '',
                workflowactionForm: new Form(new Workflowaction({})),
                workflowactionId: null,
                editing: false,
                loading: false,
                workflowactiontypes: [],
                workflowtreatmenttypes: [],
                mimetypes: [],
                actionsofstep: [],
                enumtypes: [],
            }
        },
        methods: {
            createWorkflowaction(workflowstepId) {
                this.loading = true

                //this.workflowactionForm.workflow_step_id = this.workflowactionId
                //console.log("createWorkflowaction", this.workflowactionId, this.workflowactionForm)

                this.workflowactionForm
                    .post('/workflowactions')
                    .then(resp => {
                        this.loading = false
                        // on émet l'action créé dans le bus Action
                        console.log('workflowactions post resp: ', resp)
                        let action = resp.action
                        let step = resp.step

                        $('#addUpdateWorkflowaction').modal('hide')

                        this.$swal({
                            html: '<small>Action créée avec succès !</small>',
                            icon: 'success',
                            timer: 3000
                        }).then(() => {
                            ActionBus.$emit('workflowaction_created', {action, step})
                        })
                    }).catch(error => {
                    this.loading = false
                });
            },
            updateWorkflowaction(workflowstepId) {
                this.loading = true

                this.workflowactionForm
                    .put(`/workflowactions/${this.workflowactionId}`)
                    .then(resp => {
                        this.loading = false
                        let action = resp.action
                        let step = resp.step

                        $('#addUpdateWorkflowaction').modal('hide')

                        this.$swal({
                            html: '<small>Action modifiée avec succès !</small>',
                            icon: 'success',
                            timer: 3000
                        }).then(() => {
                            ActionBus.$emit('workflowaction_updated', {action, step})
                        })
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
