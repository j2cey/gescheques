<template>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Détails Cheque</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Détails Cheque</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="row">
                <div class="col-12 col-md-12 col-lg-6 order-1 order-md-1">

                    <div class="card border-0">
                        <div class="card-header">
                            <h3 class="card-title">
                                Infos
                            </h3>

                            <div class="card-tools">
                                <a v-on:click="$emit('cheque_edit',cheque)" class="text text-success">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>
                                <!-- Maximize Button -->
                                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="card-body table-responsive p-0" style="height: 150px;">
                                <dl class="row">
                                    <dt class="col-sm-4 text-xs">Numéro Enregistrement</dt>
                                    <dd class="col-sm-8 text-xs">{{ cheque.NREC_BANK_MVT_ID }}</dd>
                                    <dt class="col-sm-4 text-xs">Code Compte</dt>
                                    <dd class="col-sm-8 text-xs">{{ cheque.ACC_CODE }}</dd>
                                    <dt class="col-sm-4 text-xs">Montant</dt>
                                    <dd class="col-sm-8 text-xs">{{ cheque.TRN_AMOUNT }}</dd>
                                    <dt class="col-sm-4 text-xs">Numero Chèque</dt>
                                    <dd class="col-sm-8 text-xs">{{ cheque.CHEQUE_NB }}</dd>
                                    <dt class="col-sm-4 text-xs">Date Enregistrement</dt>
                                    <dd class="col-sm-8 text-xs">{{ cheque.BOOK_DATE | formatDate }}</dd>
                                    <dt class="col-sm-4 text-xs">Date Valeur</dt>
                                    <dd class="col-sm-8 text-xs">{{ cheque.VALUE_DATE | formatDate }}</dd>
                                    <dt class="col-sm-4 text-xs">Motif</dt>
                                    <dd class="col-sm-8 text-xs">{{ cheque.COMPLEMENTS1 === 'NULL' ? cheque.DESCRIPTION : cheque.DESCRIPTION + '' + cheque.COMPLEMENTS1 }}</dd>
                                </dl>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>

                </div>

                <div class="col-12 col-md-12 col-lg-6 order-2 order-md-1">

                    <div class="card border-0">
                        <div class="card-header">
                            <h3 class="card-title">
                                Encaissement ARIS
                            </h3>

                            <div class="card-tools" v-if="cheque.encaissement">
                                <a v-on:click="$emit('encaissement_display', cheque.encaissement)" class="text text-success">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a>

                                <!-- Maximize Button -->
                                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="card-body table-responsive p-0" style="height: 150px;">
                                <dl class="row" v-if="cheque.encaissement">
                                    <dt class="col-sm-4 text-xs">Agence</dt>
                                    <dd class="col-sm-8 text-xs">{{ cheque.encaissement.agence.LocationName }}</dd>
                                    <dt class="col-sm-4 text-xs">Banque</dt>
                                    <dd class="col-sm-8 text-xs">{{ cheque.encaissement.BankName_formatted }}</dd>
                                    <dt class="col-sm-4 text-xs">Montant Initial</dt>
                                    <dd class="col-sm-8 text-xs">{{ cheque.encaissement.Initial_TotalAmountPaid }}</dd>
                                    <dt class="col-sm-4 text-xs">Montant Final</dt>
                                    <dd class="col-sm-8 text-xs">{{ cheque.encaissement.Final_TotalAmountPaid }}</dd>
                                    <dt class="col-sm-4 text-xs">Numéro Compte</dt>
                                    <dd class="col-sm-8 text-xs">{{ cheque.encaissement.AccountNumber }}</dd>
                                    <dt class="col-sm-4 text-xs">Libellé Paiement</dt>
                                    <dd class="col-sm-8 text-xs">{{ cheque.encaissement.PaymentID }}</dd>
                                </dl>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>

                </div>

            </div>
            <!-- /.card -->

            <ExecItem :exec_prop="cheque.workflowexec" :userprofiles_prop="userprofiles" :moredata_prop="moredata"></ExecItem>

        </section>
        <!-- /.content -->
        <ImgShow></ImgShow>
        <EncaissementShow></EncaissementShow>
        <ChequeAddUpdate></ChequeAddUpdate>
    </div>

</template>

<script>
    import ExecItem from '../workflowexecs/item'
    import EncaissementShow from '../encaissements/show'
    import ChequeAddUpdate from './addupdate'
    import ChequeBus from "./chequeBus";

    export default {
        name: "cheque-show",
        props: {
            cheque_prop: {},
            actionvalues_prop: {},
            userprofiles_prop: {}
        },
        components: {
            ExecItem, EncaissementShow, ChequeAddUpdate, ImgShow: () => import('../workflowexecs/imgscan')
        },
        mounted() {
            ChequeBus.$on('cheque_updated', (cheque) => {
                console.log('cheque_updated', cheque)
                this.cheque = cheque
            })
        },
        created() {
        },
        data() {
            return {
                cheque: this.cheque_prop,
                actionvalues: this.actionvalues_prop,
                filename: 'Télécharger un fichier',
                filefieldname: null,
                selectedFile : null,
                userprofiles: this.userprofiles_prop
            };
        },
        methods: {
            showImage(scanUrl) {
                this.$emit('show_image', scanUrl)
            },
        },
        computed: {
            scanUrl() {
                if (this.cheque.scan_cheque) {
                    return '/uploads/cheques/scans/' + this.cheque.scan_cheque
                } else {
                    return ""
                }
            },
            moredata() {
                return  {
                    'Num. Chèque': this.cheque.CHEQUE_NB,
                    'Code Compte': this.cheque.ACC_CODE,
                    'Montant Frais': this.cheque.TRN_AMOUNT
                }
            }
        }
    }
</script>

<style scoped>

</style>
