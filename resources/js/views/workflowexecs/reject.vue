<template>
    <div class="modal fade" id="rejectStep" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg card card-outline card-danger">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <span class="username text-sm text-orange">Rejéter cette étape</span>
                    </h5>
                    <button type="button" class="close" @click="closeForm()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" @submit.prevent>
                        <div class="card-body">

                            <div class="form-group row" v-for="(action, index) in rejectactions" v-if="rejectactions">

                                <div class="col-sm-10" v-if="action.actiontype.code === 'DATETIME_value' && action.dedicated_form === 'validation'">
                                    <VueCtkDateTimePicker v-model="rejectForm[action.code]" :label="action.titre" format="YYYY-MM-DD hh:mm:ss" />
                                    <span class="invalid-feedback d-block" role="alert" v-if="rejectForm.errors.has(`${action.code}`)" v-text="rejectForm.errors.get(`${action.code}`)"></span>
                                </div>
                                <div class="col-sm-10" v-else-if="action.code === 'DATE_value' && action.dedicated_form === 'validation'">
                                    <VueCtkDateTimePicker v-model="rejectForm[action.code]" :label="action.titre" format="YYYY-MM-DD" />
                                    <span class="invalid-feedback d-block" role="alert" v-if="rejectForm.errors.has(`${action.code}`)" v-text="rejectForm.errors.get(`${action.code}`)"></span>
                                </div>
                                <div class="col-sm-10" v-else-if="action.actiontype.code === 'EnumType' && action.dedicated_form === 'validation'">
                                    <multiselect
                                        :id="action.code"
                                        v-model="rejectForm[action.code]"
                                        selected.sync="rejectForm[action.code]"
                                        value=""
                                        :options="enumvalues[action.code]"
                                        :searchable="true"
                                        :multiple="false"
                                        label="val"
                                        track-by="val"
                                        key="val"
                                        :placeholder="action.titre"
                                    >
                                    </multiselect>
                                </div>
                                <div class="col-sm-10" v-else>
                                    <input type="text" class="form-control form-control-sm text-xs" :id="action.code" :name="action.code" :placeholder="action.titre" v-model="rejectForm[action.code]">
                                    <span class="invalid-feedback d-block" role="alert" v-if="rejectForm.errors.has(`${action.code}`)" v-text="rejectForm.errors.get(`${action.code}`)"></span>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary btn-sm" @click="closeForm()">Fermer</button>
                    <button type="button" class="btn btn-danger btn-sm" @click="validateForm(execId, motif)" :disabled="!isValidForm">Valider</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'

    export default {
        name: "reject",
        props: {
        },
        components: { Multiselect },
        mounted() {
            this.$parent.$on('validate_reject', (data) => {
                console.log("validate_reject received", data) //, rejectaction, enumvalues
                this.execId = data.execId
                this.motif = null;
                this.enumvalues = data.enumvalues;
                this.rejectactions = data.rejectactions;
                this.rejectactionvalues = data.rejectactionvalues;

                this.rejectForm = new Form(data.rejectactionvalues)

                $('#rejectStep').modal()
            })
        },
        created() {
        },
        data() {
            return {
                execId: null,
                motif: null,
                rejectactions: null,
                rejectactionvalues: {},
                enumvalues: {},
                rejectForm: new Form({ 'actionvalues': this.rejectactionvalues }),
            }
        },
        methods: {
            validateForm(execId, raw_motif) {
                let rejectform = this.rejectForm
                this.$parent.$emit('reject_validated', {execId, rejectform})
                $('#rejectStep').modal('hide')
            },
            closeForm() {
                $('#rejectStep').modal('hide')
            }
        },
        computed: {
            isValidForm() {
                // TODO: boucler sur tous les actionvalues pour s'assurer que tout est renseigné
                return true;// this.motif && this.motif !== "null"
            }
        }
    }
</script>
