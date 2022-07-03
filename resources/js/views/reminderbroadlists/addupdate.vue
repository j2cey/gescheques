<template>
    <div class="modal fade" id="addUpdateBroadlist" tabindex="-1" role="dialog" aria-labelledby="broadlistModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-sm" id="broadlistModalLabel" v-if="editing">Update Broadcast List</h5>
                    <h5 class="modal-title text-sm" id="broadlistModalLabel" v-else>Create Broadcast List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" @submit.prevent @keydown="broadlistForm.errors.clear()">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="broadlist_title" class="col-sm-2 col-form-label text-xs text-xs">Title</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="broadlist_title" name="title" placeholder="Title" v-model="broadlistForm.title">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="broadlistForm.errors.has('title')" v-text="broadlistForm.errors.get('title')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="broadlist_msg" class="col-sm-2 col-form-label text-xs text-xs">Message</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="broadlist_msg" name="msg" placeholder="Message" v-model="broadlistForm.msg">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="broadlistForm.errors.has('msg')" v-text="broadlistForm.errors.get('msg')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="broadlist_notification_interval" class="col-sm-2 col-form-label text-xs text-xs">Notification Interval (hours)</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="broadlist_notification_interval" name="notification_interval" placeholder="Notification Interval" v-model="broadlistForm.notification_interval">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="broadlistForm.errors.has('notification_interval')" v-text="broadlistForm.errors.get('notification_interval')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="action_description" class="col-sm-2 col-form-label text-xs">Description</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="action_description" name="description" required autocomplete="description" autofocus placeholder="Description" v-model="broadlistForm.description">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="broadlistForm.errors.has('description')" v-text="broadlistForm.errors.get('description')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="m_select_status" class="col-sm-2 col-form-label text-xs">Statut</label>
                                <div class="col-sm-10 text-xs">
                                    <multiselect
                                        id="m_select_status"
                                        v-model="broadlistForm.status"
                                        selected.sync="broadlist.status"
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
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="broadlistForm.errors.has('status')" v-text="broadlistForm.errors.get('status')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="m_select_roles" class="col-sm-2 col-form-label text-xs">Role(s)</label>
                                <div class="col-sm-10 text-xs">
                                    <multiselect
                                        id="m_select_roles"
                                        v-model="broadlistForm.roles"
                                        selected.sync="broadlist.roles"
                                        value=""
                                        :options="roles"
                                        :searchable="true"
                                        :multiple="true"
                                        label="name"
                                        track-by="id"
                                        key="id"
                                        placeholder="Role(s)"
                                    >
                                    </multiselect>
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="broadlistForm.errors.has('roles')" v-text="broadlistForm.errors.get('roles')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="m_select_users" class="col-sm-2 col-form-label text-xs">User(s)</label>
                                <div class="col-sm-10 text-xs">
                                    <multiselect
                                        id="m_select_users"
                                        v-model="broadlistForm.users"
                                        selected.sync="broadlist.users"
                                        value=""
                                        :options="users"
                                        :searchable="true"
                                        :multiple="true"
                                        label="name"
                                        track-by="id"
                                        key="id"
                                        placeholder="User(s)"
                                    >
                                    </multiselect>
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="broadlistForm.errors.has('users')" v-text="broadlistForm.errors.get('users')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="broadlist_notification_start_at" class="col-sm-2 col-form-label text-xs">Notification Start At</label>
                                <div class="col-sm-10 text-xs">
                                    <input type="text" readonly class="form-control form-control-sm" id="broadlist_notification_start_at" name="notification_start_at" placeholder="Notification Start At" v-model="broadlistForm.notification_start_at">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="broadlistForm.errors.has('notification_start_at')" v-text="broadlistForm.errors.get('notification_start_at')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="broadlist_notification_last_time" class="col-sm-2 col-form-label text-xs">Notification Last Time</label>
                                <div class="col-sm-10 text-xs">
                                    <input type="text" readonly class="form-control form-control-sm" id="broadlist_notification_last_time" name="notification_last_time" placeholder="Notification Last Time" v-model="broadlistForm.notification_last_time">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="broadlistForm.errors.has('notification_last_time')" v-text="broadlistForm.errors.get('notification_last_time')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="broadlist_notification_end_at" class="col-sm-2 col-form-label text-xs">Notification End At</label>
                                <div class="col-sm-10 text-xs">
                                    <input type="text" readonly class="form-control form-control-sm" id="broadlist_notification_end_at" name="notification_end_at" placeholder="Notification End At" v-model="broadlistForm.notification_end_at">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="broadlistForm.errors.has('notification_end_at')" v-text="broadlistForm.errors.get('notification_end_at')"></span>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer justify-content-between">
                    <b-button type="is-dark" size="is-small" data-dismiss="modal">Fermer</b-button>
                    <b-button type="is-primary" size="is-small" :loading="loading" @click="updateBroadlist(objectId)" :disabled="!isValidCreateForm" v-if="editing">Enregistrer</b-button>
                    <b-button type="is-primary" size="is-small" :loading="loading" @click="createBroadlist(objectId)" :disabled="!isValidCreateForm" v-else>Créer Action</b-button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>

    import Multiselect from "vue-multiselect";
    import BroadlistBus from "../reminderbroadlists/broadlistsBus";

    class Broadlist {
        constructor(broadlist) {
            this.title = broadlist.title || ''
            this.msg = broadlist.msg || ''
            this.notification_interval = broadlist.notification_interval || ''
            this.description = broadlist.description || ''

            this.status = broadlist.status || ''
            this.roles = broadlist.roles || ''
            this.users = broadlist.users || ''
            this.notification_start_at = broadlist.notification_start_at || ''
            this.notification_last_time = broadlist.notification_last_time || ''
            this.notification_end_at = broadlist.notification_end_at || ''

            this.objecttype = broadlist.objecttype || ''
            this.objectid = broadlist.objectid || ''
        }
    }
    export default {
        name: "broadlist-addupdate",
        props: {
        },
        components: { Multiselect },
        mounted() {
            BroadlistBus.$on('broadlist_create', (create_data) => {

                this.editing = false
                this.objectId = create_data.object.uuid
                this.broadlist = new Broadlist({})
                this.broadlist.objecttype = create_data.objecttype
                this.broadlist.objectid = create_data.object.id
                this.broadlistForm = new Form(this.broadlist)

                $('#addUpdateBroadlist').modal()
            })

            BroadlistBus.$on('broadlist_edit', (edit_data) => {
                this.editing = true
                this.broadlist = new Broadlist(edit_data.broadlist)
                this.broadlistId = edit_data.broadlist.uuid

                this.broadlist.objecttype = edit_data.objecttype
                this.broadlist.objectid = edit_data.object.id

                this.broadlistForm = new Form(this.broadlist)

                $('#addUpdateBroadlist').modal()
            })
        },
        created() {
            axios.get('/statuses.fetch')
                .then(({data}) => this.statuses = data);
            axios.get('/roles.fetch')
                .then(({data}) => this.roles = data);
            axios.get('/users.fetchall')
                .then(({data}) => this.users = data);
        },
        data() {
            return {
                broadlist: {},
                objectId: '',
                broadlistForm: new Form(new Broadlist({})),
                broadlistId: null,
                editing: false,
                loading: false,
                statuses: [],
                roles: [],
                users: [],
            }
        },
        methods: {
            createBroadlist() {
                this.loading = true

                this.broadlistForm
                    .post('/reminderbroadlists')
                    .then(resp => {
                        this.loading = false
                        // on émet la valeur créé dans le bus EnumValue
                        console.log('broadlists post resp: ', resp)
                        let broadlist = resp.broadlist
                        let object = resp.object

                        this.closeModal()

                        this.$swal({
                            html: '<small>Broadcast List successful created !</small>',
                            icon: 'success',
                            timer: 3000
                        }).then(() => {
                            BroadlistBus.$emit('broadlist_created', {broadlist, object})
                        })
                    }).catch(error => {
                    this.loading = false
                });
            },
            updateBroadlist() {
                this.loading = true

                this.broadlistForm
                    .put(`/reminderbroadlists/${this.broadlistId}`)
                    .then(resp => {
                        this.loading = false
                        let broadlist = resp.broadlist
                        let object = resp.object

                        this.closeModal()

                        this.$swal({
                            html: '<small>Broadcast List successful updated !</small>',
                            icon: 'success',
                            timer: 3000
                        }).then(() => {
                            BroadlistBus.$emit('broadlist_updated', {broadlist, object})
                        })
                    }).catch(error => {
                    this.loading = false
                });
            },
            closeModal() {
                this.resetForm()
                $('#addUpdateBroadlist').modal('hide')
            },
            resetForm() {
                this.broadlistForm.reset();
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
