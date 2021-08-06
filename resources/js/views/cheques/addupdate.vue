<template>
    <div class="modal fade" id="addUpdateCheque" tabindex="-1" role="dialog" aria-labelledby="chequeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-sm" id="chequeModalLabel" v-if="editing">Modifier Chèque</h5>
                    <h5 class="modal-title text-sm" id="chequeModalLabel" v-else>Insérer Nouveau Chèque</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" @submit.prevent @keydown="chequeForm.errors.clear()">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="CHEQUE_NB" class="col-sm-4 col-form-label text-xs text-xs">Numéro Chèque</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="CHEQUE_NB" name="titre" placeholder="Numéro Chèque" v-model="chequeForm.CHEQUE_NB">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="chequeForm.errors.has('CHEQUE_NB')" v-text="chequeForm.errors.get('CHEQUE_NB')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="ACC_CODE" class="col-sm-4 col-form-label text-xs text-xs">Code Compte / Banque</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="ACC_CODE" name="ACC_CODE" placeholder="Code Compte" v-model="chequeForm.ACC_CODE">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="chequeForm.errors.has('ACC_CODE')" v-text="chequeForm.errors.get('ACC_CODE')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="DESCRIPTION" class="col-sm-4 col-form-label text-xs text-xs">Motif</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="DESCRIPTION" name="DESCRIPTION" placeholder="Motif" v-model="chequeForm.DESCRIPTION">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="chequeForm.errors.has('DESCRIPTION')" v-text="chequeForm.errors.get('DESCRIPTION')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="COMPLEMENTS1" class="col-sm-4 col-form-label text-xs text-xs">Complément Motif</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="COMPLEMENTS1" name="COMPLEMENTS1" placeholder="Complément Motif" v-model="chequeForm.COMPLEMENTS1">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="chequeForm.errors.has('COMPLEMENTS1')" v-text="chequeForm.errors.get('COMPLEMENTS1')"></span>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-primary btn-sm" @click="updateCheque()" :disabled="!isValidForm" v-if="editing">Enregistrer</button>
                    <button type="button" class="btn btn-primary btn-sm" @click="createCheque()" :disabled="!isValidForm" v-else>Créer Action</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'
    import ChequeBus from "./chequeBus";

    class Cheque {
        constructor(cheque) {
            this.NREC_BANK_MVT_ID = cheque.NREC_BANK_MVT_ID || ''
            this.ACC_CODE = cheque.ACC_CODE || ''
            this.BANK_FLOW_CODE = cheque.BANK_FLOW_CODE || ''
            this.ABK_CUR_AMOUNT = cheque.ABK_CUR_AMOUNT || ''
            this.ABK_CUR_CODE = cheque.ABK_CUR_CODE || ''
            this.TRN_FLAG = cheque.TRN_FLAG || ''
            this.TRN_AMOUNT = cheque.TRN_AMOUNT || ''
            this.TRN_CUR = cheque.TRN_CUR || ''
            this.CHEQUE_NB = cheque.CHEQUE_NB || ''
            this.BOOK_DATE = cheque.BOOK_DATE || ''
            this.VALUE_DATE = cheque.VALUE_DATE || ''
            this.DESCRIPTION = cheque.DESCRIPTION || ''

            this.COMPLEMENTS1 = cheque.COMPLEMENTS1 || ''
            this.COMPLEMENTS2 = cheque.COMPLEMENTS2 || ''
            this.COMPLEMENTS3 = cheque.COMPLEMENTS3 || ''
            this.COMPLEMENTS4 = cheque.COMPLEMENTS4 || ''
            this.COMPLEMENTS5 = cheque.COMPLEMENTS5 || ''

            this.SENSE_FLAG = cheque.SENSE_FLAG || ''
            this.EURO_GAP_FLAG = cheque.EURO_GAP_FLAG || ''
            this.BANK_CUR_AMOUNT = cheque.BANK_CUR_AMOUNT || ''
            this.BANK_CUR_CODE = cheque.BANK_CUR_CODE || ''
            this.INTERNAL_MVT_ID = cheque.INTERNAL_MVT_ID || ''
            this.IMPORT_PROCESS_LOG_ID = cheque.IMPORT_PROCESS_LOG_ID || ''
            this.IMPORT_DATE = cheque.IMPORT_DATE || ''
            this.HISTORY_ID = cheque.HISTORY_ID || ''
            this.CALCULATION_METHOD = cheque.CALCULATION_METHOD || ''
            this.EXEMPT_FLAG = cheque.EXEMPT_FLAG || ''
            this.EXTRACT_FLAG = cheque.EXTRACT_FLAG || ''
            this.PRE_REC_ID = cheque.PRE_REC_ID || ''
            this.UNREC_DATE = cheque.UNREC_DATE || ''
            this.REC_TEMP_FLAG = cheque.REC_TEMP_FLAG || ''
            this.NOT_DIRTY_FLAG = cheque.NOT_DIRTY_FLAG || ''

            this.ZU_01 = cheque.ZU_01 || ''
            this.ZU_02 = cheque.ZU_02 || ''
            this.ZU_03 = cheque.ZU_03 || ''
            this.ZU_04 = cheque.ZU_04 || ''
            this.ZU_05 = cheque.ZU_05 || ''

            this.ROWVERSION = cheque.ROWVERSION || ''
            this.BankName_formatted = cheque.BankName_formatted || ''
        }
    }

    export default {
        name: "addupdate",
        components: { Multiselect },
        mounted() {
            this.$parent.$on('cheque_edit', (cheque) => {
                this.editing = true
                this.cheque = new Cheque(cheque)
                this.chequeForm = new Form(this.cheque)
                this.chequeId = cheque.uuid

                $('#addUpdateCheque').modal()
            })
        },
        created() {
        },
        data() {
            return {
                cheque: {},
                chequeForm: new Form(new Cheque({})),
                chequeId: null,
                editing: false,
                loading: false,
            }
        },
        methods: {
            updateCheque() {
                this.loading = true

                this.chequeForm
                    .put(`/cheques/${this.chequeId}`)
                    .then(cheque => {
                        this.loading = false
                        this.resetForm();

                        $('#addUpdateCheque').modal('hide')

                        this.$swal({
                            html: '<small>Chèque modifié avec succès !</small>',
                            type: 'success',
                            icon: 'success',
                            timer: 3000
                        }).then(() => {
                            ChequeBus.$emit('cheque_updated', cheque)
                        })

                    }).catch(error => {
                    this.loading = false
                });
            },
            resetForm() {
                this.chequeForm.reset();
            }
        },
        computed: {
            isValidForm() {
                return !this.loading
            }
        }
    }
</script>

<style scoped>

</style>
