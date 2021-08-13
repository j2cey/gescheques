<template>
    <div class="modal fade draggable" id="processExec" tabindex="-1" role="dialog" aria-labelledby="processExecLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="user-block">
                        <span class="description" v-if="moredata">
                            <dl class="row">
                                <span v-for="(value, propertyName) in moredata" class="text-lighter hidden-sm-down">
                                    <dt class="col-sm-12 text-xs"><small><strong>{{ propertyName }}</strong></small></dt>
                                    <dd class="col-sm-12 text-xs">{{ value }}</dd>
                                </span>
                            </dl>
                        </span>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                    <div class="card border-0">
                        <div class="card-header d-flex p-0">
                            <h3 class="card-title p-2"><span class="username text-xs text-purple" v-if="currentstep">{{ currentstep.titre }}</span></h3>
                            <ul class="nav nav-pills ml-auto p-1">
                                <li class="nav-item"><a class="nav-link active btn-outline-success" href="#tab_validate" data-toggle="tab"><span class="username text-xs">Traiter</span></a></li>
                                <li class="nav-item"><a class="nav-link btn-outline-danger" href="#tab_reject" data-toggle="tab"><span class="username text-xs">Rejéter</span></a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_validate">
                                    <ProcessForm :treatment_type_prop="validation_treatment_type"></ProcessForm>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="tab_reject">
                                    <ProcessForm :treatment_type_prop="rejection_treatment_type"></ProcessForm>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- ./card -->


                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Fermer</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
    import Multiselect from "vue-multiselect";
    import ExecBus from "./ExecBus";

    export default {
        name: "process_new",
        components: { Multiselect, ProcessForm: () => import('./process-form') },
        mounted() {
            this.$parent.$on('traiter_etape', ( process_data ) => {

                this.currentstep = process_data.currentstep
                this.moredata = process_data.moredata

                let validation_treatment_type_code = this.validation_treatment_type.code
                let rejection_treatment_type_code = this.rejection_treatment_type.code

                let processdata = {
                    'exec': process_data.exec,
                    'currentstep': process_data.currentstep,
                    'nextstep': {
                        [validation_treatment_type_code]: process_data.currentstep.validatednextstep,
                        [rejection_treatment_type_code]: process_data.currentstep.rejectednextstep
                    },
                    'actions': {
                        [validation_treatment_type_code]: process_data.currentstep.validationactions,
                        [rejection_treatment_type_code]: process_data.currentstep.rejectionactions
                    },
                    'actionvalues': {
                        [validation_treatment_type_code]: process_data.actionvalues,
                        [rejection_treatment_type_code]: process_data.rejectactionvalues
                    },
                    'enumvalues': process_data.enumvalues
                }

                ExecBus.$emit('step_process', processdata)

                // reset modal if it isn't visible
                if (!($('.modal.in').length)) {
                    $('.modal-dialog').css({
                        top: 50,
                        left: 50
                    });
                }
                $('#processExec').modal({
                    backdrop: false,
                    keyboard: false,
                    show: true
                });

                $('.modal-dialog').draggable({
                    handle: ".modal-header",   //  Can only click on the head to drag
                    cursor: 'move',
                    refreshPositions: false,
                    scroll: false,
                    //containment: "parent"
                });
            })

            ExecBus.$on('step_processed', (data) => {
                this.$parent.$emit('etape_traitee', data)
            })
        },
        created() {
            axios.get('/workflowtreatmenttypes.fetchsplitted')
                .then(resp => {
                    this.validation_treatment_type = resp.data.validation_treatment_type
                    this.rejection_treatment_type = resp.data.rejection_treatment_type
                    this.expiration_treatment_type = resp.data.expiration_treatment_type
                });
        },
        data() {
            return {
                currentstep: {},
                moredata: {},
                validation_treatment_type: {},
                rejection_treatment_type: {},
                expiration_treatment_type: {}
            }
        },
        methods: {
        },
        computed: {
        }
    }
</script>

<style scoped>
    @media only screen and (min-width: 991px) {
        .navbar {
            padding-top: 0;
            padding-bottom: 0;
        }

        .nav-pills .nav-link {
            padding-top: 5px;
            padding-bottom: 5px;
            border-radius: 0;
        }
    }
</style>
