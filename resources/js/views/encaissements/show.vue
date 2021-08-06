<template>
    <div class="modal fade" id="encaissementModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-sm">Détails Encaissement</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="card-body" >
                        <dl class="row" v-if="encaissement">
                            <dt class="col-sm-4 text-xs">Num. Paiement</dt>
                            <dd class="col-sm-8 text-xs">{{ encaissement.PaymentKey }}</dd>
                            <dt class="col-sm-4 text-xs">Num. Facture</dt>
                            <dd class="col-sm-8 text-xs">{{ encaissement.ReceiptNum }}</dd>
                            <dt class="col-sm-4 text-xs" v-if="encaissement.Reference">Référence Chèque</dt>
                            <dd class="col-sm-8 text-xs" v-if="encaissement.Reference">{{ encaissement.Reference }}</dd>

                            <dt class="col-sm-4 text-xs">Agence</dt>
                            <dd v-if="encaissement.agence" class="col-sm-8 offset-sm-4">
                                <small>
                                    <span class="text-lighter text-xs hidden-sm-down">
                                        <span class="badge badge-pill badge-secondary">
                                            {{ encaissement.agence.Location }}
                                        </span>
                                    </span>
                                </small>
                            </dd>
                            <dd v-if="encaissement.agence" class="col-sm-8 offset-sm-4">
                                <small>
                                    <span class="text-lighter text-xs hidden-sm-down">
                                        {{ encaissement.agence.LocationName }}
                                    </span>
                                </small>
                            </dd>

                            <dt class="col-sm-4 text-xs">Description</dt>
                            <dd class="col-sm-8 text-xs">{{ encaissement.PaymentID }}</dd>
                            <dt class="col-sm-4 text-xs">Date de Paiement</dt>
                            <dd class="col-sm-8 text-xs">{{ encaissement.DatePaid | formatDate }}</dd>
                            <dt class="col-sm-4 text-xs">Code Employé</dt>
                            <dd class="col-sm-8 text-xs">{{ encaissement.EmployeeCode }}</dd>
                            <dt class="col-sm-4 text-xs">Num. Client</dt>
                            <dd class="col-sm-8 text-xs">{{ encaissement.CustomerNo }}</dd>
                            <dt class="col-sm-4 text-xs">Classe de Paiement</dt>
                            <dd class="col-sm-8 text-xs">{{ encaissement.PaymentClass }}</dd>
                            <dt class="col-sm-4 text-xs">Classe de Paiement OSS360</dt>
                            <dd class="col-sm-8 text-xs">{{ encaissement.OSS360_PaymentClass }}</dd>
                            <dt class="col-sm-4 text-xs">Type de Paiement OSS360</dt>
                            <dd class="col-sm-8 text-xs">{{ encaissement.OSS360_PaymentType }}</dd>
                            <dt class="col-sm-4 text-xs">Date Historique</dt>
                            <dd class="col-sm-8 text-xs">{{ encaissement.HistoryDateTime | formatDate }}</dd>
                            <dt class="col-sm-4 text-xs">Statut Validation de Paiement</dt>
                            <dd class="col-sm-8 text-xs">{{ encaissement.PaymentValidationStatus }}</dd>
                            <dt class="col-sm-4 text-xs">Numéro de Suivi</dt>
                            <dd class="col-sm-8 text-xs">{{ encaissement.TrackingNumber }}</dd>
                            <dt class="col-sm-4 text-xs">Montant de Numéro de Suivi</dt>
                            <dd class="col-sm-8 text-xs">{{ encaissement.TrackingNumberAmmount }}</dd>
                            <dt class="col-sm-4 text-xs">Banque</dt>
                            <dd class="col-sm-8 text-xs">{{ encaissement.BankName }}</dd>
                            <dt class="col-sm-4 text-xs">Numéro de Compte</dt>
                            <dd class="col-sm-8 text-xs">{{ encaissement.AccountNumber }}</dd>
                            <dt class="col-sm-4 text-xs">Montant Initial</dt>
                            <dd class="col-sm-8 text-xs">{{ encaissement.Initial_TotalAmountPaid | formatNumber }}</dd>
                            <dt class="col-sm-4 text-xs">Montant Final</dt>
                            <dd class="col-sm-8 text-xs">{{ encaissement.Final_TotalAmountPaid | formatNumber }}</dd>
                        </dl>
                    </div>

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
    export default {
        name: "show",
        mounted() {

            this.$parent.$on('encaissement_display', (record) => {

                this.encaissement = record

                $('#encaissementModal').modal()
            })
        },
        data() {
            return {
                encaissement: {}
            }
        },
    }
</script>

<style scoped>

</style>
