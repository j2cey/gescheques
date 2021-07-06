<template>
    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ execaction.action.step.titre }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Action Workflow</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="callout callout-info">
                            <h5><i class="fas fa-info"></i> <u>Action</u>: <strong>{{ execaction.action.titre }}</strong></h5>
                            {{ execaction.action.description }}
                        </div>

                        <!-- Main content -->
                        <div class="invoice p-3 mb-3">

                            <div class="row invoice-info">
                                <div class="col-sm-12 invoice-col">
                                    <form class="form-horizontal" @submit.prevent @keydown="workflowexecactionForm.errors.clear()">
                                        <div class="card-body" v-if="execaction.action.type.code == 1">
                                            <div class="form-group row">
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="setvalue" name="setvalue" autocomplete="setvalue" placeholder="Titre" v-model="workflowexecactionForm.setvalue">
                                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowexecactionForm.errors.has('setvalue')" v-text="workflowexecactionForm.errors.get('setvalue')"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body" v-else>
                                            <div class="form-group row" v-if="execaction.action.objectfield.valuetype_string">
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="valuestring" name="valuestring" autocomplete="valuestring" placeholder="Chaine de Caratère" v-model="workflowexecactionForm.valuestring">
                                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowexecactionForm.errors.has('valuestring')" v-text="workflowexecactionForm.errors.get('valuestring')"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row" v-if="execaction.action.objectfield.valuetype_integer">
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="valueinteger" name="valueinteger" autocomplete="valueinteger" placeholder="Nombre" v-model="workflowexecactionForm.valueinteger">
                                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowexecactionForm.errors.has('valueinteger')" v-text="workflowexecactionForm.errors.get('valueinteger')"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row" v-if="execaction.action.objectfield.valuetype_boolean">
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="valueboolean" name="valueboolean" autocomplete="valueboolean" placeholder="Booléen" v-model="workflowexecactionForm.valueboolean">
                                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowexecactionForm.errors.has('valueboolean')" v-text="workflowexecactionForm.errors.get('valueboolean')"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row" v-if="execaction.action.objectfield.valuetype_datetime">
                                                <div class="col-sm-10">
                                                    <VueCtkDateTimePicker v-model="workflowexecactionForm.valuedatetime" label="Selectionnez Date & Heure" />
                                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowexecactionForm.errors.has('valuedatetime')" v-text="workflowexecactionForm.errors.get('valuedatetime')"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row" v-if="execaction.action.objectfield.valuetype_image">
                                                <div class="col-sm-10">
                                                    <input type="file" class="custom-file-input" id="valueimage" name="valueimage"  ref="valueimage" @change="handleFileUpload">
                                                    <label class="custom-file-label" for="valueimage">{{ filename }}</label>
                                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowexecactionForm.errors.has('valueimage')" v-text="workflowexecactionForm.errors.get('valueimage')"></span>
                                                </div>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- this row will not appear when printing -->
                            <div class="row no-print">
                                <div class="col-12">
                                    <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-undo"></i> Annuler</a>
                                    <button type="button" class="btn btn-danger float-right" @click="rejeterAction()"><i class="far fa-credit-card"></i> Rejéter
                                    </button>
                                    <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;" @click="validerAction()">
                                        <i class="fas fa-download"></i> Valider
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- /.invoice -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
</template>

<script>
    class Workflowexecaction {
        constructor(workflowexecaction) {
            this.setvalue = workflowexecaction.setvalue || ''
            this.valuestring = workflowexecaction.valuestring || ''
            this.valueinteger = workflowexecaction.valueinteger || ''
            this.valueboolean = workflowexecaction.valueboolean || ''
            this.valuedatetime = workflowexecaction.valuedatetime || ''
            this.motif_rejet = workflowexecaction.motif_rejet || ''
        }
    }
    export default {
        name: "show",
        props: {
            execaction_prop: {}
        },
        data() {
            return {
                execaction: this.execaction_prop,
                execactionId: this.execaction_prop.uuid,
                workflowexecactionForm: new Form(new Workflowexecaction({})),
                filename: 'Télécharger un fichier',
                selectedFile : null,
            };
        },
        methods: {
            handleFileUpload(event) {
                this.selectedFile = event.target.files[0];
                this.filename = (typeof this.selectedFile !== 'undefined') ? this.selectedFile.name : 'Télécharger un fichier';
            },
            validerAction() {

                const fd = this.addFileToForm()

                this.workflowexecactionForm
                    .put(`/workflowexecactions/${this.execactionId}`, fd)
                    .then(data => {
                        //this.$router.go('/bordereauremises')
                    }).catch(error => {
                    this.loading = false
                });
            },
            rejeterAction() {

            },
            addFileToForm() {
                if (this.execaction.action.objectfield.valuetype_image === 1) {
                    console.log("we have to load image", this.selectedFile);
                    if (typeof this.selectedFile !== 'undefined') {
                        const fd = new FormData();
                        fd.append('valueimage', this.selectedFile);
                        console.log("image added", fd);
                        return fd;
                    } else {
                        const fd = undefined;
                        console.log("image not added", fd);
                        return fd;
                    }
                } else {
                    console.log("no image to load", this.selectedFile);
                    const fd = undefined;
                    return fd;
                }
            },
        }
    }
</script>

<style scoped>

</style>
