<template>
    <div class="modal fade" id="addUpdateWorkflowstep" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-sm" id="exampleModalLabel" v-if="editing">Modifier Etape</h5>
                    <h5 class="modal-title text-sm" id="exampleModalLabel" v-else>Créer Nouvelle Etape</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" @submit.prevent @keydown="workflowstepForm.errors.clear()">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="step_titre" class="col-sm-2 col-form-label text-xs">Titre</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="step_titre" name="titre" autocomplete="titre" autofocus placeholder="Titre" v-model="workflowstepForm.titre">
                                    <span class=" invalid-feedback d-block text-xs" role="alert" v-if="workflowstepForm.errors.has('titre')" v-text="workflowstepForm.errors.get('titre')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="step_description" class="col-sm-2 col-form-label text-xs">Description</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="step_description" name="description" required autocomplete="description" autofocus placeholder="Description" v-model="workflowstepForm.description">
                                    <span class=" invalid-feedback d-block text-xs" role="alert" v-if="workflowstepForm.errors.has('description')" v-text="workflowstepForm.errors.get('description')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="custom-control custom-radio col-sm-4">
                                    <input type="radio" class="custom-control-input" id="role_static" name="role_type" autocomplete="role_static" autofocus placeholder="Profile Fixe" v-model="workflowstepForm.role_type" @change="roleTypeChange($event)" value="role_static">
                                    <label for="role_static" class="custom-control-label"><span class="text text-xs">Profile(s) fixe :</span></label>
                                    <span class=" invalid-feedback d-block text-xs" role="alert" v-if="workflowstepForm.errors.has('role_static')" v-text="workflowstepForm.errors.get('role_static')"></span>
                                </div>
                                <div class="col-sm-8" v-if="can_role_static">
                                    <multiselect class="text text-xs"
                                         id="m_select_step_actor"
                                         v-model="workflowstepForm.staticapprovers"
                                         selected.sync="workflowstep.staticapprovers"
                                         value=""
                                         :options="roles"
                                         :searchable="true"
                                         :multiple="true"
                                         label="name"
                                         track-by="id"
                                         key="id"
                                         placeholder="Profile(s) Acteur"
                                    >
                                    </multiselect>
                                    <span class=" invalid-feedback d-block text-xs" role="alert" v-if="workflowstepForm.errors.has('staticapprovers')" v-text="workflowstepForm.errors.get('staticapprovers')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="custom-control custom-radio col-sm-4">
                                    <input type="radio" class="custom-control-input" id="role_dynamic" name="role_type" autocomplete="role_dynamic" autofocus placeholder="Profile Dynamique" v-model="workflowstepForm.role_type" @change="roleTypeChange($event)" value="role_dynamic">
                                    <label for="role_dynamic" class="custom-control-label"><span class="text text-xs">Profile Dynamique</span></label>
                                    <span class=" invalid-feedback d-block text-xs" role="alert" v-if="workflowstepForm.errors.has('role_dynamic')" v-text="workflowstepForm.errors.get('role_dynamic')"></span>
                                </div>
                                <div class="col-sm-8" v-if="workflowstepForm.role_dynamic">
                                    <input type="text" class="form-control form-control-sm" id="role_dynamic_label" name="role_dynamic_label" autocomplete="role_dynamic_label" autofocus placeholder="Libellé du Profile" v-model="workflowstepForm.role_dynamic_label">
                                    <span class=" invalid-feedback d-block text-xs" role="alert" v-if="workflowstepForm.errors.has('role_dynamic_label')" v-text="workflowstepForm.errors.get('role_dynamic_label')"></span>
                                </div>
                            </div>
                            <div class="form-group row" v-if="workflowstepForm.role_dynamic">
                                <div class="col-sm-4">
                                </div>
                                <div class="col-sm-8" v-if="workflowstepForm.role_dynamic">
                                    <input type="text" class="form-control form-control-sm" id="role_dynamic_previous_label" name="role_dynamic_label" autocomplete="role_dynamic_previous_label" autofocus placeholder="Libellé du profile Précédent" v-model="workflowstepForm.role_dynamic_previous_label">
                                    <span class=" invalid-feedback d-block text-xs" role="alert" v-if="workflowstepForm.errors.has('role_dynamic_previous_label')" v-text="workflowstepForm.errors.get('role_dynamic_previous_label')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="custom-control custom-radio col-sm-6">
                                    <input type="radio" class="custom-control-input" id="role_previous" name="role_type" autocomplete="role_previous" autofocus placeholder="Profile Identique à l'Etape précédente" v-model="workflowstepForm.role_type" @change="roleTypeChange($event)" value="role_previous">
                                    <label for="role_previous" class="custom-control-label"><span class="text text-xs">Profile Identique à l'Etape précédente</span></label>
                                    <span class=" invalid-feedback d-block text-xs" role="alert" v-if="workflowstepForm.errors.has('role_previous')" v-text="workflowstepForm.errors.get('role_previous')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="m_select_validatednextstep" class="col-sm-4 col-form-label text-xs">Prochaine Etape après Validation</label>
                                <div class="col-sm-8 text-xs">
                                    <multiselect class="text text-xs"
                                        :disabled="true"
                                        id="m_select_validatednextstep"
                                        v-model="workflowstepForm.transitionpassstep"
                                        selected.sync="workflowstep.transitionpassstep"
                                        value="" deselectLabel="Touche Entrer pour retirer"
                                        :options="workflowsteps"
                                        :searchable="true"
                                        :multiple="false"
                                        label="titre"
                                        track-by="id"
                                        key="id"
                                        placeholder="Etape après validation"
                                    >
                                    </multiselect>
                                    <span class=" invalid-feedback d-block text-xs" role="alert" v-if="workflowstepForm.errors.has('transitionpassstep')" v-text="workflowstepForm.errors.get('transitionpassstep')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="m_select_rejectednextstep" class="col-sm-4 col-form-label text-xs">Prochaine Etape après Réjet</label>
                                <div class="col-sm-8">
                                    <multiselect class="text-xs"
                                        id="m_select_rejectednextstep"
                                        :disabled="true"
                                        v-model="workflowstepForm.transitionrejectstep"
                                        selected.sync="workflowstep.transitionrejectstep"
                                        value=""
                                        :options="workflowsteps"
                                        :searchable="true"
                                        :multiple="false"
                                        label="titre"
                                        track-by="id"
                                        key="id"
                                        placeholder="Etape après réjet"
                                    >
                                    </multiselect>
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="workflowstepForm.errors.has('transitionrejectstep')" v-text="workflowstepForm.errors.get('transitionrejectstep')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-4">
                                    <input type="checkbox" class="custom-control-input" id="can_expire" name="can_expire" autocomplete="can_expire" v-model="workflowstepForm.can_expire">
                                    <label class="custom-control-label" for="can_expire"><span class="text text-xs">Peux Expirer</span></label>
                                    <span class=" invalid-feedback d-block text-xs" role="alert" v-if="workflowstepForm.errors.has('can_expire')" v-text="workflowstepForm.errors.get('can_expire')"></span>
                                </div>
                            </div>
                            <div class="form-group row" v-if="workflowstepForm.can_expire">
                                <div class="col col-sm-4"></div>
                                <div class="input-group input-group-sm mb-3 col-sm-4">
                                    <input type="text" class="form-control form-control-sm text-left" id="expire_hours" name="expire_hours" autocomplete="expire_hours" autofocus placeholder="validité (hrs)" v-model="workflowstepForm.expire_hours">
                                    <div class="input-group-append">
                                        <span class="input-group-text">hrs</span>
                                    </div>
                                    <span class=" invalid-feedback d-block text-xs" role="alert" v-if="workflowstepForm.errors.has('expire_hours')" v-text="workflowstepForm.errors.get('expire_hours')"></span>
                                </div>
                                <div class="input-group input-group-sm mb-3 col-sm-4">
                                    <input type="text" class="form-control form-control-sm" id="expire_days" name="expire_days" autocomplete="expire_days" autofocus placeholder="validité (jrs)" v-model="workflowstepForm.expire_days">
                                    <div class="input-group-append">
                                        <span class="input-group-text">jrs</span>
                                    </div>
                                    <span class=" invalid-feedback d-block text-xs" role="alert" v-if="workflowstepForm.errors.has('expire_days')" v-text="workflowstepForm.errors.get('expire_days')"></span>
                                </div>
                            </div>
                            <div class="form-group row" v-if="workflowstepForm.can_expire">
                                <div class="col col-sm-4"></div>
                                <div class="col-sm-8">
                                    <multiselect class="text-xs"
                                         id="m_select_expirednextstep"
                                         v-model="workflowstepForm.transitionexpirestep"
                                         selected.sync="workflowstep.transitionexpirestep"
                                         :disabled="true"
                                         value=""
                                         :options="workflowsteps"
                                         :searchable="true"
                                         :multiple="false"
                                         label="titre"
                                         track-by="id"
                                         key="id"
                                         placeholder="Prochaine Etape après expiration"
                                    >
                                    </multiselect>
                                    <span class=" invalid-feedback d-block text-xs" role="alert" v-if="workflowstepForm.errors.has('transitionexpirestep')" v-text="workflowstepForm.errors.get('transitionexpirestep')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-4">
                                    <input type="checkbox" class="custom-control-input" id="notify_to_approvers" name="notify_to_approvers" autocomplete="notify_to_approvers" autofocus placeholder="Notifier les Acteurs" v-model="workflowstepForm.notify_to_approvers">
                                    <label class="custom-control-label" for="notify_to_approvers"><span class="text text-xs">Notifier les Acteurs <i class="far fa-bell"></i></span></label>
                                    <span class=" invalid-feedback d-block text-xs" role="alert" v-if="workflowstepForm.errors.has('notify_to_approvers')" v-text="workflowstepForm.errors.get('notify_to_approvers')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-4">
                                    <input type="checkbox" class="custom-control-input" id="notify_to_others" name="notify_to_others" autocomplete="notify_to_others" autofocus placeholder="Notifier d'Autres Utilisateurs" v-model="workflowstepForm.notify_to_others">
                                    <label class="custom-control-label" for="notify_to_others"><span class="text text-xs">Notifier d'Autres Utilisateurs <i class="far fa-bell"></i></span></label>
                                    <span class=" invalid-feedback d-block text-xs" role="alert" v-if="workflowstepForm.errors.has('notify_to_others')" v-text="workflowstepForm.errors.get('notify_to_others')"></span>
                                </div>
                                <div class="col-sm-8" v-if="workflowstepForm.notify_to_others">
                                    <multiselect class="text-xs"
                                         id="m_select_otherstonotify"
                                         v-model="workflowstepForm.otherstonotify"
                                         selected.sync="workflowstep.otherstonotify"
                                         value=""
                                         :options="users"
                                         :searchable="true"
                                         :multiple="true"
                                         label="name"
                                         track-by="id"
                                         key="id"
                                         placeholder="Autres Utilisateurs à Notifier"
                                    >
                                    </multiselect>
                                    <span class=" invalid-feedback d-block text-xs" role="alert" v-if="workflowstepForm.errors.has('otherstonotify')" v-text="workflowstepForm.errors.get('otherstonotify')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="m_select_stepparent" class="col-sm-4 col-form-label text-xs text-orange">Etape Parent</label>
                                <div class="col-sm-8">
                                    <multiselect class="text-xs"
                                         id="m_select_stepparent"
                                         v-model="workflowstepForm.stepparent"
                                         selected.sync="workflowstep.stepparent"
                                         value=""
                                         :options="workflowsteps"
                                         :searchable="true"
                                         :multiple="false"
                                         label="titre"
                                         track-by="id"
                                         key="id"
                                         placeholder="Etape Parent"
                                    >
                                    </multiselect>
                                    <span class=" invalid-feedback d-block text-xs" role="alert" v-if="workflowstepForm.errors.has('stepparent')" v-text="workflowstepForm.errors.get('stepparent')"></span>
                                </div>
                            </div>

                            <div class="form-group row" id="flowchartattributes">
                                <div class="col">
                                    <div class="card">
                                        <header>
                                            <div class="card-header-title row">
                                                <div class="col-md-6 col-sm-8 col-12">
                                                <span class="text-danger text-xs" @click="collapseFlowchartClicked()" data-toggle="collapse" data-parent="#flowchartattributes" :href="'#collapse-flowchart-'+workflowstep.id">
                                                    Design Diagramme
                                                </span>
                                                </div>
                                                <div class="col-md-6 col-sm-4 col-12 text-right">
                                                <span class="text text-sm">
                                                    <a type="button" class="btn btn-tool" @click="collapseFlowchartClicked()" data-toggle="collapse" data-parent="#flowchartattributes" :href="'#collapse-flowchart-'+workflowstep.id">
                                                        <i :class="currentFlowchartCollapseIcon"></i>
                                                    </a>
                                                </span>
                                                </div>
                                            </div>
                                        </header>
                                        <!-- /.card-header -->
                                        <div :id="'collapse-flowchart-'+workflowstep.id" class="card-content panel-collapse collapse in">
                                            <b-field grouped group-multiline>
                                                <b-field label="Class de Style" label-position="on-border" custom-class="is-small">
                                                    <b-input size="is-small" v-model="workflowstepForm.stylingClass"></b-input>
                                                </b-field>
                                            </b-field>
                                            <br>
                                            <b-field grouped group-multiline>
                                                <b-field label="Position X" label-position="on-border" custom-class="is-small"
                                                         :type="workflowstepForm.errors.has('flowchart_position_x') ? 'is-danger' : ''"
                                                         :message="workflowstepForm.errors.get('flowchart_position_x')">
                                                    <b-input name="flowchart_position_x"
                                                        type="number" size="is-small" v-model="workflowstepForm.flowchart_position_x"></b-input>
                                                </b-field>
                                                <b-field label="Position Y" label-position="on-border" custom-class="is-small"
                                                         :type="workflowstepForm.errors.has('flowchart_position_y') ? 'is-danger' : ''"
                                                         :message="workflowstepForm.errors.get('flowchart_position_y')">
                                                    <b-input name="flowchart_position_y"
                                                        type="number" size="is-small" v-model="workflowstepForm.flowchart_position_y"></b-input>
                                                </b-field>
                                                <b-field label="Largeur du box" label-position="on-border" custom-class="is-small"
                                                         :type="workflowstepForm.errors.has('flowchart_size_width') ? 'is-danger' : ''"
                                                         :message="workflowstepForm.errors.get('flowchart_size_width')"
                                                >
                                                    <b-input name="flowchart_size_width"
                                                        type="number" size="is-small" v-model="workflowstepForm.flowchart_size_width"
                                                    ></b-input>
                                                </b-field>
                                                <b-field label="Hauteur du box" label-position="on-border" custom-class="is-small"
                                                         :type="workflowstepForm.errors.has('flowchart_size_height') ? 'is-danger' : ''"
                                                         :message="workflowstepForm.errors.get('flowchart_size_height')">
                                                    <b-input name="flowchart_size_height"
                                                        type="number" size="is-small" v-model="workflowstepForm.flowchart_size_height"
                                                    ></b-input>
                                                </b-field>
                                            </b-field>
                                            <hr>
                                            <b-field grouped group-multiline>
                                                <b-button label="Valider" type="is-danger is-light" size="is-small" :loading="loading" @click="updateFlowchartNode(workflow.id)" />
                                            </b-field>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer justify-content-between">
                    <b-button type="is-dark" size="is-small" data-dismiss="modal">Fermer</b-button>
                    <b-button type="is-primary" size="is-small" :loading="loading" @click="updateWorkflowstep(workflow.id)" :disabled="!isValidCreateForm" v-if="editing">Enregistrer</b-button>
                    <b-button type="is-primary" size="is-small" :loading="loading" @click="createWorkflowstep(workflow.id)" :disabled="!isValidCreateForm" v-else>Créer Etape</b-button>
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
    import ChequeBus from "../cheques/chequeBus";
    //import ActionBus from "../workflowactions/actionBus";

    class Workflowstep {
        constructor(workflowstep) {
            this.titre = workflowstep.titre || ''
            this.description = workflowstep.description || ''
            this.workflow_id = workflowstep.workflow_id || ''
            this.staticapprovers = workflowstep.staticapprovers || ''
            this.role_static = workflowstep.role_static || 0
            this.role_dynamic = workflowstep.role_dynamic || 0
            this.role_dynamic_label = workflowstep.role_dynamic_label || ''
            this.role_dynamic_previous_label = workflowstep.role_dynamic_previous_label || ''
            this.role_previous = workflowstep.role_previous || 0
            this.role_type = (workflowstep.role_static ? 'role_static' : (workflowstep.role_dynamic ? 'role_dynamic' : (workflowstep.role_previous ? 'role_previous' : 'role_static' ) ) ) || 'undefied'
            this.transitionpassstep = workflowstep.transitionpassstep || ''
            this.transitionrejectstep = workflowstep.transitionrejectstep || ''
            this.transitionexpirestep = workflowstep.transitionexpirestep || ''
            this.can_expire = workflowstep.can_expire || false
            this.expire_hours = workflowstep.expire_hours || 0
            this.expire_days = workflowstep.expire_days || 0
            this.transitionexpirestep = workflowstep.transitionexpirestep || ''
            this.notify_to_approvers = workflowstep.notify_to_approvers || false
            this.notify_to_others = workflowstep.notify_to_others || false
            this.otherstonotify = workflowstep.otherstonotify || ''
            this.stepparent = workflowstep.stepparent || ''

            this.stylingClass = workflowstep.stylingClass || ''
            this.flowchart_position_x = workflowstep.flowchart_position_x || ''
            this.flowchart_position_y = workflowstep.flowchart_position_y || ''
            this.flowchart_size_width = workflowstep.flowchart_size_width || ''
            this.flowchart_size_height = workflowstep.flowchart_size_height || ''
        }
    }
    export default {
        name: "step-addupdate",
        props: {
            workflow_prop: {},
        },
        components: { Multiselect },
        mounted() {
            this.$parent.$on('workflowstep_create', (workflow, workflowsteps) => {
                console.log('workflowstep_create received', workflowsteps)
                this.editing = false
                this.workflow = workflow
                this.workflowsteps = workflowsteps
                this.workflowstep = new Workflowstep({})
                this.workflowstepForm = new Form(this.workflowstep)

                this.workflowstep.workflow_id = workflow.id

                $('#addUpdateWorkflowstep').modal()
            })

            StepBus.$on('workflowstep_edit', (workflowstep, workflow, workflowsteps) => {
                console.log('workflowstep_edit received', workflowsteps)
                this.editing = true
                this.workflow = workflow
                this.workflowsteps = workflowsteps
                this.workflowstep = new Workflowstep(workflowstep)
                this.workflowstepForm = new Form(this.workflowstep)

                this.workflowstepId = workflowstep.uuid

                $('#addUpdateWorkflowstep').modal()
            })
        },
        created() {
            axios.get('/roles')
                .then(({data}) => this.roles = data);
            axios.get('/users.fetchall')
                .then(({data}) => this.users = data);
            axios.get('/workflowsteps.fetchbyworkflow/0')
                .then(({data}) => this.workflowsteps = data);
        },
        data() {
            return {
                workflowstep: {},
                workflowsteps: [],
                workflow: {},
                workflowstepForm: new Form(new Workflowstep({})),
                workflowstepId: null,
                editing: false,
                loading: false,
                roles: [],
                users: [],
                flowchart_collapse_icon: 'fas fa-chevron-down'
            }
        },
        methods: {
            initForm(editing, workflowstep) {
                this.editing = editing
                if (editing) {
                    this.workflowstep = new Workflowstep(workflowstep)
                    this.workflowstepForm = new Form(this.workflowstep)
                } else {
                    this.workflowstep = new Workflowstep({})
                    this.workflowstepForm = new Form(this.workflowstep)
                }
            },
            createWorkflowstep(workflowId) {
                this.loading = true

                this.updateRoleType();

                this.workflowstepForm
                    .post('/workflowsteps')
                    .then(workflowstep => {
                        this.loading = false

                        $('#addUpdateWorkflowstep').modal('hide')

                        this.$swal({
                            html: '<small>Etape créée avec succès !</small>',
                            icon: 'success',
                            timer: 3000
                        }).then(() => {
                            StepBus.$emit('workflowaction_created', {workflowstep, workflowId})
                        })
                    }).catch(error => {
                    this.loading = false
                });
            },
            updateWorkflowstep(workflowId) {
                this.loading = true

                this.updateRoleType();

                const fd = this.addFileToForm()

                this.workflowstepForm
                    .put(`/workflowsteps/${this.workflowstepId}`, fd)
                    .then(workflowstep => {
                        this.loading = false

                        $('#addUpdateWorkflowstep').modal('hide')
                        this.$swal({
                            html: '<small>Etape modifiée avec succès !</small>',
                            icon: 'success',
                            timer: 3000
                        }).then(() => {
                            StepBus.$emit('workflowstep_updated', {workflowstep, workflowId})
                        })
                    }).catch(error => {
                    this.loading = false
                });
            },
            updateFlowchartNode(workflowId) {
                this.loading = true

                this.updateRoleType();

                const fd = this.addFileToForm()

                this.workflowstepForm
                    .put(`/workflowsteps.updateflowchartnode/${this.workflowstepId}`, fd)
                    .then(workflowstep => {
                        this.loading = false

                        //$('#addUpdateWorkflowstep').modal('hide')
                        this.$swal({
                            html: '<small>Infos Diagramme modifiées avec succès !</small>',
                            icon: 'success',
                            timer: 3000
                        }).then(() => {
                            this.initForm(true, workflowstep)
                            StepBus.$emit('workflowstep_updated', {workflowstep, workflowId})
                        })
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
            roleTypeChange(event) {
                this.workflowstepForm.role_type = event.target.value;
                console.log('roleTypeChange: ', this.workflowstepForm.role_type);
                this.updateRoleType();
            },
            updateRoleType() {
                if (this.workflowstepForm.role_type === 'role_static') {
                    this.workflowstepForm.role_static = 1;
                    this.workflowstepForm.role_dynamic = 0;
                    this.workflowstepForm.role_previous = 0;
                } else if (this.workflowstepForm.role_type === 'role_dynamic') {
                    this.workflowstepForm.role_static = 0;
                    this.workflowstepForm.role_dynamic = 1;
                    this.workflowstepForm.role_previous = 0;
                } else if (this.workflowstepForm.role_type === 'role_previous') {
                    this.workflowstepForm.role_static = 0;
                    this.workflowstepForm.role_dynamic = 0;
                    this.workflowstepForm.role_previous = 1;
                }
            },
            canExpireCheck() {
                this.workflowstepForm.can_expire = ( this.workflowstepForm.can_expire === 1 ) ? 0 : 1;
            },
            notifyToProfileCheck() {
                this.workflowstepForm.notify_to_approvers = ( this.workflowstepForm.notify_to_approvers === 1 ) ? 0 : 1;
            },
            notifyToOthersCheck() {
                this.workflowstepForm.notify_to_others = ( this.workflowstepForm.notify_to_others === 1 ) ? 0 : 1;
            },
            collapseFlowchartClicked() {
                if (this.flowchart_collapse_icon === 'fas fa-chevron-down') {
                    this.flowchart_collapse_icon = 'fas fa-chevron-up';
                } else {
                    this.flowchart_collapse_icon = 'fas fa-chevron-down';
                }
            },
        },
        computed: {
            can_role_static() {
                return (this.workflowstepForm.role_static ? true : (this.workflowstepForm.role_dynamic ? false : (this.workflowstepForm.role_previous ? false : true ) ) );
            },
            isValidCreateForm() {
                return !this.loading
            },
            currentFlowchartCollapseIcon() {
                return this.flowchart_collapse_icon;
            }
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped>
</style>
