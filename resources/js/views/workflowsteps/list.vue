<template>

    <section>
        <p>Les Etapes.</p>
        <b-field grouped group-multiline>
            <b-select v-model="perPage" :disabled="!isPaginated">
                <option value="5">5 par page</option>
                <option value="10">10 par page</option>
                <option value="15">15 par page</option>
                <option value="20">20 par page</option>
            </b-select>
        </b-field>
        <b-table
            :data="workflowsteps"
            ref="table"
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
            aria-next-label="Next page"
            aria-previous-label="Previous page"
            aria-page-label="Page"
            aria-current-label="Current page" :before-destroy="false">

            <template v-for="column in columns">
                <b-table-column :key="column.id" v-bind="column" :sortable="column.sortable" :custom-search="searchLastName">
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
                        <span v-else-if="column.field === 'titre'" class="has-text-primary is-italic text-xs">
                            <a @click="editWorkflowstep(props.row)">
                                {{ props.row[column.field] }}
                            </a>
                        </span>
                        <span v-else-if="column.date" class="tag is-success">
                            {{ new Date( props.row[column.field] ).toLocaleDateString() }}
                        </span>
                        <span v-else-if="column.field === 'actions'">
                            <b-taglist>
                                <b-tag type="is-primary is-light">{{ props.row.actionspass.length }}</b-tag>
                                <b-tag type="is-danger is-light">{{ props.row.actionsreject.length }}</b-tag>
                            </b-taglist>
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
                        <span class="help-inline pr-1 text-sm"> Action(s) de l'Etape </span>
                        <b-button size="is-small" type="is-info is-light" @click="createNewAction(props.row)"><i class="fas fa-plus"></i></b-button>
                    </div>
                </b-field>
                <hr />
                <WorkflowActions :workflowstepid_prop="props.row.id" :workflowactions_prop="props.row.actions"></WorkflowActions>
            </template>

            <template #empty>
                <div class="has-text-centered">Aucune Données</div>
            </template>

        </b-table>

        <AddUpdateAction></AddUpdateAction>
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
                //data: this.workflowsteps_prop,
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
                        label: 'ID',
                        numeric: true,
                        searchable: false,
                        sortable: true,
                    },
                    {
                        field: 'titre',
                        label: 'Titre',
                        searchable: true,
                        sortable: true,
                    },
                    {
                        field: 'description',
                        label: 'Description',
                        searchable: true,
                        sortable: true,
                    },
                    {
                        field: 'actions',
                        label: 'Action(s)',
                        width: '100',
                        centered: true,
                        sortable: false,
                    }
                ]
            };
        },
        methods: {
            searchTitre(propsRowMyObject) //accept props.row.myObject
            {
                return [propsRowMyObject.titre,propsRowMyObject.titre].filter(i => i).join(' ')
            },
            searchLastName(row, input) {
                console.log('Searching...', row, input)
                return input && row.titre && row.titre.includes(input);
            },
            createNewAction(workflowstep) {
                axios.get(`/workflowactions.fetchbystep/${workflowstep.id}`)
                    .then((resp => {
                        ActionBus.$emit('workflowaction_create', workflowstep, resp.data);
                    }));
            },
            editWorkflowstep(workflowstep) {
                axios.get(`/workflowsteps.fetchbyworkflow/${workflowstep.workflow_id}`)
                    .then((resp => {
                        StepBus.$emit('workflowstep_edit', workflowstep, this.workflow, resp.data);
                    }));
            },
            removeAt(idx) {
                this.list.splice(idx, 1);
            },
            add: function() {
                id++;
                this.list.push({ name: "Juan " + id, id, text: "" });
            },
            orderChanged(evt) {
                //console.log('gonna change order',evt, evt.moved.element, evt.moved.oldIndex, evt.moved.newIndex,this.workflowsteps);
                //console.log('lets change order:', this.workflowsteps);
                const fd = undefined;
                let changeForm = new Form({
                    'titre': evt.moved.element.titre,
                    'description': evt.moved.element.description,
                    'workflow_id': evt.moved.element.workflow_id,
                    'profile': evt.moved.element.profile,
                    'posi': evt.moved.newIndex,
                    'oldIndex': evt.moved.oldIndex,
                    'newIndex': evt.moved.newIndex,
                });
                changeForm
                    .put(`/workflowsteps/${evt.moved.element.uuid}`, fd)
                    .then(workflowsteps => {
                        //console.log('orderChanged', workflowsteps);
                        this.workflowsteps = workflowsteps;
                    }).catch(error => {
                    this.loading = false
                });
            },
            createStep(workflowstep) {
                let workflowstepIndex = this.workflowsteps.findIndex(c => {
                    return workflowstep.id === c.id
                })

                // si cette étape n'existe pas déjà, on l'insère dans la liste
                if (workflowstepIndex === -1) {
                    this.workflowsteps.push(workflowstep)
                }
            },
            updateStep(workflowstep) {
                // on récupère l'index de session modifiée
                let stepIndex = this.workflowsteps.findIndex(s => {
                    return workflowstep.id === s.id
                })

                if (stepIndex > -1) {
                    this.workflowsteps.splice(stepIndex, 1, workflowstep)
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
    };
</script>
<style scoped>

</style>
