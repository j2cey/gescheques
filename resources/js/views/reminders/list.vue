<template>
    <div class="card card-default">
        <div class="card-header">
            <div class="form-inline float-left">
                <span class="help-inline pr-1 text-sm"> Reminders List </span>
                <b-button size="is-small" type="is-info is-light" @click="createReminder()"><i class="fas fa-plus"></i></b-button>
            </div>

            <div class="card-tools">

                <div class="input-group input-group-sm" style="width: 150px;">
                    <!--<input type="text" name="table_search" class="form-control float-right" placeholder="Search">-->

                    <!--<div class="input-group-append">
                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>-->
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">

            <b-field grouped group-multiline>
                <b-select v-model="perPage" :disabled="!isPaginated">
                    <option value="5">5 par page</option>
                    <option value="10">10 par page</option>
                    <option value="15">15 par page</option>
                    <option value="20">20 par page</option>
                </b-select>
            </b-field>
            <b-table
                :data="reminders"
                ref="table"
                :debounce-search="1000"
                :paginated="isPaginated"
                :per-page="perPage"
                :opened-detailed="defaultOpenedDetails"
                detailed
                detail-key="id"
                :detail-transition="transitionName"
                :show-detail-icon="showDetailIcon"
                :current-page.sync="currentPage"
                :pagination-simple="isPaginationSimple"
                :pagination-position="paginationPosition"
                :default-sort-direction="defaultSortDirection"
                :pagination-rounded="isPaginationRounded"
                :sort-icon="sortIcon"
                :sort-icon-size="sortIconSize"
                :sticky-header="stickyHeaders"
                default-sort="row.titre"
                aria-next-label="Suivant"
                aria-previous-label="Precedent"
                aria-page-label="Page"
                aria-current-label="Current page" :before-destroy="false"
            >

                <template v-for="column in columns">
                    <b-table-column :key="column.id" v-bind="column" :sortable="column.sortable">
                        <template
                            v-if="column.searchable && !column.numeric"
                            #searchable="props">
                            <b-input
                                v-model="props.filters[props.column.field]"
                                placeholder="Rech..."
                                icon="magnify"
                                size="is-small"
                                icon-right="close-circle"
                                icon-right-clickable
                                @icon-right-click="props.filters[props.column.field] = ''"
                            />
                        </template>

                        <template v-slot="props">
                            <span v-if="column.field === 'id'" class="text-xs">
                                {{ props.row[column.field] }}
                            </span>
                            <span v-else-if="column.field === 'title'" class="has-text-primary is-italic text-xs">
                                <a @click="editReminder(props.row)">
                                    {{ props.row[column.field] }}
                                </a>
                            </span>
                            <span v-else-if="column.field === 'modeltype'" class="has-text-info is-italic text-xs">
                                <span v-if="props.row[column.field]">
                                    {{ props.row[column.field].full_type }}
                                </span>
                                <span v-else></span>
                            </span>
                            <span v-else-if="column.date" class="tag is-light is-small">
                                {{ props.row[column.field] | formatDate }}
                            </span>
                            <span v-else-if="column.field === 'criteria'">
                                <b-tag v-if="props.row.criteria.length < 2" type="is-danger is-light" rounded>{{ props.row.criteria.length }}</b-tag>
                                <b-tag v-else type="is-success is-light" rounded>{{ props.row.criteria.length }}</b-tag>
                            </span>
                            <span v-else-if="column.field === 'broadcastlists'">
                                <b-tag v-if="props.row.broadcastlists.length < 1" type="is-danger is-light" rounded>{{ props.row.broadcastlists.length }}</b-tag>
                                <b-tag v-else type="is-success is-light" rounded>{{ props.row.broadcastlists.length }}</b-tag>
                            </span>
                            <span v-else-if="column.field === 'status'" class="has-text-info is-italic text-xs">
                                <span v-if="props.row[column.field]">
                                    <b-tag v-if="props.row.status.code === 'active'" type="is-success" size="is-small">{{ props.row.status.name }}</b-tag>
                                    <b-tag v-else type="is-danger" size="is-small">{{ props.row.status.name }}</b-tag>
                                </span>
                                <span v-else></span>
                            </span>
                            <span v-else class="text-xs">
                                {{ props.row[column.field] }}
                            </span>
                        </template>
                    </b-table-column>
                </template>

                <template #detail="props">

                    <b-tabs>
                        <b-tab-item>
                            <template #header>
                                <b-icon icon="source-pull"></b-icon>
                                <span> Criteria <b-tag rounded> {{ props.row.criteria.length }} </b-tag> </span>
                            </template>

                            <b-field grouped group-multiline>
                                <div class="form-inline float-left">
                                    <b-button size="is-small" type="is-info is-light" @click="createCriterion(props.row)"><i class="fas fa-plus"></i></b-button>
                                </div>
                            </b-field>
                            <hr />
                            <Criteria :reminder_prop="props.row" :criteria_prop="props.row.criteria"></Criteria>
                        </b-tab-item>
                        <b-tab-item>
                            <template #header>
                                <b-icon icon="access-point"></b-icon>
                                <span> Broadcast Lists <b-tag rounded> {{ props.row.broadcastlists.length }} </b-tag> </span>
                            </template>

                            <b-field grouped group-multiline>
                                <div class="form-inline float-left">
                                    <b-button size="is-small" type="is-info is-light" @click="createBroadlist(props.row)"><i class="fas fa-plus"></i></b-button>
                                </div>
                            </b-field>
                            <hr />
                            <Broadlists :object_prop="props.row" :objecttype_prop="objecttype" :broadlists_prop="props.row.broadcastlists"></Broadlists>
                        </b-tab-item>
                    </b-tabs>

                </template>

                <template #empty>
                    <div class="has-text-centered">Aucune Données</div>
                </template>

            </b-table>

        </div>
        <!-- /.card-body -->
        <AddUpdateReminder></AddUpdateReminder>
        <AddUpdateCriterion></AddUpdateCriterion>
        <AddUpdateBroadlist></AddUpdateBroadlist>
    </div>
    <!-- /.card -->
