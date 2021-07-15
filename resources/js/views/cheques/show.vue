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
                                                Infos Banque
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
                                                    <dt class="col-sm-4 text-xs">Description</dt>
                                                    <dd class="col-sm-8 text-xs">{{ cheque.DESCRIPTION }}</dd>
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

                    <div>
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-6 order-1 order-md-1">

                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            Agence
                                        </h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="card-body table-responsive p-0" style="height: 90px;">
                                            <dl class="row">
                                                <dt class="col-sm-4 text-xs">Date Traitement</dt>
                                                <dd class="col-sm-8 text-xs">{{ cheque.date_traitement_agence | formatDate }}</dd>
                                                <dt class="col-sm-4 text-xs">Montant Déposé</dt>
                                                <dd class="col-sm-8 text-xs">{{ cheque.montant_depose_agence }}</dd>
                                                <dt class="col-sm-4 text-xs">Commentaire</dt>
                                                <dd class="col-sm-8 text-xs">{{ cheque.commentaire_agence }}</dd>
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
                                            Finances
                                        </h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="card-body table-responsive p-0" style="height: 90px;">
                                            <dl class="row">
                                                <dt class="col-sm-4 text-xs">Date Traitement</dt>
                                                <dd class="col-sm-8 text-xs">{{ cheque.date_traitement_finance | formatDate }}</dd>
                                                <dt class="col-sm-4 text-xs">Commentaire</dt>
                                                <dd class="col-sm-8 text-xs">{{ cheque.commentaire_finance }}</dd>
                                                <dt class="col-sm-4 text-xs">Scan</dt>
                                                <dd class="col-sm-8 text-xs">
                                                    <div class="attachment-block clearfix" v-if="cheque.scan_cheque">
                                                        <a v-if="cheque.scan_cheque" href="#" @click.prevent="showImage(scanUrl)" class="link-black text-sm">
                                                            <img class="attachment-img" :src="scanUrl" alt="Attachment Image">
                                                        </a>
                                                        <!-- /.attachment-pushed -->
                                                    </div>
                                                </dd>
                                            </dl>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <div class="card" v-if="cheque.workflowexec.execsteps.length > 0">
                <div class="card-header">
                    <h3 class="card-title">Traitement(s) Effecué(s):</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">

                    <div class="card-body table-responsive p-0" style="height: 200px;">
                        <table class="table table-head-fixed table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>Titre</th>
                                    <th>Date</th>
                                    <th>Résultat</th>
                                </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(execstep, index) in cheque.workflowexec.execsteps" v-if="cheque.workflowexec.execsteps">
                                <td>
                                    <span class="badge badge-primary text-xs" v-if="execstep.posi == 0">{{ execstep.step.titre }}</span>
                                    <span class="badge badge-info text-xs" v-else-if="execstep.step.posi == 1">{{ execstep.step.titre }}</span>
                                    <span class="badge badge-success text-xs" v-else>{{ execstep.step.titre }}</span>
                                </td>
                                <td>
                                    <span class=" text-xs">
                                        {{ execstep.updated_at | formatDate }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-pill badge-success text-xs" v-if="execstep.execstatus.code == '4'">{{ execstep.execstatus.name }}</span>
                                    <span class="badge badge-pill badge-warning text-xs" v-else-if="execstep.execstatus.code == 3">{{ execstep.execstatus.name }}</span>
                                    <span class="badge badge-pill badge-danger text-xs" v-else>{{ execstep.execstatus.name }}</span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
                <!-- /.card-body -->
            </div>

            <div class="card" v-if="canexecworkflowstep">
                <div class="card-header">
                    <h3 class="card-title">Traitement(s) à Effecuer:</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">

                    <div class="card-body table-responsive p-0" style="height: 200px;">
                        <table class="table table-head-fixed table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>Titre</th>
                                    <th>Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="cheque.workflowexec">
                                    <td>
                                        <span class="badge badge-primary text-xs" v-if="cheque.workflowexec.currentstep.posi == 0">{{ cheque.workflowexec.currentstep.titre }}</span>
                                        <span class="badge badge-info text-xs" v-else-if="cheque.workflowexec.currentstep.posi == 1">{{ cheque.workflowexec.currentstep.titre }}</span>
                                        <span class="badge badge-success text-xs" v-else>{{ cheque.workflowexec.currentstep.titre }}</span>
                                    </td>
                                    <td>
                                        <span class=" text-xs">
                                            {{ cheque.workflowexec.created_at | formatDate }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="#" @click.prevent="traiterEtape(cheque.workflowexec.uuid,cheque.CHEQUE_NB,cheque.ACC_CODE,cheque.TRN_AMOUNT)">
                                            <i class="fa fa-pencil-square-o text-green" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
        <ImgShow></ImgShow>
        <WorkflowExecProcess></WorkflowExecProcess>
    </div>

</template>

<script>
    import ImgShow from '../workflowexecs/imgscan'
    import WorkflowExecProcess from '../workflowexecs/process'
    export default {
        name: "show",
        props: {
            cheque_prop: {},
            actionvalues_prop: {},
            hasexecrole_prop: 0,
            userprofile_prop: {} // TODO: Recevoir tous les profiles de l utilisateur et écrire une fonction pour évaluer le droit
        },
        components: {
            WorkflowExecProcess, ImgShow
        },
        created() {

        },
        mounted() {
            this.$on('etape_traitee', (data) => {
                // Maj des données
                console.log("etape_traitee - recue", data)
                this.updateData(data)
            })
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
                userprofile: this.userprofile_prop
            };
        },
        methods: {
            updateData(data) {
                this.cheque = data;

                window.noty({
                    message: 'Traitement effectué avec succès',
                    type: 'success'
                })
            },
            traiterEtape(id,cheque_nb,acc_code,trn_amount) {
                // cheque.currmodelstep.uuid,cheque.CHEQUE_NB,cheque.ACC_CODE,cheque.TRN_AMOUNT
                let moredata = {
                    'Num. Chèque': cheque_nb,
                    'Code Compte': acc_code,
                    'Montant Trans.': trn_amount
                }

                axios.get(`/workflowexecs/${id}`)
                    .then(({data}) => {
                        console.log('get workflowexecs', data)
                        let actionvalues = data.actionvalues
                        let exec = data.exec
                        let currentstep = data.currentstep

                        this.$emit('traiter_etape', {exec, currentstep, actionvalues, moredata})
                    });
            },
            showImage(scanUrl) {
                this.$emit('show_image', scanUrl)
            },
        },
        computed: {
            canexecworkflowstep() {
                if (this.cheque.workflowexec.currentprofile) {
                    return this.userprofile.id === this.cheque.workflowexec.currentprofile.id
                } else {
                    return false
                }
            },
            scanUrl() {
                if (this.cheque.scan_cheque) {
                    return '/uploads/cheques/scans/' + this.cheque.scan_cheque
                } else {
                    return ""
                }
            }
        }
    }
</script>

<style scoped>

</style>
