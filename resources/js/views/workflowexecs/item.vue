<template>
    <div class="card collapsed-card border-0">

        <header>
            <div class="card-header-title row">
                <div class="col-md-6 col-sm-8 col-12">
                    <span class="text-black text-sm">
                        Traitement(s)
                    </span>
                </div>
                <div class="col-md-6 col-sm-4 col-12 text-right">
                    <span class="text text-xs">
                        <b-tag v-if="exec.workflowstatus.code === 'new'" type="is-default is-light" size="is-small">{{ exec.workflowstatus.name }}</b-tag>
                        <span v-else-if="exec.workflowstatus.code === 'pending'">
                            <b-tag type="is-info is-light" size="is-small">{{ exec.workflowstatus.name }}</b-tag>
                            <span class="text text-italic"> ({{ exec.currentstep.titre }})</span>
                        </span>
                        <b-tag v-else-if="exec.workflowstatus.code === 'processing'" type="is-warning is-light" size="is-small">{{ exec.workflowstatus.name }}</b-tag>
                        <b-tag v-else-if="exec.workflowstatus.code === 'validated'" type="is-success is-light" size="is-small">{{ exec.workflowstatus.name }}</b-tag>
                        <b-tag v-else-if="exec.workflowstatus.code === 'rejected'" type="is-danger is-light" size="is-small">{{ exec.workflowstatus.name }}</b-tag>

                        <a type="button" class="btn btn-tool" @click="collapseClicked()" data-card-widget="collapse">
                            <i :class="currentCollapseIcon"></i>
                        </a>
                        <a type="button" class="btn btn-tool" data-card-widget="maximize">
                            <i class="fas fa-expand"></i>
                        </a>
                    </span>
                </div>
            </div>
            <!-- /.user-block -->
        </header>
        <!-- /.card-header -->

        <div class="card-body p-0">
            <div class="card-body table-responsive p-0" style="min-height: 200px;">
                <table class="table m-0">
                    <thead v-if="exec.execsteps.length > 0">
                        <tr class="text text-sm">
                            <th>Détails</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(execstep, index) in exec.execsteps" v-if="exec.execsteps" class="text text-xs">
                            <td>
                                <ExecStep :execstep_prop="execstep"></ExecStep>
                            </td>
                            <td>
                                <span v-if="execstep.workflowstatus.code === 'new'" class="badge badge-default">{{ execstep.workflowstatus.name }}</span>
                                <span v-else-if="execstep.workflowstatus.code === 'pending'" class="badge badge-info">{{ execstep.workflowstatus.name }}</span>
                                <span v-else-if="execstep.workflowstatus.code === 'processing'" class="badge badge-warning">{{ execstep.workflowstatus.name }}</span>
                                <span v-else-if="execstep.workflowstatus.code === 'validated'" class="badge badge-success">{{ execstep.workflowstatus.name }}</span>
                                <span v-else-if="execstep.workflowstatus.code === 'rejected'" class="badge badge-danger">{{ execstep.workflowstatus.name }}</span>
                            </td>
                            <td>
                                {{ execstep.start_at | formatDate }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.card-body -->
        <div class="card-footer">

            <div class="row">
                <div class="col-sm-4 border-right">
                    <div v-if="exec.prevstep" class="description-block">
                        <h5 class="description-header"><i class="fa fa-arrow-left"></i></h5>
                        <span class="text text-sm">{{ exec.prevstep.titre }}</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 border-right">
                    <div v-if="exec.currentstep" class="description-block">
                        <h5 class="description-header">
                            <a v-if="canexecworkflowstep" href="#" @click.prevent="traiterEtape(exec.uuid)">
                                <i class="fa fa-pencil-square-o text-green" aria-hidden="true"></i>
                            </a>
                            <span v-else><i class="fa fa-times-circle-o text-danger"></i></span>
                        </h5>
                        <span class="text text-sm">{{ exec.currentstep.titre }}</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4">
                    <div v-if="exec.currentstep.transitionpassstep" class="description-block">
                        <h5 class="description-header"><i class="fa fa-arrow-right"></i></h5>
                        <span class="text text-sm">{{ exec.currentstep.transitionpassstep.titre }}</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <!-- /.col -->
            </div>

        </div>
        <!-- /.card-footer -->
        <ExecProcess></ExecProcess>
    </div>
    <!-- /.card -->
</template>

<script>
    import ExecProcess from '../workflowexecs/process_new'
    import ExecStep from '../workflowexecsteps/details'

    export default {
        name: "execItem",
        props: {
            exec_prop: {},
            userprofiles_prop: {},
            moredata_prop: {},
        },
        components: {
            ExecProcess, ExecStep
        },
        data() {
            return {
                exec: this.exec_prop,
                userprofiles: this.userprofiles_prop,
                moredata: this.moredata_prop,
                collapse_icon: 'fas fa-chevron-down'
            };
        },
        mounted() {
            this.$on('etape_traitee', (data) => {
                this.updateData(data)
            })
        },
        methods: {
            traiterEtape(id) {
                // cheque.currmodelstep.uuid,cheque.CHEQUE_NB,cheque.ACC_CODE,cheque.TRN_AMOUNT
                let moredata = this.moredata

                axios.get(`/workflowexecs/${id}`)
                    .then(({data}) => {
                        console.log('get workflowexecs', data)
                        let actionvalues = data.actionvalues
                        let rejectactionvalues = data.rejectactionvalues
                        let exec = data.exec
                        let currentstep = data.currentstep
                        let enumvalues = data.enumvalues

                        this.$emit('traiter_etape', {exec, currentstep, actionvalues, rejectactionvalues, enumvalues, moredata})
                    });
            },
            updateData(data) {
                this.exec = data;
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
            canexecworkflowstep() {

                if (this.exec.workflowstatus.code === 'processing' || this.exec.currentstep.type.code === 'end') {
                    return false;
                } else if (this.exec.currentapprovers) {
                    let currentapprovers = this.exec.currentapprovers

                    var found = false;
                    for (var i = 0; i < currentapprovers.length; i++) {
                        var roleIndex = this.userprofiles.findIndex(r => {
                            return currentapprovers[i].id === r.id
                        })
                        if (roleIndex > -1) {
                            found = true;
                            break;
                        }
                    }

                    return found; //roleIndex !== -1;
                } else {
                    return false
                }

            },
            currentCollapseIcon() {
                return this.collapse_icon;
            }
        }
    }
</script>

<style scoped>

</style>
