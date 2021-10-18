<template>
    <div class="card">
        <header>
            <div class="card-header-title row">
                <div class="col-md-6 col-sm-9 col-12">
                    <span class="text-indigo text-xs" @click="collapseClicked()" data-toggle="collapse" data-parent="#criterionlist" :href="'#collapse-criteria-'+index">
                        <b-taglist attached>
                            <b-tag >
                                <b-icon v-if="criterion.is_start_criterion" icon="arrow-right" size="is-small" type="is-danger"></b-icon>
                                <b-icon v-else icon="arrow-left" size="is-small" type="is-success"></b-icon>
                            </b-tag>
                            <b-tag >{{ criterion.title }}</b-tag>
                        </b-taglist>
                    </span>
                </div>
                <div class="col-md-6 col-sm-3 col-12 text-right">
                    <span class="text text-xs">
                        <a type="button" class="btn btn-tool text-warning" data-toggle="tooltip" @click="editCriterion(criterion)">
                            <i class="fa fa-pencil-square-o"></i>
                        </a>
                        <a type="button" class="btn btn-tool" @click="collapseClicked()" data-toggle="collapse" data-parent="#criterionlist" :href="'#collapse-criteria-'+index">
                            <i :class="currentCollapseIcon"></i>
                        </a>
                        <a type="button" class="btn btn-tool text-danger" @click="deleteCriterion(criterion.uuid, index)">
                            <i class="fa fa-trash"></i>
                        </a>
                    </span>
                </div>
            </div>
            <!-- /.user-block -->
        </header>
        <!-- /.card-header -->
        <div :id="'collapse-criteria-'+index" class="card-content panel-collapse collapse in">
            <dl class="row">
                <dt class="col-sm-4 text-xs">Description</dt>
                <dd class="col-sm-8 text-xs">{{ criterion.description }}</dd>
                <dt class="col-sm-4 text-xs" v-if="criterion.status">Statut</dt>
                <dd class="col-sm-8 text-xs" v-if="criterion.status">
                    <b-tag type="is-success is-light" v-if="criterion.status.code === 'active'">{{ criterion.status.name }}</b-tag>
                    <b-tag type="is-danger is-light" v-else>{{ criterion.status.name }}</b-tag>
                </dd>
            </dl>
        </div>
        <!-- /.card-body -->
    </div>
</template>

<script>
    import CriterionBus from "../remindercriteria/remindercriteriaBus";

    export default {
        name: "criterion-item",
        props: {
            criterion_prop: {},
            reminder_prop: {},
            index_prop: {}
        },
        components: {
        },
        mounted() {
            CriterionBus.$on('criterion_updated', (upd_data) => {
                if (this.criterion.id === upd_data.criterion.id) {
                    this.updateEnumValue(upd_data.criterion)
                }
            })
        },
        data() {
            return {
                criterion: this.criterion_prop,
                reminder: this.reminder_prop,
                index: this.index_prop,
                collapse_icon: 'fas fa-chevron-down',
                isOpen: true
            }
        },
        methods: {
            editCriterion(criterion) {
                let reminder = this.reminder
                CriterionBus.$emit('criterion_edit', {reminder, criterion});
            },
            updateEnumValue(criterion) {
                this.criterion = criterion
            },
            deleteCriterion(id, key) {
                this.$swal({
                    html: '<small>Are sure you want to delete ?</small>',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Non'
                }).then((result) => {
                    if(result.value) {

                        axios.delete(`/remindercriteria/${id}`)
                            .then(resp => {

                                let criterion = resp.data.criterion
                                let reminder = resp.data.reminder

                                console.log('criteria delete resp: ', resp)

                                this.$swal({
                                    html: '<small>Criterion successfully deleted !</small>',
                                    icon: 'success',
                                    timer: 3000
                                }).then(() => {
                                    CriterionBus.$emit('criterion_deleted', {key, criterion, reminder})
                                })
                            }).catch(error => {
                            window.handleErrors(error)
                        })

                    } else {
                        // stay here
                    }
                })
            },
            collapseClicked() {
                if (this.collapse_icon === 'fas fa-chevron-down') {
                    this.collapse_icon = 'fas fa-chevron-up';
                } else {
                    this.collapse_icon = 'fas fa-chevron-down';
                }
            }
        },
        computed: {
            currentCollapseIcon() {
                return this.collapse_icon;
            }
        }
    }
</script>

<style scoped>

</style>
