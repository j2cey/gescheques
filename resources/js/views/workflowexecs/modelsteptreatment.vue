<template>
    <div class="modal fade draggable" id="treatModelStep" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="user-block">
                        <span class="username text-sm text-purple" v-if="execmodelstep.step">{{ execmodelstep.step.titre }}</span>
                        <span class="description" v-if="moredata">
                            <dl class="row">
                                <span v-for="(value, propertyName) in moredata" class="text-lighter hidden-sm-down">
                                    <dt class="col-lg-6"><small><strong>{{ propertyName }}</strong></small></dt>
                                    <dd class="col-lg-6">{{ value }}</dd>
                                </span>
                            </dl>
                        </span>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" @submit.prevent @keydown="workflowexecForm.errors.clear()">

                        <div class="card-body">
                            <div class="form-group row" v-for="(action, index) in execmodelstep.actions" v-if="execmodelstep.exec.currentstep">
                                <div class="col-sm-10" v-if="action.type.code == 1">
                                    <input type="text" class="form-control" id="setvalue" name="setvalue" autocomplete="setvalue" placeholder="Titre" v-model="workflowexecForm.setvalue">
                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowexecForm.errors.has('setvalue')" v-text="workflowexecForm.errors.get('setvalue')"></span>
                                </div>
                                <div class="col-sm-10" v-else-if="action.objectfield.valuetype_string || action.objectfield.valuetype_integer">
                                    <input type="text" class="form-control" :id="action.objectfield.db_field_name" :name="action.objectfield.db_field_name" :placeholder="action.titre" v-model="workflowexecForm[action.objectfield.db_field_name]">
                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowexecForm.errors.has(`${action.objectfield.db_field_name}`)" v-text="workflowexecForm.errors.get(`${action.objectfield.db_field_name}`)"></span>
                                </div>
                                <div class="col-sm-10" v-else-if="action.objectfield.valuetype_boolean">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" :id="action.objectfield.db_field_name" :name="action.objectfield.db_field_name" :placeholder="action.titre" v-model="workflowexecForm[action.objectfield.db_field_name]">
                                        <label class="form-check-label" :for="action.objectfield.db_field_name">{{ action.titre }}</label>
                                        <span class="invalid-feedback d-block" role="alert" v-if="workflowexecForm.errors.has(`${action.objectfield.db_field_name}`)" v-text="workflowexecForm.errors.get(`${action.objectfield.db_field_name}`)"></span>
                                    </div>
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
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-warning btn-sm" @click="validerEtape(execmodelstep.uuid)" :disabled="!isValidCreateForm">Valider</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'

    export default {
        name: "modelsteptreatment",
        props: {
        },
        components: { Multiselect },
        mounted() {
            this.$parent.$on('traiter_etape', ( step_data ) => {

                console.log('traiter_etape: ', step_data)

                this.actionvalues = step_data.actionvalues
                this.execmodelstep = step_data.execmodelstep
                this.moredata = step_data.moredata
                //this.workflowexecForm = new Form({ 'actionvalues': this.actionvalues })
                this.workflowexecForm = new Form(step_data.actionvalues)

                //$('#treatModelStep').modal()

                // reset modal if it isn't visible
                if (!($('.modal.in').length)) {
                    $('.modal-dialog').css({
                        top: 50,
                        left: 50
                    });
                }
                $('#treatModelStep').modal({
                    backdrop: false,
                    keyboard: false,
                    show: true
                });

                $('.modal-dialog').draggable({
                    handle: ".modal-header",   //  Can only click on the head to drag
                    cursor: 'move',
                    refreshPositions: false,
                    scroll: false,
                    //containment: "parent"
                });
            })
        },
        created() {

        },
        data() {
            return {
                execmodelstep: {},
                actionvalues: {},
                moredata: {},
                workflowexecForm: new Form({ 'actionvalues': this.actionvalues }),
                filename: 'Télécharger un fichier',
                filefieldname: null,
                selectedFile : null,
                loading: false
            }
        },
        methods: {
            valider() {
                this.$emit('create_new_workflow')
            },
            handleFileUpload(event) {
                this.selectedFile = event.target.files[0];
                this.filefieldname = event.target.name;
                this.filename = (typeof this.selectedFile !== 'undefined') ? this.selectedFile.name : 'Télécharger un fichier';
            },
            validerEtape(execId) {
                this.submitForm(execId);
            },
            rejeterEtape() {
                this.$emit('validate_reject')
            },
            submitForm(execId) {
                const fd = this.addFileToForm(this.filefieldname)

                //console.log(this.workflowexecForm)

                //.post(`/workflowexecs`, fd)
                this.workflowexecForm
                    .put(`/workflowexecmodelsteps/${execId}`, fd)
                    .then(data => {
                        //this.updateData(data);
                        console.log("etape_traitee: ",data)
                        this.$parent.$emit('etape_traitee', data)
                        $('#treatModelStep').modal('hide')

                    }).catch(error => {
                    this.loading = false
                });
            },
            addFileToForm(fieldname) {

                if (typeof this.selectedFile !== 'undefined') {
                    const fd = new FormData();
                    fd.append(fieldname, this.selectedFile);
                    //console.log("image added", fd);
                    return fd;
                } else {
                    const fd = undefined;
                    //console.log("image not added", fd);
                    return fd;
                }
            },
            updateData(data) {

                window.noty({
                    message: 'Traitement effectué avec succès',
                    type: 'success'
                })
            },
        },
        computed: {
            isValidCreateForm() {
                return !this.loading
            }
        }
    }
</script>

<style scoped>
    #treatModelStep {
        position: relative;
    }

    .modal-dialog {
        position: fixed;
        width: 100%;
        margin: 0;
        padding: 10px;
    }

    .modal-header{      /* not necessary but imo important for user */
        cursor: move;
    }
</style>
