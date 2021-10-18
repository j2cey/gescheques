<template>
    <div class="modal fade" id="addUpdateCriterion" tabindex="-1" role="dialog" aria-labelledby="criterionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-sm" id="criterionModalLabel" v-if="editing">Update Criterion</h5>
                    <h5 class="modal-title text-sm" id="criterionModalLabel" v-else>Create Criterion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" @submit.prevent @keydown="criterionForm.errors.clear()">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="criterion_val" class="col-sm-2 col-form-label text-xs text-xs">Title</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="criterion_title" name="title" placeholder="Title" v-model="criterionForm.title">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="criterionForm.errors.has('title')" v-text="criterionForm.errors.get('title')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <b-field :type="criterionForm.errors.has('is_start_criterion') ? 'is-danger' : ''"
                                         :message="criterionForm.errors.get('is_start_criterion')">
                                    <b-checkbox v-model="criterionForm.is_start_criterion"
                                                :type="criterionForm.is_start_criterion ? 'is-success' : 'is-danger'">
                                        Start Criterion
                                    </b-checkbox>
                                </b-field>
                            </div>
                            <div class="form-group row">
                                <b-field :type="criterionForm.errors.has('is_stop_criterion') ? 'is-danger' : ''"
                                         :message="criterionForm.errors.get('is_stop_criterion')">
                                    <b-checkbox v-model="criterionForm.is_stop_criterion"
                                                :type="criterionForm.is_stop_criterion ? 'is-success' : 'is-danger'">
                                        Stop Criterion
                                    </b-checkbox>
                                </b-field>
                            </div>
                            <div class="form-group row">
                                <label for="m_select_criterion_type" class="col-sm-2 col-form-label text-xs">Type</label>
                                <div class="col-sm-10 text-xs">
                                    <multiselect
                                        id="m_select_criterion_type"
                                        v-model="criterionForm.criteriontype"
                                        selected.sync="criterion.criteriontype"
                                        value=""
                                        :options="criteriontypes"
                                        :searchable="true"
                                        :multiple="false"
                                        label="name"
                                        track-by="id"
                                        key="id"
                                        placeholder="Criterion Type"
                                    >
                                    </multiselect>
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="criterionForm.errors.has('criteriontype')" v-text="criterionForm.errors.get('criteriontype')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="criterion_modelattribute" class="col-sm-2 col-form-label text-xs">Object Attribute</label>
                                <div class="col-sm-10">
                                    <multiselect class="text text-xs"
                                                 id="reminder_model_type"
                                                 v-model="criterionForm.modelattribute"
                                                 selected.sync="criterionForm.modelattribute"
                                                 value=""
                                                 :options="modelattributes"
                                                 :searchable="true"
                                                 :multiple="false"
                                                 label="label"
                                                 track-by="id"
                                                 key="id"
                                                 placeholder="Model Attribute"
                                    >
                                    </multiselect>
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="criterionForm.errors.has('modelattribute')" v-text="criterionForm.errors.get('modelattribute')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="criterion_criterion_value" class="col-sm-2 col-form-label text-xs">Criterion Value</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="criterion_criterion_value" name="criterion_value" required autocomplete="criterion_value" autofocus placeholder="Criterion Value" v-model="criterionForm.criterion_value">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="criterionForm.errors.has('criterion_value')" v-text="criterionForm.errors.get('criterion_value')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="criterion_description" class="col-sm-2 col-form-label text-xs">Description</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="criterion_description" name="description" required autocomplete="description" autofocus placeholder="Description" v-model="criterionForm.description">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="criterionForm.errors.has('description')" v-text="criterionForm.errors.get('description')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="m_select_action_type" class="col-sm-2 col-form-label text-xs">Statut</label>
                                <div class="col-sm-10 text-xs">
                                    <multiselect
                                        id="m_select_action_type"
                                        v-model="criterionForm.status"
                                        selected.sync="criterion.status"
                                        value=""
                                        :options="statuses"
                                        :searchable="true"
                                        :multiple="false"
                                        label="name"
                                        track-by="id"
                                        key="id"
                                        placeholder="Statut"
                                    >
                                    </multiselect>
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="criterionForm.errors.has('status')" v-text="criterionForm.errors.get('status')"></span>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer justify-content-between">
                    <b-button type="is-dark" size="is-small" data-dismiss="modal">Fermer</b-button>
                    <b-button type="is-primary" size="is-small" :loading="loading" @click="updateCriterion(reminderId)" :disabled="!isValidCreateForm" v-if="editing">Save</b-button>
                    <b-button type="is-primary" size="is-small" :loading="loading" @click="createCriterion(reminderId)" :disabled="!isValidCreateForm" v-else>Create</b-button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
    import Multiselect from "vue-multiselect";
    import CriterionBus from "../remindercriteria/remindercriteriaBus";

    class Criterion {
        constructor(criterion) {
            this.title = criterion.title || ''
            this.is_start_criterion = criterion.is_start_criterion === 1
            this.is_stop_criterion = criterion.is_stop_criterion === 1
            this.modelattribute = criterion.modelattribute || ''
            this.criterion_value = criterion.criterion_value || ''
            this.description = criterion.description || ''
            this.reminder_id = criterion.reminder_id || ''
            this.criteriontype = criterion.criteriontype || ''
            this.status = criterion.status || ''
        }
    }
    export default {
        name: "criterion-addupdate",
        props: {
        },
        components: { Multiselect },
        mounted() {
            CriterionBus.$on('criterion_create', (reminder) => {

                this.editing = false
                this.reminder = reminder
                this.modelattributes = this.reminder.modeltype ? this.reminder.modeltype.modelattributes : null
                this.reminderId = reminder.id
                this.criterion = new Criterion({})
                this.criterion.reminder_id = reminder.id
                this.criterionForm = new Form(this.criterion)

                $('#addUpdateCriterion').modal()
            })

            CriterionBus.$on('criterion_edit', (edit_data) => {
                console.log('criterion_edit received from criterion-addupdate: ', edit_data)
                this.editing = true
                this.criterion = new Criterion(edit_data.criterion)
                this.criterionForm = new Form(this.criterion)
                this.criterionId = edit_data.criterion.uuid
                this.reminder = edit_data.reminder
                this.modelattributes = this.reminder.modeltype ? this.reminder.modeltype.modelattributes : null
                this.reminderId = this.reminder.uuid

                $('#addUpdateCriterion').modal()
            })
        },
        created() {
            axios.get('/statuses.fetch')
                .then(({data}) => this.statuses = data);
            axios.get('/remindercriteriontypes.fetch')
                .then(({data}) => this.criteriontypes = data);
        },
        data() {
            return {
                criterion: {},
                reminder: {},
                reminderId: '',
                criterionForm: new Form(new Criterion({})),
                criterionId: null,
                editing: false,
                loading: false,
                statuses: [],
                criteriontypes: [],
                modelattributes: [],
            }
        },
        methods: {
            createCriterion() {
                this.loading = true

                this.criterionForm
                    .post('/remindercriteria')
                    .then(resp => {
                        this.loading = false
                        // on émet la valeur créé dans le bus EnumValue
                        console.log('criteria post resp: ', resp)
                        let criterion = resp.criterion
                        let reminder = resp.reminder

                        this.closeModal()

                        this.$swal({
                            html: '<small>Criterion successfully created !</small>',
                            icon: 'success',
                            timer: 3000
                        }).then(() => {
                            CriterionBus.$emit('criterion_created', {criterion, reminder})
                        })
                    }).catch(error => {
                    this.loading = false
                });
            },
            updateCriterion() {
                this.loading = true

                this.criterionForm
                    .put(`/remindercriteria/${this.criterionId}`)
                    .then(resp => {
                        this.loading = false
                        let criterion = resp.criterion
                        let reminder = resp.reminder

                        this.closeModal()

                        this.$swal({
                            html: '<small>Criterion successfully updated !</small>',
                            icon: 'success',
                            timer: 3000
                        }).then(() => {
                            CriterionBus.$emit('criterion_updated', {criterion, reminder})
                        })
                    }).catch(error => {
                    this.loading = false
                });
            },
            closeModal() {
                this.resetForm()
                $('#addUpdateCriterion').modal('hide')
            },
            resetForm() {
                this.criterionForm.reset();
            }
        },
        computed: {
            isValidCreateForm() {
                return !this.loading
            }
        }
    }
</script>

<style scoped>

</style>
