<template>
    <div class="card collapsed-card border-0">
        <div class="card-header border-transparent">
            <h3 class="card-title">Traitement(s)</h3>

            <div class="card-tools text-xs">
                <span v-if="exec.workflowstatus.code === 'new'" class="badge badge-default">{{ exec.workflowstatus.name }}</span>
                <span v-else-if="exec.workflowstatus.code === 'pending'"><span class="badge badge-info">{{ exec.workflowstatus.name }}</span> <span class="text text-italic"> ({{ exec.currentstep.titre }})</span></span>
                <span v-else-if="exec.workflowstatus.code === 'processing'" class="badge badge-warning">{{ exec.workflowstatus.name }}</span>
                <span v-else-if="exec.workflowstatus.code === 'validated'" class="badge badge-success">{{ exec.workflowstatus.name }}</span>
                <span v-else-if="exec.workflowstatus.code === 'rejected'" class="badge badge-danger">{{ exec.workflowstatus.name }}</span>
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-plus"></i>
                </button>
                <!-- Maximize Button -->
                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                <!--<button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>-->
            </div>
        </div>
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

            }
        }
    }
</script>

<style scoped>

</style>
