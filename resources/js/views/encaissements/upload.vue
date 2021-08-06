<template>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Téléchargement Fichier Encaissements</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Encaissements Upload</li>
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

                    <form class="form-horizontal" @submit.prevent @keydown="encaissementForm.errors.clear()">

                        <div class="form-group input-group file-group">
                            <input type="file" class="custom-file-input" id="fichier_encaissements" ref="fichier_encaissements" @change="handleFichierEncaissementsUpload" multiple>
                            <label class="custom-file-label" for="fichier_encaissements">{{ fichierEncaissementsPlaceholder }}</label>
                            <p class="text-sm-left"><small class="text text-danger" role="alert" v-if="encaissementForm.errors.has('fichier_dossier_candidature')" v-text="encaissementForm.errors.get('fichier_dossier_candidature')"></small></p>
                        </div>

                    </form>

                </div>
                <!-- /.card-body -->
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary btn-sm" @click="closeWindow">Fermer</button>
                    <button type="button" class="btn btn-primary btn-sm" @click="createEncaissements()" :disabled="!isValidCreateForm">Valider</button>
                </div>
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
</template>

<script>
    class Encaissementsfile {
        constructor(encaissementsfile) {
            this.fichier = encaissementsfile.fichier || ''
            this.fichier_encaissements = encaissementsfile.fichier_encaissements || ''
        }
    }

    export default {
        name: "upload",
        props: {
            getfileuploadmaxsize_prop: 0,
        },
        mounted() {
            this.editing = false
            this.encaissementsfile = new Encaissementsfile({})
            this.encaissementForm = new Form(this.encaissementsfile)
        },
        data() {
            return {
                encaissementsfile: {},
                encaissementForm: new Form(new Encaissementsfile({})),
                encaissementsfileId: null,
                editing: false,
                loading: false,
                errors: [],
                selectedEncaissementsFile : null,
                selectedEncaissementsFileName : "Selectionnez le fichier (xls)...",
                fichierEncaissementsPlaceholder : "Selectionnez le Fichier...(" + this.getfileuploadmaxsize_prop + " Mo max)",
            }
        },
        methods: {
            handleFichierEncaissementsUpload(event) {
                this.selectedEncaissementsFile = event.target.files[0];
                this.fichierEncaissementsPlaceholder = (typeof this.selectedEncaissementsFile !== 'undefined') ? this.selectedEncaissementsFile.name : "Selectionnez le Fichier...(" + this.getfileuploadmaxsize_prop + " Mo max)";
                this.encaissementForm.fichier = this.fichierEncaissementsPlaceholder;
            },
            createEncaissements() {
                this.loading = true
                const fd = new FormData();
                fd.append('fichier_encaissements', this.selectedEncaissementsFile);
                this.encaissementForm
                    .post('/encaissements.uploadpost', fd)
                    .then(newdata => {
                        this.loading = false
                        this.resetForm();

                        this.$swal({
                            html: '<small>Fichier téléchargé avec succès !</small>',
                            type: 'success',
                            icon: 'success',
                            timer: 3000
                        }).then(() => {
                            window.location = '/encaissements'
                        })

                    }).catch(error => {
                    this.loading = false
                });
            },
            closeWindow() {
                window.location = '/encaissements'
            },
            resetForm() {
                this.encaissementForm.reset();
                this.$refs.fichier_encaissements.value = '';
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
