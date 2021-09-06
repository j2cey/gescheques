<template>

    <section>
        <b-table
            :data="workflowsteps"
            :loading="loading"

            paginated
            backend-pagination
            :per-page="perPage"
            @page-change="onPageChange"

            backend-sorting
            :default-sort-direction="defaultSortOrder"
            :default-sort="[sortField, sortOrder]"
            @sort="onSort">

            <b-table-column field="titre" label="Titre" sortable searchable :td-attrs="columnTdAttrs" v-slot="props">
                {{ props.row.titre }}
            </b-table-column>

            <b-table-column field="description" label="Description" sortable :td-attrs="columnTdAttrs" v-slot="props">
                {{ props.row.description }}
            </b-table-column>

            <b-table-column field="{ setpparent }.titre" label="Parent" searchable sortable :td-attrs="columnTdAttrs" v-slot="props">
                {{ props.row.setpparent ? props.row.setpparent.titre : '' }}
            </b-table-column>

        </b-table>
    </section>

</template>

<script>
    import StepBus from './stepBus'
    import ActionBus from "../workflowactions/actionBus";

    export default {
        props: {
            workflow: {},
            workflowsteps_prop: {}
        },
        name: "steps-list",
        components: {
            WorkflowActions: () => import('../workflowactions/list'),
            AddUpdateAction: () => import('../workflowactions/addupdate')
        },
        mounted() {

            this.loadAsyncData()

            StepBus.$on('workflowaction_created', (add_data) => {
                if (this.workflow.id === add_data.workflowId) {
                    this.createStep(add_data.workflowstep)
                }
            })

            StepBus.$on('workflowstep_updated', (upd_data) => {
                // Step modifiée à mettre à jour sur la liste
                console.log('workflowstep_to_update received at steps.list', upd_data)
                if (this.workflow.id === upd_data.workflowId) {
                    this.updateStep(upd_data.workflowstep)
                }
            })

            ActionBus.$on('workflowaction_created', (add_data) => {
                console.log('workflowaction_created received from steplist', add_data)
                this.updateStep(add_data.step)
            })

            ActionBus.$on('workflowaction_updated', (upd_data) => {
                console.log('workflowaction_updated received from steplist', upd_data)
                this.updateStep(upd_data.step)
            })

            ActionBus.$on('workflowaction_deleted', (del_data) => {
                console.log('workflowaction_deleted received from steplist', del_data)
                this.updateStep(del_data.step)
            })
        },



        data() {
            return {
                workflowsteps: this.workflowsteps_prop,
                data: [],
                total: 0,
                loading: false,
                sortField: 'vote_count',
                sortOrder: 'desc',
                defaultSortOrder: 'desc',
                page: 1,
                perPage: 20
            }
        },
        methods: {
            /*
             * Load async data
             */
            loadAsyncData() {
                const params = [
                    'api_key=bb6f51bef07465653c3e553d6ab161a8',
                    'language=en-US',
                    'include_adult=false',
                    'include_video=false',
                    `sort_by=${this.sortField}.${this.sortOrder}`,
                    `page=${this.page}`
                ].join('&')

                this.loading = true
                axios.get(`https://api.themoviedb.org/3/discover/movie?${params}`)
                    .then(({ data }) => {
                        // api.themoviedb.org manage max 1000 pages
                        this.data = []
                        let currentTotal = data.total_results
                        if (data.total_results / this.perPage > 1000) {
                            currentTotal = this.perPage * 1000
                        }
                        this.total = currentTotal
                        data.results.forEach((item) => {
                            item.release_date = item.release_date.replace(/-/g, '/')
                            this.data.push(item)
                        })
                        this.loading = false
                    })
                    .catch((error) => {
                        this.data = []
                        this.total = 0
                        this.loading = false
                        throw error
                    })
            },
            /*
             * Handle page-change event
             */
            onPageChange(page) {
                this.page = page
                this.loadAsyncData()
            },
            /*
             * Handle sort event
             */
            onSort(field, order) {
                this.sortField = field
                this.sortOrder = order
                this.loadAsyncData()
            },
            /*
             * Type style in relation to the value
             */
            type(value) {
                const number = parseFloat(value)
                if (number < 6) {
                    return 'is-danger'
                } else if (number >= 6 && number < 8) {
                    return 'is-warning'
                } else if (number >= 8) {
                    return 'is-success'
                }
            },
            columnTdAttrs(row, column) {
                if (row.id === 'Total') {
                    if (column.label === 'ID') {
                        return {
                            colspan: 4,
                            class: 'has-text-weight-bold',
                            style: {
                                'text-align': 'left !important'
                            }
                        }
                    } else if (column.label === 'Gender') {
                        return {
                            class: 'has-text-weight-semibold'
                        }
                    } else {
                        return {
                            style: {display: 'none'}
                        }
                    }
                }
                return null
            }
        },
        filters: {
            /**
             * Filter to truncate string, accepts a length parameter
             */
            truncate(value, length) {
                return value.length > length
                    ? value.substr(0, length) + '...'
                    : value
            }
        },

    };
</script>
<style scoped>

</style>
