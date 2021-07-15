<template>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Téléchargement Fichier Cheques</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Cheques Upload</li>
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
                    <h3 class="card-title">Détails Téléchargement</h3>
                </div>
                <div class="card-body">

                    <form class="form-horizontal" @submit.prevent @keydown="chequeForm.errors.clear()">

                        <div class="form-group input-group file-group">
                            <input type="file" class="custom-file-input" id="fichier_cheques" ref="fichier_cheques" @change="handleFichierChequesUpload" multiple>
                            <label class="custom-file-label" for="fichier_cheques">{{ fichierChequesPlaceholder }}</label>
                            <p class="text-sm-left"><small class="text text-danger" role="alert" v-if="chequeForm.errors.has('fichier_dossier_candidature')" v-text="chequeForm.errors.get('fichier_dossier_candidature')"></small></p>
                        </div>

                    </form>

                </div>
                <!-- /.card-body -->
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-primary btn-sm" @click="createCheques()" :disabled="!isValidCreateForm">Valider</button>
                </div>
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
</template>

<script>
    class Chequesfile {
        constructor(chequesfile) {
            this.fichier = chequesfile.fichier || ''
            this.fichier_cheques = chequesfile.fichier_cheques || ''
        }
    }

    export default {
        name: "upload",
        props: {
            getfileuploadmaxsize_prop: 0,
        },
        mounted() {
            this.editing = false
            this.chequesfile = new Chequesfile({})
            this.chequeForm = new Form(this.chequesfile)
        },
        data() {
            return {
                chequesfile: {},
                chequeForm: new Form(new Chequesfile({})),
                chequesfileId: null,
                editing: false,
                loading: false,
                errors: [],
                selectedChequesFile : null,
                selectedChequesFileName : "Selectionnez le fichier (xls)...",
                fichierChequesPlaceholder : "Selectionnez le Fichier...(" + this.getfileuploadmaxsize_prop + " Mo max)",
            }
        },
        methods: {
            handleFichierChequesUpload(event) {
                this.selectedChequesFile = event.target.files[0];
                this.fichierChequesPlaceholder = (typeof this.selectedChequesFile !== 'undefined') ? this.selectedChequesFile.name : "Selectionnez le Fichier...(" + this.getfileuploadmaxsize_prop + " Mo max)";
                this.chequeForm.fichier = this.fichierChequesPlaceholder;
            },
            createCheques() {
                this.loading = true
                const fd = new FormData();
                fd.append('fichier_cheques', this.selectedChequesFile);
                this.chequeForm
                    .post('/cheques.uploadpost', fd)
                    .then(newdata => {
                        this.loading = false
                        window.noty({
                            message: 'Fichier téléchargé avec succès !',
                            type: 'success'
                        })
                        this.resetForm();
                    }).catch(error => {
                    this.loading = false
                });
            },
            resetForm() {
                this.chequeForm.reset();
                this.$refs.fichier_cheques.value = '';
            }
        },
        computed: {
            isValidCreateForm() {
                return !this.loading
            }
        }
    }
</script>

<style scoped>

</style>