</template>

<script>
    import ReminderBus from "../reminders/reminderBus";
    import CriterionBus from "../remindercriteria/remindercriteriaBus";
    import BroadlistBus from "../reminderbroadlists/broadlistsBus";

    export default {
        name: "reminder-list",
        components: {
            AddUpdateReminder: () => import('../reminders/addupdate'),
            Criteria: () => import('../remindercriteria/list'),
            AddUpdateCriterion: () => import('../remindercriteria/addupdate'),
            Broadlists: () => import('../reminderbroadlists/list'),
            AddUpdateBroadlist: () => import('../reminderbroadlists/addupdate'),
        },
        mounted() {
            ReminderBus.$on('reminder_created', (add_data) => {
                console.log('reminder_to_add received at reminders.list', add_data)
                this.addReminder(add_data.reminder)
            })

            ReminderBus.$on('reminder_updated', (upd_data) => {
                // Type Composé modifié à mettre à jour sur la liste
                console.log('reminder_to_update received at reminders.list', upd_data)
                this.updateReminder(upd_data.reminder)
            })

            CriterionBus.$on('criterion_created', (add_data) => {
                console.log('criterion_created received from reminder_list', add_data)
                this.updateReminder(add_data.reminder)
            })

            CriterionBus.$on('criterion_updated', (upd_data) => {
                console.log('criterion_updated received from reminder_list', upd_data)
                this.updateReminder(upd_data.reminder)
            })

            CriterionBus.$on('criterion_deleted', (del_data) => {
                console.log('criterion_deleted received from reminder_list', del_data)
                this.updateReminder(del_data.reminder)
            })

            BroadlistBus.$on('broadlist_created', (add_data) => {
                console.log('broadlist_created received from reminder_list', add_data)
                this.refreshReminder(add_data.object)
            })

            BroadlistBus.$on('broadlist_updated', (upd_data) => {
                console.log('broadlist_updated received from reminder_list', upd_data)
                this.refreshReminder(upd_data.object)
            })

            BroadlistBus.$on('broadlist_deleted', (del_data) => {
                console.log('broadlist_deleted received from reminder_list', del_data)
                this.refreshReminder(del_data.object)
            })
        },
        data() {
            return {
                reminders: [],
                objecttype: "App\\Models\\Reminder",
                isPaginated: true,
                isPaginationSimple: false,
                isPaginationRounded: true,
                paginationPosition: 'bottom',
                defaultSortDirection: 'asc',
                sortIcon: 'arrow-up',
                sortIconSize: 'is-small',
                currentPage: 1,
                perPage: 5,
                defaultOpenedDetails: [-1],
                showDetailIcon: true,
                useTransition: false,
                stickyHeaders: false,
                columns: [
                    {
                        field: 'id',
                        key: 'id',
                        label: 'ID',
                        numeric: true,
                        searchable: false,
                        sortable: true,
                    },
                    {
                        field: 'title',
                        key: 'title',
                        label: 'Title',
                        searchable: true,
                        sortable: true,
                    },
                    {
                        field: 'modeltype',
                        key: 'modeltype',
                        label: 'Model Type',
                        searchable: true,
                        sortable: true,
                    },
                    {
                        field: 'description',
                        key: 'description',
                        label: 'Description',
                        searchable: true,
                        sortable: true,
                    },
                    {
                        field: 'criteria',
                        key: 'criteria',
                        label: 'Criteria',
                        searchable: false,
                        sortable: false,
                    },
                    {
                        field: 'broadcastlists',
                        key: 'broadcastlists',
                        label: 'Broadcast Lists',
                        searchable: false,
                        sortable: false,
                    },
                    {
                        field: 'created_at',
                        key: 'created_at',
                        label: 'Created',
                        date: true,
                        searchable: false,
                        sortable: true,
                    },
                    {
                        field: 'updated_at',
                        key: 'updated_at',
                        label: 'Updated',
                        date: true,
                        searchable: false,
                        sortable: true,
                    },
                    {
                        field: 'status',
                        key: 'status',
                        label: 'Status',
                        searchable: false,
                        sortable: true,
                    },
                ]
            }
        },
        created() {
            axios.get('/reminders.fetch')
                .then(({data}) => this.reminders = data);
        },
        methods: {
            createReminder() {
                ReminderBus.$emit('reminder_create');
            },
            editReminder(reminder) {
                ReminderBus.$emit('reminder_edit', reminder);
            },
            createCriterion(reminder) {
                CriterionBus.$emit('criterion_create', reminder);
            },
            createBroadlist(object) {
                let objecttype = this.objecttype
                BroadlistBus.$emit('broadlist_create', {object, objecttype});
            },
            addReminder(reminder) {
                let reminderIndex = this.reminders.findIndex(c => {
                    return reminder.id === c.id
                })

                // if this reminder doesn't exists, we add it to the list
                if (reminderIndex === -1) {
                    this.reminders.push(reminder)
                }
            },
            updateReminder(reminder) {
                // we retrieve the updated reminder index
                let reminderIndex = this.reminders.findIndex(s => {
                    return reminder.id === s.id
                })

                if (reminderIndex > -1) {
                    this.reminders.splice(reminderIndex, 1, reminder)
                }
            },
            refreshReminder(reminder) {
                // we retrieve the updated reminder index (by uuid)
                let reminderIndex = this.reminders.findIndex(s => {
                    return reminder.uuid === s.uuid
                })

                if (reminderIndex > -1) {
                    axios.get(`/reminders.fetchone/${reminder.uuid}`)
                        .then(resp => {

                            console.log('reminders.fetchone: ', resp)
                            this.updateReminder(resp)

                        }).catch(error => {
                        window.handleErrors(error)
                    });
                }
            }
        },
        computed: {
            transitionName() {
                if (this.useTransition) {
                    return 'fade'
                }
            }
        }
    }
</script>

<style scoped>

</style>
