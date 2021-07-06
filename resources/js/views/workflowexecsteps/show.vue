<template>
    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ execstep.exec.workflow.titre }}</h1>
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
                            <h5><i class="fas fa-info"></i> <u>Etape </u>: <strong>{{ execstep.step.titre }}</strong></h5>
                            {{ execstep.step.description }}
                        </div>

                        <!-- Main content -->
                        <div class="invoice p-3 mb-3">

                            <div class="row invoice-info">
                                <div class="col-sm-12 invoice-col">
                                    <form class="form-horizontal" @submit.prevent @keydown="workflowexecstepForm.errors.clear()">

                                        <div class="card-body">
                                            <div class="form-group row" v-for="(action, index) in execstep.step.actions" v-if="execstep.step.actions">
                                                <div class="col-sm-10" v-if="action.type.code == 1">
                                                    <input type="text" class="form-control" id="setvalue" name="setvalue" autocomplete="setvalue" placeholder="Titre" v-model="workflowexecstepForm.setvalue">
                                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowexecstepForm.errors.has('setvalue')" v-text="workflowexecstepForm.errors.get('setvalue')"></span>
                                                </div>
                                                <div class="col-sm-10" v-else>
                                                    <input v-if="action.objectfield.valuetype_string" type="text" class="form-control" :id="action.objectfield.db_field_name" :name="action.objectfield.db_field_name" :placeholder="action.objectfield.field_label" v-model="workflowexecstepForm.actionvalues[action.objectfield.db_field_name]">
                                                    <input v-else-if="action.objectfield.valuetype_integer" type="text" class="form-control" :id="action.objectfield.db_field_name" :name="action.objectfield.db_field_name" :placeholder="action.objectfield.db_field_name" v-model="workflowexecstepForm.valuestring">
                                                    <input v-else-if="action.objectfield.valuetype_boolean" type="text" class="form-control" :id="action.objectfield.db_field_name" :name="action.objectfield.field_label" :placeholder="action.objectfield.db_field_name" v-model="workflowexecstepForm.valuestring">
                                                    <VueCtkDateTimePicker v-else-if="action.objectfield.valuetype_datetime" v-model="workflowexecactionForm.valuedatetime" :label="action.objectfield.db_field_name" />
                                                    <span v-else-if="action.objectfield.valuetype_image">
                                                        <input type="text" class="form-control" :id="action.objectfield.db_field_name" :name="action.objectfield.db_field_name" :placeholder="action.objectfield.field_label" v-model="workflowexecstepForm.valuestring">
                                                        <label class="custom-file-label" :for="action.objectfield.db_field_name">{{ filename }}</label>
                                                    </span>
                                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowexecstepForm.errors.has(`${action.objectfield.db_field_name}`)" v-text="workflowexecstepForm.errors.get(`${action.objectfield.db_field_name}`)"></span>
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
    class Workflowexecstep {
        constructor(workflowexecstep) {
            this.setvalue = workflowexecstep.setvalue || ''
            this.actionvalues = workflowexecstep.actionvalues || ''
            this.motif_rejet = workflowexecstep.motif_rejet || ''
        }
    }
    export default {
        name: "show",
        props: {
            execstep_prop: {}
        },
        data() {
            return {
                execstep: this.execstep_prop,
                execstepId: this.execstep_prop.uuid,
                workflowexecstepForm: new Form(new Workflowexecstep({})),
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

                this.workflowexecstepForm
                    .put(`/workflowexecsteps/${this.execstepId}`, fd)
                    .then(data => {
                        //this.$router.go('/bordereauremises')
                    }).catch(error => {
                    this.loading = false
                });
            },
            rejeterAction() {

            },
            addFileToForm() {
                if (this.execstep.action.objectfield.valuetype_image === 1) {
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
