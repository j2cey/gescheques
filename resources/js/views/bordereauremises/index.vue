<template>

    <div>

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Bordereaux Remise</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active">Bordereaux Remise</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="card card-default">
                    <div class="card-header">
                        <div class="form-inline float-left">
                            <span class="help-inline pr-1"> Liste des Bordereaux de Remise </span>
                            <button class="btn btn-xs btn-primary" @click="createNewCampaign()">Nouveau</button>
                        </div>

                        <div class="card-tools">

                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div id="bordereauremiselist">

                            <div class="card card-widget" >

                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Date Remise</th>
                                                <th>Numéro Transaction</th>
                                                <th>Localisation</th>
                                                <th>Changement Dernier Tarif</th>
                                                <th>Classe Paiement</th>
                                                <th>Mode Paiement</th>
                                                <th>Montant Total</th>
                                                <!--<th>Scan Bordereau</th>
                                                <th>Depot Agence</th>
                                                <th>Date Effectif</th>
                                                <th>Date Valeur</th>-->
                                                <th>Statut</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(bordereauremise, index) in bordereauremises" v-if="bordereauremises">
                                                <td>{{bordereauremise.id}}</td>
                                                <td>{{bordereauremise.date_remise}}</td>
                                                <td>
                                                    <a :href="'/bordereauremises/' + bordereauremise.uuid">
                                                        {{bordereauremise.numero_transaction}}
                                                    </a>
                                                </td>
                                                <td>{{bordereauremise.localisation}}</td>
                                                <td>{{bordereauremise.changement_dernier_tarif}}</td>
                                                <td>{{bordereauremise.classe_paiement}}</td>
                                                <td>{{bordereauremise.mode_paiement}}</td>
                                                <td>{{bordereauremise.montant_total}}</td>
                                                <!--<td>{{bordereauremise.scan_bordereau}}</td>
                                                <td>{{bordereauremise.date_depot_agence}}</td>
                                                <td>{{bordereauremise.date_effectif}}</td>
                                                <td>{{bordereauremise.date_valeur}}</td>-->
                                                <td>
                                                    <span v-if="bordereauremise.workflowexec && bordereauremise.workflowexec.currentstep" class="badge badge-default"><a :href="'/workflowexecs/' + bordereauremise.workflowexec.uuid">{{bordereauremise.workflowexec.currentstep.titre}}</a></span>
                                                    <span v-else-if="bordereauremise.workflowexec">
                                                        <span v-if="bordereauremise.workflowexec.workflowstatus.code == 5" class="badge badge-danger">
                                                            {{bordereauremise.workflowexec.workflowstatus.name}}
                                                        </span>
                                                        <span v-else-if="bordereauremise.workflowexec.workflowstatus.code == 4" class="badge badge-success">
                                                            {{bordereauremise.workflowexec.workflowstatus.name}}
                                                        </span>
                                                        <span v-else-if="bordereauremise.workflowexec.workflowstatus.code == 3" class="badge badge-warning">
                                                            {{bordereauremise.workflowexec.workflowstatus.name}}
                                                        </span>
                                                        <span v-else class="badge badge-dark">
                                                            {{bordereauremise.workflowexec.workflowstatus.name}}
                                                        </span>
                                                    </span>
                                                    <span v-else class="badge badge-default">Aucune Action</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.col -->
                                </div>

                                <!-- /.card-body -->
                            </div>

                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        .
                    </div>
                </div>
                <!-- /.card -->

                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

</template>

<script>
    export default {
        name: "index",
        mounted() {
        },
        components: {
        },
        data() {
            return {
                bordereauremises: []
            }
        },
        created() {
            axios.get('/bordereauremises.fetch')
                .then(({data}) => this.bordereauremises = data);
        },
        methods: {
        }
    }
</script>

<style scoped>

</style>
