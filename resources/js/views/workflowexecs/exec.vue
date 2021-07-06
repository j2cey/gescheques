<template>
    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ exec.workflow.titre }}</h1>
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
                            <h5> <u>Etape </u>: <strong>{{ exec.currentstep.titre }}</strong></h5>
                            {{ exec.currentstep.description }}
                            <p v-if="exec.motif_rejet">
                                <i class="fas fa-info text-red"></i> Bordereau retourné avec le <u>Motif</u>:
                                <span class="text-red">{{exec.motif_rejet}}</span>
                            </p>
                        </div>

                        <!-- Main content -->
                        <div class="invoice p-3 mb-3">

                            <div class="row invoice-info">
                                <div class="col-sm-12 invoice-col">
                                    <form class="form-horizontal" @submit.prevent @keydown="workflowexecForm.errors.clear()">

                                        <div class="card-body">
                                            <div class="form-group row" v-for="(action, index) in exec.currentstep.actions" v-if="exec.currentstep.actions">
                                                <div class="col-sm-10" v-if="action.type.code == 1">
                                                    <input type="text" class="form-control" id="setvalue" name="setvalue" autocomplete="setvalue" placeholder="Titre" v-model="workflowexecForm.setvalue">
                                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowexecForm.errors.has('setvalue')" v-text="workflowexecForm.errors.get('setvalue')"></span>
                                                </div>
                                                <div class="col-sm-10" v-else-if="action.objectfield.valuetype_string || action.objectfield.valuetype_integer">
                                                    <input type="text" class="form-control" :id="action.objectfield.db_field_name" :name="action.objectfield.db_field_name" :placeholder="action.titre" v-model="workflowexecForm[action.objectfield.db_field_name]">
                                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowexecForm.errors.has(`${action.objectfield.db_field_name}`)" v-text="workflowexecForm.errors.get(`${action.objectfield.db_field_name}`)"></span>
                                                </div>
                                                <div class="col-sm-10" v-else-if="action.objectfield.valuetype_boolean">
                                                    <input type="text" class="form-control" :id="action.objectfield.db_field_name" :name="action.objectfield.db_field_name" :placeholder="action.titre" v-model="workflowexecForm[action.objectfield.db_field_name]">
                                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowexecForm.errors.has(`${action.objectfield.db_field_name}`)" v-text="workflowexecForm.errors.get(`${action.objectfield.db_field_name}`)"></span>
                                                </div>
                                                <div class="col-sm-10" v-else-if="action.objectfield.valuetype_datetime">
                                                    <VueCtkDateTimePicker v-model="workflowexecForm[action.objectfield.db_field_name]" :label="action.titre" format="YYYY-MM-DD hh:mm:ss" />
                                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowexecForm.errors.has(`${action.objectfield.db_field_name}`)" v-text="workflowexecForm.errors.get(`${action.objectfield.db_field_name}`)"></span>
                                                </div>
                                                <div class="col-sm-10" v-else-if="action.objectfield.valuetype_image">
                                                    <input type="file" class="custom-file-input" :id="action.objectfield.db_field_name" :name="action.objectfield.db_field_name"  :ref="action.objectfield.db_field_name" @change="handleFileUpload">
                                                    <label class="custom-file-label" :for="action.objectfield.db_field_name">{{ filename }}</label>
                                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowexecForm.errors.has(`${action.objectfield.db_field_name}`)" v-text="workflowexecForm.errors.get(`${action.objectfield.db_field_name}`)"></span>
                                                </div>
                                                <div class="col-sm-10" v-else>

                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>

                            <!-- this row will not appear when printing -->
                            <div class="row no-print">
                                <div class="col-12">
                                    <a href="/bordereauremises" class="btn btn-default"><i class="fa fa-undo"></i> Annuler</a>
                                    <button type="button" class="btn btn-danger float-right" @click="rejeterEtape()"><i class="far fa-credit-card"></i> Rejéter
                                    </button>
                                    <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;" @click="validerEtape()">
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
        <ValidateReject></ValidateReject>
    </div>
</template>

<script>
    import ValidateReject from './reject'
    class Workflowexec {
        constructor(workflowexec, actionvalues) {
            this.setvalue = workflowexec.setvalue || ''
            this.actionvalues = actionvalues
            this.motif_rejet = workflowexec.motif_rejet || ''
        }
    }
    export default {
        name: "exec",
        props: {
            exec_prop: {},
            actionvalues_prop: {}
        },
        components: { ValidateReject },
        mounted() {
            this.$on('reject_validated', (motif) => {
                this.workflowexecForm.motif_rejet = motif
                console.log('reject_validated', this.workflowexecForm);
                this.submitForm();
            })
        },
        data() {
            return {
                exec: this.exec_prop,
                execId: this.exec_prop.uuid,
                workflowexecForm: new Form(this.actionvalues_prop),
                filename: 'Télécharger un fichier',
                selectedFile : null,
            };
        },
        methods: {
            initActionvaluesArray() {
                let actionvalues = []
                for (var i = 0; i < this.exec_prop.currentstep.actions; i++) {

                }
            },
            handleFileUpload(event) {
                this.selectedFile = event.target.files[0];
                this.filename = (typeof this.selectedFile !== 'undefined') ? this.selectedFile.name : 'Télécharger un fichier';
            },
            validerEtape() {
                this.submitForm();
            },
            rejeterEtape() {
                this.$emit('validate_reject')
            },
            submitForm() {
                const fd = this.addFileToForm()

                console.log(this.workflowexecForm)

                //.post(`/workflowexecs`, fd)
                this.workflowexecForm
                    .put(`/workflowexecs/${this.execId}`, fd)
                    .then(data => {
                        window.location = "/bordereauremises";
                    }).catch(error => {
                    this.loading = false
                });
            },
            addFileToForm() {

                if (typeof this.selectedFile !== 'undefined') {
                    const fd = new FormData();
                    fd.append('step_files', this.selectedFile);
                    console.log("image added", fd);
                    return fd;
                } else {
                    const fd = undefined;
                    console.log("image not added", fd);
                    return fd;
                }
            },
        }
    }
</script>

<style scoped>

</style>
