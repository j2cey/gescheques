<template>
    <div class="card collapsed-card">
        <div class="card-header border-0">
            <h5 class="card-title text-xs">{{ execstep.step.titre }} <span v-if="execstep.effectiverole" class="text font-weight-light font-italic">({{ execstep.effectiverole.name }})</span></h5>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0" style="height: 150px;">
            <table class="table table-head-fixed text-nowrap">
                <tbody>
                    <tr v-for="(execaction, index) in execstep.execactions" v-if="execstep.execactions" class="text text-xs">
                        <td>
                            <ExecAction :execaction_prop="execaction"></ExecAction>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</template>

<script>
    import ExecAction from '../workflowexecactions/item'

    export default {
        name: "execStepDetails",
        props: {
            execstep_prop: {},
        },
        components: {
            ExecAction
        },
        data() {
            return {
                execstep: this.execstep_prop,
            };
        },
    }
</script>

<style scoped>

</style>
