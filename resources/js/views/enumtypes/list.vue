<template>
    <div class="card card-default">
        <div class="card-header">
            <div class="form-inline float-left">
                <span class="help-inline pr-1 text-sm"> Liste des Types Composés </span>
                <b-button size="is-small" type="is-info is-light" @click="createEnumType()"><i class="fas fa-plus"></i></b-button>
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
                :data="enumtypes"
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
                            <span v-else-if="column.field === 'name'" class="has-text-primary is-italic text-xs">
                                <a @click="editEnumType(props.row)">
                                    {{ props.row[column.field] }}
                                </a>
                            </span>
                            <span v-else-if="column.date" class="tag is-light is-small">
                                {{ props.row[column.field] | formatDate }}
                            </span>
                            <span v-else-if="column.field === 'enumvalues'">
                                <b-tag v-if="props.row.enumvalues.length < 2" type="is-danger is-light" rounded>{{ props.row.enumvalues.length }}</b-tag>
                                <b-tag v-else type="is-success is-light" rounded>{{ props.row.enumvalues.length }}</b-tag>
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
                            <span class="help-inline pr-1 text-sm"> Valeur(s) du Type </span>
                            <b-button size="is-small" type="is-info is-light" @click="createEnumValue(props.row)"><i class="fas fa-plus"></i></b-button>
                        </div>
                    </b-field>
                    <hr />
                    <EnumValues :enumtypeid_prop="props.row.id" :enumvalues_prop="props.row.enumvalues"></EnumValues>
                </template>

                <template #empty>
                    <div class="has-text-centered">Aucune Données</div>
                </template>

            </b-table>

        </div>
        <!-- /.card-body -->
        <AddUpdateEnumType></AddUpdateEnumType>
        <AddUpdateEnumValue></AddUpdateEnumValue>
    </div>
    <!-- /.card -->
</template>

<script>
    import EnumTypeBus from './enumtypeBus';
    import EnumValueBus from "../enumvalues/enumvalueBus";

    export default {
        name: "enumtype-list",
        components: {
            EnumValues: () => import('../enumvalues/list'),
            AddUpdateEnumType: () => import('../enumtypes/addupdate'),
            AddUpdateEnumValue: () => import('../enumvalues/addupdate'),
        },
        mounted() {
            EnumTypeBus.$on('enumtype_created', (add_data) => {
                console.log('enumtype_to_add received at enumtypes.list', add_data)
                this.addEnumType(add_data.enumtype)
            })

            EnumTypeBus.$on('enumtype_updated', (upd_data) => {
                // Type Composé modifié à mettre à jour sur la liste
                console.log('enumtype_to_update received at enumtypes.list', upd_data)
                this.updateEnumType(upd_data.enumtype)
            })

            EnumValueBus.$on('enumvalue_created', (add_data) => {
                console.log('enumvalue_created received from enumtype_list', add_data)
                this.updateEnumType(add_data.enumtype)
            })

            EnumValueBus.$on('enumvalue_updated', (upd_data) => {
                console.log('enumvalue_updated received from enumtype_list', upd_data)
                this.updateEnumType(upd_data.enumtype)
            })

            EnumValueBus.$on('enumvalue_deleted', (del_data) => {
                console.log('enumvalue_deleted received from enumtype_list', del_data)
                this.updateEnumType(del_data.enumtype)
            })
        },
        data() {
            return {
                enumtypes: [],
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
                        field: 'name',
                        key: 'name',
                        label: 'Nom',
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
                        field: 'enumvalues',
                        key: 'enumvalues',
                        label: 'Valeur(s)',
                        searchable: false,
                        sortable: false,
                    },
                    {
                        field: 'created_at',
                        key: 'created_at',
                        label: 'Date Création',
                        date: true,
                        searchable: false,
                        sortable: true,
                    },
                    {
                        field: 'updated_at',
                        key: 'updated_at',
                        label: 'Date Modification',
                        date: true,
                        searchable: false,
                        sortable: true,
                    },
                    {
                        field: 'status',
                        key: 'status',
                        label: 'Statut',
                        searchable: false,
                        sortable: true,
                    },
                ]
            }
        },
        created() {
            axios.get('/enumtypes.fetch')
                .then(({data}) => this.enumtypes = data);
        },
        methods: {
            createEnumType() {
                EnumTypeBus.$emit('enumtype_create');
            },
            editEnumType(enumtype) {
                EnumTypeBus.$emit('enumtype_edit', enumtype);
            },
            createEnumValue(enumtype) {
                EnumValueBus.$emit('enumvalue_create', enumtype);
            },
            addEnumType(enumtype) {
                let enumtypeIndex = this.enumtypes.findIndex(c => {
                    return enumtype.id === c.id
                })

                // si ce type composé n'existe pas déjà, on l'insère dans la liste
                if (enumtypeIndex === -1) {
                    this.enumtypes.push(enumtype)
                }
            },
            updateEnumType(enumtype) {
                // on récupère l'index du type composé modifié
                let enumtypeIndex = this.enumtypes.findIndex(s => {
                    return enumtype.id === s.id
                })

                if (enumtypeIndex > -1) {
                    this.enumtypes.splice(enumtypeIndex, 1, enumtype)
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
