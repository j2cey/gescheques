<template>
    <div class="modal fade" id="addUpdateReminderObject" tabindex="-1" role="dialog" aria-labelledby="reminderobjectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-sm" id="reminderobjectModalLabel" v-if="editing">Edit Reminder Object</h5>
                    <h5 class="modal-title text-sm" id="reminderobjectModalLabel" v-else>Create New Reminder Object</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" @submit.prevent @keydown="reminderobjectForm.errors.clear()">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="reminderobject_title" class="col-sm-4 col-form-label text-xs">Title</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="reminderobject_title" name="title" autocomplete="title" autofocus placeholder="Title" v-model="reminderobjectForm.title">
                                    <span class=" invalid-feedback d-block text-xs" role="alert" v-if="reminderobjectForm.errors.has('title')" v-text="reminderobjectForm.errors.get('title')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="reminderobject_model_type" class="col-sm-4 col-form-label text-xs">Model Type</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="reminderobject_model_type" name="model_type" autocomplete="model_type" autofocus placeholder="Model Type" v-model="reminderobjectForm.model_type">
                                    <span class=" invalid-feedback d-block text-xs" role="alert" v-if="reminderobjectForm.errors.has('model_type')" v-text="reminderobjectForm.errors.get('model_type')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="reminderobject_model_id" class="col-sm-4 col-form-label text-xs">Model ID</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="reminderobject_model_id" name="model_id" autocomplete="model_id" autofocus placeholder="Model ID" v-model="reminderobjectForm.model_id">
                                    <span class=" invalid-feedback d-block text-xs" role="alert" v-if="reminderobjectForm.errors.has('model_id')" v-text="reminderobjectForm.errors.get('model_id')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="m_select_reminder" class="col-sm-4 col-form-label text-xs">Reminder</label>
                                <div class="col-sm-8">
                                    <multiselect class="text text-xs"
                                                 id="m_select_reminder"
                                                 v-model="reminderobjectForm.reminder"
                                                 selected.sync="reminderobjectForm.reminder"
                                                 value=""
                                                 :options="reminders"
                                                 :searchable="true"
                                                 :multiple="false"
                                                 label="title"
                                                 track-by="id"
                                                 key="id"
                                                 placeholder="Reminder"
                                    >
                                    </multiselect>
                                    <span class=" invalid-feedback d-block text-xs" role="alert" v-if="reminderobjectForm.errors.has('reminder')" v-text="reminderobjectForm.errors.get('reminder')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="reminderobject_description" class="col-sm-4 col-form-label text-xs">Description</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="reminderobject_description" name="description" required autocomplete="description" autofocus placeholder="Description" v-model="reminderobjectForm.description">
                                    <span class=" invalid-feedback d-block text-xs" role="alert" v-if="reminderobjectForm.errors.has('description')" v-text="reminderobjectForm.errors.get('description')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="m_select_status" class="col-sm-4 col-form-label text-xs">Status</label>
                                <div class="col-sm-8">
                                    <multiselect class="text text-xs"
                                                 id="m_select_status"
                                                 v-model="reminderobjectForm.status"
                                                 selected.sync="reminderobjectForm.status"
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
                                    <span class=" invalid-feedback d-block text-xs" role="alert" v-if="reminderobjectForm.errors.has('status')" v-text="reminderobjectForm.errors.get('status')"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <b-field label="Broadcast Lists" class="col"
                                         :type="reminderobjectForm.errors.has('broadcastlists') ? 'is-danger' : ''"
                                         :message="reminderobjectForm.errors.get('broadcastlists')">

                                    <b-taglist>
                                        <b-tag v-for="broadcastlist in broadcastlists" :key="broadcastlist.id" type="is-info">{{ broadcastlist.title }}</b-tag>
                                    </b-taglist>

                                </b-field>
                            </div>

                        </div>
                    </form>

                </div>
                <div class="modal-footer justify-content-between">
                    <b-button type="is-dark" size="is-small" data-dismiss="modal">Fermer</b-button>
                    <b-button type="is-primary" size="is-small" :loading="loading" @click="updateReminderObject()" :disabled="!isValidCreateForm" v-if="editing">Save</b-button>
                    <b-button type="is-primary" size="is-small" :loading="loading" @click="createReminderObject()" :disabled="!isValidCreateForm" v-else>Create Reminder Object</b-button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>

    import Multiselect from "vue-multiselect";
    import ReminderObjectBus from "../reminderobjects/reminderobjectBus";

    class ReminderObject {
        constructor(reminderobject) {
            this.title = reminderobject.title || ''
            this.model_type = reminderobject.model_type || ''
            this.model_id = reminderobject.model_id || ''
            this.description = reminderobject.description || ''
            this.status = reminderobject.status || ''
            this.reminder = reminderobject.reminder || ''
            this.broadcastlists = reminderobject.broadcastlists || ''
        }
    }
    export default {
        name: "reminderobject-addupdate",
        components: { Multiselect },
        mounted() {
            ReminderObjectBus.$on('reminderobject_create', () => {
                this.editing = false
                this.reminderobject = new ReminderObject({})
                this.broadcastlists = []
                this.reminderobjectForm = new Form(this.reminderobject)

                $('#addUpdateReminderObject').modal()
            })

            ReminderObjectBus.$on('reminderobject_edit', (reminderobject) => {
                this.editing = true
                this.reminderobject = new ReminderObject(reminderobject)
                this.reminderobjectForm = new Form(this.reminderobject)

                this.reminderobjectId = reminderobject.uuid
                this.broadcastlists = reminderobject.broadcastlists

                $('#addUpdateReminderObject').modal()
            })
        },
        created() {
            axios.get('/statuses.fetch')
                .then(({data}) => this.statuses = data);
            axios.get('/reminders.fetch')
                .then(({data}) => this.reminders = data);
        },
        data() {
            return {
                reminderobject: {},
                broadcastlists: [],
                reminderobjectForm: new Form(new ReminderObject({})),
                reminderobjectId: null,
                editing: false,
                loading: false,
                reminders: [],
                statuses: [],
                radioButton: ''
            }
        },
        methods: {
            createReminderObject() {
                this.loading = true

                this.reminderobjectForm
                    .post('/reminderobjects')
                    .then(resp => {
                        this.loading = false

                        let reminder = resp.reminder
                        let reminderobject = resp.reminderobject

                        this.closeModal()

                        this.$swal({
                            html: '<small>Reminder Object successfully created !</small>',
                            icon: 'success',
                            timer: 3000
                        }).then(() => {
                            ReminderObjectBus.$emit('reminderobject_created', { reminder, reminderobject })
                        })
                    }).catch(error => {
                    this.loading = false
                });
            },
            updateReminderObject() {
                this.loading = true

                this.reminderobjectForm
                    .put(`/reminderobjects/${this.reminderobjectId}`)
                    .then(resp => {
                        this.loading = false
                        this.resetForm();

                        let reminder = resp.reminder
                        let reminderobject = resp.reminderobject

                        this.closeModal()

                        this.$swal({
                            html: '<small>Reminder Object successfully updated !</small>',
                            icon: 'success',
                            timer: 3000
                        }).then(() => {
                            ReminderObjectBus.$emit('reminderobject_updated', { reminder, reminderobject })
                        })

                    }).catch(error => {
                    this.loading = false
                });
            },
            closeModal() {
                this.resetForm()
                $('#addUpdateReminderObject').modal('hide')
            },
            resetForm() {
                this.reminderobjectForm.reset();
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
