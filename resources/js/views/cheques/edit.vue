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
                                <div class="col-12 col-sm-12">

                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                Infos Banque
                                            </h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12 col-sm-6">
                                                    <dl class="row">
                                                        <dt class="col-sm-4">Numéro Enregistrement</dt>
                                                        <dd class="col-sm-8">{{ cheque.NREC_BANK_MVT_ID }}</dd>
                                                        <dt class="col-sm-4">Code Compte</dt>
                                                        <dd class="col-sm-8">{{ cheque.ACC_CODE }}</dd>
                                                        <dt class="col-sm-4">Montant Transaction</dt>
                                                        <dd class="col-sm-8">{{ cheque.TRN_AMOUNT }}</dd>
                                                    </dl>
                                                </div>
                                                <div class="col-12 col-sm-6">
                                                    <dl class="row">
                                                        <dt class="col-sm-4">Numero Chèque</dt>
                                                        <dd class="col-sm-8">{{ cheque.CHEQUE_NB }}</dd>
                                                        <dt class="col-sm-4">Date Enregistrement</dt>
                                                        <dd class="col-sm-8">{{ cheque.BOOK_DATE | formatDate }}</dd>
                                                        <dt class="col-sm-4">Date Valeur</dt>
                                                        <dd class="col-sm-8">{{ cheque.VALUE_DATE | formatDate }}</dd>
                                                        <dt class="col-sm-4">Description</dt>
                                                        <dd class="col-sm-8">{{ cheque.DESCRIPTION }}</dd>
                                                    </dl>
                                                </div>
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
                                        <dl class="row">
                                            <dt class="col-sm-4">Date Dépôt</dt>
                                            <dd class="col-sm-8">{{ cheque.date_depot_agence | formatDate }}</dd>
                                            <dt class="col-sm-4">Montant Déposé</dt>
                                            <dd class="col-sm-8">{{ cheque.montant_depose_agence }}</dd>
                                            <dt class="col-sm-4">Commentaire</dt>
                                            <dd class="col-sm-8">{{ cheque.commentaire_agence }}</dd>
                                        </dl>
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
                                        <div class="card-body table-responsive p-0" style="height: 200px;">

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

            <div class="card" v-if="nbactionstoexec">
                <div class="card-header">
                    <h3 class="card-title">Traitement(s) à Effecuer:
                        <span v-if="nbactionstoexec < 3" class="badge badge-pill badge-success">{{ nbactionstoexec }}</span>
                        <span v-else-if="nbactionstoexec < 6" class="badge badge-pill badge-primary">{{ nbactionstoexec }}</span>
                        <span v-else-if="nbactionstoexec < 11" class="badge badge-pill badge-warning">{{ nbactionstoexec }}</span>
                        <span v-else class="badge badge-pill badge-danger">{{ nbactionstoexec }}</span>
                    </h3>

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
                                <th>Statut</th>
                                <th>Date Dépot</th>
                                <th>Référence</th>
                                <th>Montant</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-if="cheque.currmodelstep && cheque.currmodelstep.workflow_step_id === cheque.currmodelstep.exec.current_step_id">
                                <td>
                                    <span class="badge badge-pill badge-primary" v-if="cheque.currmodelstep.step.posi == 0">{{ cheque.currmodelstep.step.titre }}</span>
                                    <span class="badge badge-pill badge-info" v-else-if="cheque.currmodelstep.step.posi == 1">{{ cheque.currmodelstep.step.titre }}</span>
                                    <span class="badge badge-pill badge-success" v-else>{{ cheque.currmodelstep.step.titre }}</span>
                                </td>
                                <td>{{ cheque.created_at | formatDate }}</td>
                                <td>{{ cheque.ACC_CODE + ' | ' + cheque.NREC_BANK_MVT_ID }}</td>
                                <td>{{ cheque.TRN_AMOUNT }}</td>
                                <td>
                                    <a href="#" @click.prevent="traiterEtape(cheque.currmodelstep.uuid,cheque.CHEQUE_NB,cheque.ACC_CODE,cheque.TRN_AMOUNT)">
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
        <StepTreatment></StepTreatment>
    </div>

</template>

<script>
    import StepTreatment from '../workflowexecs/modelsteptreatment'
    export default {
        name: "edit",
        props: {
            cheque_prop: {},
            actionvalues_prop: {},
            hasexecrole_prop: 0,
            userprofile_prop: {} // TODO: Recevoir tous les profiles de l utilisateur et écrire une fonction pour évaluer le droit
        },
        components: {
            StepTreatment
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
                //console.log(data);
                // MAJ du model
                this.cheque = data;
                // MAJ de l'exec
                //this.cheque = data.exec;
                let actionstoexec = this.actionsToExec();
                console.log('updateData - actionstoexec: ', actionstoexec)
                if (actionstoexec > 0) {
                    this.hasexecrole = true;
                } else {
                    this.hasexecrole = false;
                }
                //console.log(this.cheque, this.hasexecrole);
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

                axios.get(`/workflowexecmodelsteps/${id}`)
                    .then(({data}) => {
                        console.log('get workflowexecmodelsteps', data)
                        let actionvalues = data.actionvalues
                        let execmodelstep = data.data

                        this.$emit('traiter_etape', {execmodelstep, actionvalues, moredata})
                    });
            },
            canExecStep(stepid) {

                axios.get(`/canexecstep/${stepid}`)

                    .then(resp => {
                        console.log('get canexecstep: ', resp.data)
                        if (resp) {
                            return resp.data.hasroles === 1;
                        } else {
                            return false;
                        }
                    })
                    .catch(err => {
                        console.log('get canexecstep error: ', err);
                        return false;
                    })

            },
            actionsToExec() {
                let curr_step_actions_count = 0

                // post actionstoexec
                let actionstoexecForm = new Form(
                    { 'objects': [ this.cheque ]}
                )
                actionstoexecForm
                    .post('/actionstoexec')
                    .then(resp => {
                        curr_step_actions_count = resp.actionstoexec
                        console.log('post actionstoexec: ', curr_step_actions_count)
                        return curr_step_actions_count;
                    }).catch(error => {
                    console.log('post actionstoexec error: ', error);
                    return 0;
                });
            },
        },
        computed: {
            nbactionstoexec() {
                let curr_step_actions_count = 0

                // get canexecstep
                let newhasexecrole = true;

                if (this.cheque.currmodelstep) {
                    if (this.cheque.currmodelstep.workflow_step_id === this.cheque.currmodelstep.exec.current_step_id) {
                        if (this.cheque.currmodelstep.exec.currentstep.profile.id === this.userprofile.id) {
                            curr_step_actions_count = 1;
                        }
                    }
                }
                if (this.cheque.lignes) {
                    for (let i in this.cheque.lignes) {
                        let ligne = this.cheque.lignes[i]
                        if (ligne.currmodelstep && ligne.currmodelstep.workflow_step_id === ligne.currmodelstep.exec.current_step_id) {
                            if (ligne.currmodelstep.exec.current_step_role_id === this.userprofile.id) {
                                curr_step_actions_count = curr_step_actions_count + 1;
                            }
                        }
                    }
                }
                return curr_step_actions_count;
            }
        }
    }
</script>

<style scoped>

</style>
