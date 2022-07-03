<template>
    <div class="card card-default">
        <div class="card-header">
            <div class="form-inline float-left">
                <span class="help-inline pr-1 text-sm"> Reminder Objects List </span>
                <b-button size="is-small" type="is-info is-light" @click="createReminderObject()"><i class="fas fa-plus"></i></b-button>
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
                :data="reminderobjects"
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
                aria-current-label="Current page" :before-destroy="false">

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
                                <a @click="editReminderObject(props.row)">
                                    {{ props.row[column.field] }}
                                </a>
                            </span>
                            <span v-else-if="column.date" class="tag is-light is-small">
                                {{ props.row[column.field] | formatDate }}
                            </span>
                            <span v-else-if="column.field === 'broadcastlists'">
                                <b-tag v-if="props.row.broadcastlists.length < 2" type="is-danger is-light" rounded>{{ props.row.broadcastlists.length }}</b-tag>
                                <b-tag v-else type="is-success is-light" rounded>{{ props.row.broadcastlists.length }}</b-tag>
                            </span>
                            <span v-else-if="column.field === 'reminder'" class="has-text-info is-italic text-xs">
                            <span v-if="props.row[column.field]">
                                {{ props.row[column.field].title }}
                            </span>
                            <span v-else></span>
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
                    <b-field grouped group-multiline>
                        <div class="form-inline float-left">
                            <span class="help-inline pr-1 text-sm"> Broadcast Lists </span>
                            <b-button size="is-small" type="is-info is-light" @click="createBroadlist(props.row)"><i class="fas fa-plus"></i></b-button>
                        </div>
                    </b-field>
                    <hr />
                    <Broadlists :reminderobjectid_prop="props.row.id" :broadcastlists_prop="props.row.broadcastlists"></Broadlists>
                </template>

                <template #empty>
                    <div class="has-text-centered">Aucune Données</div>
                </template>

            </b-table>

        </div>
        <!-- /.card-body -->
        <AddUpdateReminderObject></AddUpdateReminderObject>
        <AddUpdateBroadlist></AddUpdateBroadlist>
    </div>
    <!-- /.card -->
</template>

<script>
    import ReminderObjectBus from "../reminderobjects/reminderobjectBus";
    import BroadlistBus from "../reminderbroadlists/broadlistsBus";

    export default {
        name: "reminderobject-list",
        components: {
            Broadlists: () => import('../reminderbroadlists/list'),
            AddUpdateReminderObject: () => import('../reminderobjects/addupdate'),
            AddUpdateBroadlist: () => import('../reminderbroadlists/addupdate'),
        },
        mounted() {
            ReminderObjectBus.$on('reminderobject_created', (add_data) => {
                console.log('reminderobject_to_add received at reminderobjects.list', add_data)
                this.addReminderObject(add_data.reminderobject)
            })

            ReminderObjectBus.$on('reminderobject_updated', (upd_data) => {
                // Type Composé modifié à mettre à jour sur la liste
                console.log('reminderobject_to_update received at reminderobjects.list', upd_data)
                this.updateReminderObject(upd_data.reminderobject)
            })

            BroadlistBus.$on('broadlist_created', (add_data) => {
                console.log('broadlist_created received from reminderobject_list', add_data)
                this.updateReminderObject(add_data.reminderobject)
            })

            BroadlistBus.$on('broadlist_updated', (upd_data) => {
                console.log('broadlist_updated received from reminderobject_list', upd_data)
                this.updateReminderObject(upd_data.reminderobject)
            })

            BroadlistBus.$on('broadlist_deleted', (del_data) => {
                console.log('broadlist_deleted received from reminderobject_list', del_data)
                this.updateReminderObject(del_data.reminderobject)
            })
        },
        data() {
            return {
                reminderobjects: [],
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
                        field: 'model_type',
                        key: 'model_type',
                        label: 'Model Type',
                        searchable: true,
                        sortable: true,
                    },
                    {
                        field: 'model_id',
                        key: 'model_id',
                        label: 'Model ID',
                        searchable: true,
                        sortable: true,
                    },
                    {
                        field: 'reminder',
                        key: 'reminder',
                        label: 'Reminder',
                        searchable: false,
                        sortable: false,
                    },
                    {
                        field: 'description',
                        key: 'description',
                        label: 'Description',
                        searchable: true,
                        sortable: true,
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
            axios.get('/reminderobjects.fetch')
                .then(({data}) => this.reminderobjects = data);
        },
        methods: {
            createReminderObject() {
                ReminderObjectBus.$emit('reminderobject_create');
            },
            editReminderObject(reminderobject) {
                ReminderObjectBus.$emit('reminderobject_edit', reminderobject);
            },
            createBroadlist(reminderobject) {
                BroadlistBus.$emit('broadlist_create', reminderobject);
            },
            addReminderObject(reminderobject) {
                let reminderobjectIndex = this.reminderobjects.findIndex(c => {
                    return reminderobject.id === c.id
                })

                // if this reminderobject doesn't exists, we add it to the list
                if (reminderobjectIndex === -1) {
                    this.reminderobjects.push(reminderobject)
                }
            },
            updateReminderObject(reminderobject) {
                // we retrieve the updated reminderobject index
                let reminderobjectIndex = this.reminderobjects.findIndex(s => {
                    return reminderobject.id === s.id
                })

                if (reminderobjectIndex > -1) {
                    this.reminderobjects.splice(reminderobjectIndex, 1, reminderobject)
                }
            },
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
