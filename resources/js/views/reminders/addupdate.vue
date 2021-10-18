<template>
    <div class="modal fade" id="addUpdateReminder" tabindex="-1" role="dialog" aria-labelledby="reminderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-sm" id="reminderModalLabel" v-if="editing">Edit Reminder</h5>
                    <h5 class="modal-title text-sm" id="reminderModalLabel" v-else>Create New Reminder</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" @submit.prevent @keydown="reminderForm.errors.clear()">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="reminder_title" class="col-sm-4 col-form-label text-xs">Title</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="reminder_title" name="title" autocomplete="title" autofocus placeholder="Titre" v-model="reminderForm.title">
                                    <span class=" invalid-feedback d-block text-xs" role="alert" v-if="reminderForm.errors.has('title')" v-text="reminderForm.errors.get('title')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="reminder_model_type" class="col-sm-4 col-form-label text-xs">Model Type</label>
                                <div class="col-sm-8">
                                    <multiselect class="text text-xs"
                                                 id="reminder_model_type"
                                                 v-model="reminderForm.modeltype"
                                                 selected.sync="reminderForm.modeltype"
                                                 value=""
                                                 :options="models"
                                                 :searchable="true"
                                                 :multiple="false"
                                                 label="label"
                                                 track-by="code"
                                                 key="code"
                                                 placeholder="Model Type"
                                    >
                                    </multiselect>
                                    <span class=" invalid-feedback d-block text-xs" role="alert" v-if="reminderForm.errors.has('modeltype')" v-text="reminderForm.errors.get('modeltype')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="reminder_description" class="col-sm-4 col-form-label text-xs">Description</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="reminder_description" name="description" required autocomplete="description" autofocus placeholder="Description" v-model="reminderForm.description">
                                    <span class=" invalid-feedback d-block text-xs" role="alert" v-if="reminderForm.errors.has('description')" v-text="reminderForm.errors.get('description')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="m_select_status" class="col-sm-4 col-form-label text-xs">Status</label>
                                <div class="col-sm-8">
                                    <multiselect class="text text-xs"
                                                 id="m_select_status"
                                                 v-model="reminderForm.status"
                                                 selected.sync="reminderForm.status"
                                                 value=""
                                                 :options="statuses"
                                                 :searchable="true"
                                                 :multiple="false"
                                                 label="name"
                                                 track-by="id"
                                                 key="id"
                                                 placeholder="Status"
                                    >
                                    </multiselect>
                                    <span class=" invalid-feedback d-block text-xs" role="alert" v-if="reminderForm.errors.has('status')" v-text="reminderForm.errors.get('status')"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <b-field label="Criteria" class="col"
                                         :type="reminderForm.errors.has('criteria') ? 'is-danger' : ''"
                                         :message="reminderForm.errors.get('criteria')">

                                    <b-taglist>
                                        <b-tag v-for="criterion in criteria" :key="criterion.id" type="is-info">{{ criterion.title }}</b-tag>
                                    </b-taglist>

                                </b-field>
                            </div>

                        </div>
                    </form>

                </div>
                <div class="modal-footer justify-content-between">
                    <b-button type="is-dark" size="is-small" data-dismiss="modal">Fermer</b-button>
                    <b-button type="is-primary" size="is-small" :loading="loading" @click="updateReminder()" :disabled="!isValidCreateForm" v-if="editing">Enregistrer</b-button>
                    <b-button type="is-primary" size="is-small" :loading="loading" @click="createReminder()" :disabled="!isValidCreateForm" v-else>Créer Etape</b-button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
    import Multiselect from "vue-multiselect";
    import ReminderBus from "../reminders/reminderBus";

    class Reminder {
        constructor(reminder) {
            this.title = reminder.title || ''
            this.modeltype = reminder.modeltype || ''
            this.description = reminder.description || ''
            this.status = reminder.status || ''
            this.criteria = reminder.criteria || ''
        }
    }
    export default {
        name: "reminder-addupdate",
        components: { Multiselect },
        mounted() {
            ReminderBus.$on('reminder_create', () => {
                this.editing = false
                this.reminder = new Reminder({})
                this.criteria = []
                this.reminderForm = new Form(this.reminder)

                $('#addUpdateReminder').modal()
            })

            ReminderBus.$on('reminder_edit', (reminder) => {
                this.editing = true
                this.reminder = new Reminder(reminder)
                this.reminderForm = new Form(this.reminder)

                this.reminderId = reminder.uuid
                this.criteria = reminder.criteria

                $('#addUpdateReminder').modal()
            })
        },
        created() {
            axios.get('/statuses.fetch')
                .then(({data}) => this.statuses = data);
            axios.get('/modeltypes.fetch')
                .then(({data}) => this.models = data);
        },
        data() {
            return {
                reminder: {},
                criteria: [],
                reminderForm: new Form(new Reminder({})),
                reminderId: null,
                editing: false,
                loading: false,
                statuses: [],
                models: [],
                radioButton: ''
            }
        },
        methods: {
            createReminder() {
                this.loading = true

                this.reminderForm
                    .post('/reminders')
                    .then(reminder => {
                        this.loading = false

                        this.closeModal()

                        this.$swal({
                            html: '<small>Reminder successfully created !</small>',
                            icon: 'success',
                            timer: 3000
                        }).then(() => {
                            ReminderBus.$emit('reminder_created', { reminder })
                        })
                    }).catch(error => {
                    this.loading = false
                });
            },
            updateReminder() {
                this.loading = true

                this.reminderForm
                    .put(`/reminders/${this.reminderId}`)
                    .then(reminder => {
                        this.loading = false
                        this.resetForm();

                        this.closeModal()

                        this.$swal({
                            html: '<small>Reminder successfully updated !</small>',
                            icon: 'success',
                            timer: 3000
                        }).then(() => {
                            ReminderBus.$emit('reminder_updated', { reminder })
                        })

                    }).catch(error => {
                    this.loading = false
                });
            },
            closeModal() {
                this.resetForm()
                $('#addUpdateReminder').modal('hide')
            },
            resetForm() {
                this.reminderForm.reset();
            }
        },
        computed: {
            isValidCreateForm() {
                return !this.loading
            },
        }
    }
</script>

<style scoped>

</style>
