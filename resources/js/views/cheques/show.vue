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
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Détails Cheque</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12 order-1 order-md-1">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-6 order-1 order-md-1">

                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                Infos
                                            </h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <div class="card-body table-responsive p-0" style="height: 90px;">
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

                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                Encaissement ARIS
                                            </h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <div class="card-body table-responsive p-0" style="height: 90px;">
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

                        </div>

                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <ExecItem :exec_prop="cheque.workflowexec" :userprofiles_prop="userprofiles" :moredata_prop="moredata"></ExecItem>

        </section>
        <!-- /.content -->
        <ImgShow></ImgShow>
    </div>

</template>

<script>
    import ExecItem from '../workflowexecs/item'
    export default {
        name: "show",
        props: {
            cheque_prop: {},
            actionvalues_prop: {},
            hasexecrole_prop: 0,
            userprofiles_prop: {} // TODO: Recevoir tous les profiles de l utilisateur et écrire une fonction pour évaluer le droit
        },
        components: {
            ExecItem, ImgShow: () => import('../workflowexecs/imgscan')
        },
        created() {

        },
        data() {
            return {
                cheque: this.cheque_prop,
                actionvalues: this.actionvalues_prop,
                hasexecrole: this.hasexecrole_prop,
                workflowexecForm: new Form({ 'actionvalues': this.actionvalues_prop }),
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
                    'Montant Trans.': this.cheque.TRN_AMOUNT
                }
            }
        }
    }
</script>

<style scoped>

</style>
