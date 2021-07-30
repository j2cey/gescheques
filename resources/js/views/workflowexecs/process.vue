<template>
    <div class="modal fade draggable" id="processExec" tabindex="-1" role="dialog" aria-labelledby="processExecLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="user-block">
                        <span class="username text-sm text-purple" v-if="currentstep">{{ currentstep.titre }}</span>
                        <span class="description" v-if="moredata">
                            <dl class="row">
                                <span v-for="(value, propertyName) in moredata" class="text-lighter hidden-sm-down">
                                    <dt class="col-sm-12 text-xs"><small><strong>{{ propertyName }}</strong></small></dt>
                                    <dd class="col-sm-12 text-xs">{{ value }}</dd>
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
                            <div class="form-group row" v-for="(action, index) in currentstep.actions" v-if="currentstep">
                                <div class="col-sm-10" v-if="action.actiontype.code === 'BIGINT_value' && action.dedicated_form === 'validation'">
                                    <input type="text" class="form-control form-control-sm text-xs" :id="action.code" :name="action.code" :placeholder="action.titre" v-model="workflowexecForm[action.code]">
                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowexecForm.errors.has(`${action.code}`)" v-text="workflowexecForm.errors.get(`${action.code}`)"></span>
                                </div>
                                <div class="col-sm-10" v-if="action.actiontype.code === 'BLOB_value' && action.dedicated_form === 'validation'">
                                    <input type="text" class="form-control form-control-sm" :id="action.code" :name="action.code" :placeholder="action.titre" v-model="workflowexecForm[action.code]">
                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowexecForm.errors.has(`${action.code}`)" v-text="workflowexecForm.errors.get(`${action.code}`)"></span>
                                </div>
                                <div class="col-sm-10" v-else-if="action.actiontype.code === 'BOOLEAN_value' && action.dedicated_form === 'validation'">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" :id="action.code" :name="action.code" :placeholder="action.titre" v-model="workflowexecForm[action.code]">
                                        <label class="form-check-label" :for="action.code">{{ action.titre }}</label>
                                        <span class="invalid-feedback d-block" role="alert" v-if="workflowexecForm.errors.has(`${action.code}`)" v-text="workflowexecForm.errors.get(`${action.code}`)"></span>
                                    </div>
                                </div>
                                <div class="col-sm-10" v-if="action.actiontype.code === 'CHAR_value' && action.dedicated_form === 'validation'">
                                    <input type="text" class="form-control form-control-sm text-xs" :id="action.code" :name="action.code" :placeholder="action.titre" v-model="workflowexecForm[action.code]">
                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowexecForm.errors.has(`${action.code}`)" v-text="workflowexecForm.errors.get(`${action.code}`)"></span>
                                </div>
                                <div class="col-sm-10" v-else-if="action.actiontype.code === 'DATETIME_value' && action.dedicated_form === 'validation'">
                                    <VueCtkDateTimePicker v-model="workflowexecForm[action.code]" :label="action.titre" format="YYYY-MM-DD hh:mm:ss" />
                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowexecForm.errors.has(`${action.code}`)" v-text="workflowexecForm.errors.get(`${action.code}`)"></span>
                                </div>
                                <div class="col-sm-10" v-else-if="action.code === 'DATE_value' && action.dedicated_form === 'validation'">
                                    <VueCtkDateTimePicker v-model="workflowexecForm[action.code]" :label="action.titre" format="YYYY-MM-DD" />
                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowexecForm.errors.has(`${action.code}`)" v-text="workflowexecForm.errors.get(`${action.code}`)"></span>
                                </div>
                                <div class="col-sm-10" v-if="action.actiontype.code === 'DECIMAL_value' && action.dedicated_form === 'validation'">
                                    <input type="text" class="form-control form-control-sm text-xs" :id="action.code" :name="action.code" :placeholder="action.titre" v-model="workflowexecForm[action.code]">
                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowexecForm.errors.has(`${action.code}`)" v-text="workflowexecForm.errors.get(`${action.code}`)"></span>
                                </div>
                                <div class="col-sm-10" v-if="action.actiontype.code === 'DOUBLE_value' && action.dedicated_form === 'validation'">
                                    <input type="text" class="form-control form-control-sm text-xs" :id="action.code" :name="action.code" :placeholder="action.titre" v-model="workflowexecForm[action.code]">
                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowexecForm.errors.has(`${action.code}`)" v-text="workflowexecForm.errors.get(`${action.code}`)"></span>
                                </div>
                                <div class="col-sm-10" v-if="action.actiontype.code === 'FLOAT_value' && action.dedicated_form === 'validation'">
                                    <input type="text" class="form-control form-control-sm text-xs" :id="action.code" :name="action.code" :placeholder="action.titre" v-model="workflowexecForm[action.code]">
                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowexecForm.errors.has(`${action.code}`)" v-text="workflowexecForm.errors.get(`${action.code}`)"></span>
                                </div>
                                <div class="col-sm-10" v-if="action.actiontype.code === 'INTEGER_value' && action.dedicated_form === 'validation'">
                                    <input type="text" class="form-control form-control-sm text-xs" :id="action.code" :name="action.code" :placeholder="action.titre" v-model="workflowexecForm[action.code]">
                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowexecForm.errors.has(`${action.code}`)" v-text="workflowexecForm.errors.get(`${action.code}`)"></span>
                                </div>
                                <div class="col-sm-10" v-if="action.actiontype.code === 'IPADDRESS_value' && action.dedicated_form === 'validation'">
                                    <input type="text" class="form-control form-control-sm text-xs" :id="action.code" :name="action.code" :placeholder="action.titre" v-model="workflowexecForm[action.code]">
                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowexecForm.errors.has(`${action.code}`)" v-text="workflowexecForm.errors.get(`${action.code}`)"></span>
                                </div>
                                <div class="col-sm-10" v-if="action.actiontype.code === 'STRING_value' && action.dedicated_form === 'validation'">
                                    <input type="text" class="form-control form-control-sm text-xs" :id="action.code" :name="action.code" :placeholder="action.titre" v-model="workflowexecForm[action.code]">
                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowexecForm.errors.has(`${action.code}`)" v-text="workflowexecForm.errors.get(`${action.code}`)"></span>
                                </div>
                                <div class="col-sm-10" v-if="action.actiontype.code === 'TEXT_value' && action.dedicated_form === 'validation'">
                                    <input type="text" class="form-control form-control-sm text-xs" :id="action.code" :name="action.code" :placeholder="action.titre" v-model="workflowexecForm[action.code]">
                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowexecForm.errors.has(`${action.code}`)" v-text="workflowexecForm.errors.get(`${action.code}`)"></span>
                                </div>
                                <div class="col-sm-10" v-else-if="action.actiontype.code === 'FILE_ref' && action.dedicated_form === 'validation'">
                                    <input type="file" class="custom-file-input" :id="action.code" :name="action.code"  :ref="action.code" @change="handleFileUpload">
                                    <label class="custom-file-label" :for="action.code">{{ filename }}</label>
                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowexecForm.errors.has(`${action.code}`)" v-text="workflowexecForm.errors.get(`${action.code}`)"></span>
                                </div>
                                <div class="col-sm-10" v-else-if="action.actiontype.code === 'EnumType' && action.dedicated_form === 'validation'">
                                    <multiselect
                                        :id="action.code"
                                        v-model="workflowexecForm[action.code]"
                                        selected.sync="workflowexecForm[action.code]"
                                        value=""
                                        :options="enumvalues[action.code]"
                                        :searchable="true"
                                        :multiple="false"
                                        label="val"
                                        track-by="val"
                                        key="val"
                                        :placeholder="action.titre"
                                    >
                                    </multiselect>
                                </div>
                                <div class="col-sm-10" v-else>
                                </div>
                            </div>

                            <div class="form-group row" v-if="isNextstepRoleDynamic">
                                <div class="custom-control custom-radio col-sm-4">
                                    <input type="radio" class="custom-control-input" id="role_dynamic_selected" name="role_dynamic_selection" v-model="workflowexecForm.role_dynamic_selection" @change="roleDynamicSelectionTypeChange($event)" value="role_dynamic_selected">
                                    <label for="role_dynamic_selected" class="custom-control-label"><span class="text text-xs">{{ exec.nextstep.role_dynamic_label }}</span></label>
                                </div>
                                <div class="col-sm-6">
                                    <multiselect
                                        id="m_select_current_step_role"
                                        v-model="workflowexecForm.current_step_role"
                                        selected.sync="workflowexecForm.current_step_role"
                                        value=""
                                        :options="roles"
                                        :searchable="true"
                                        :multiple="false"
                                        label="name"
                                        track-by="id"
                                        key="id"
                                        :placeholder="exec.nextstep.role_dynamic_label"
                                    >
                                    </multiselect>
                                </div>
                            </div>
                            <div class="form-group row" v-if="isNextstepRoleDynamic && exec.lastexecstep && exec.lastexecstep.effectiverole">
                                <div class="custom-control custom-radio col-sm-4">
                                    <input type="radio" class="custom-control-input" id="role_dynamic_previous" name="role_dynamic_selection" v-model="workflowexecForm.role_dynamic_selection" @change="roleDynamicSelectionTypeChange($event)" value="role_dynamic_previous">
                                    <label for="role_dynamic_previous" class="custom-control-label"><span class="text text-xs">{{ exec.nextstep.role_dynamic_previous_label }}</span></label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" readonly class="form-control form-control-sm text-xs" id="role_dynamic_previous_chosen" name="role_dynamic_previous_chosen" :placeholder="exec.nextstep.role_dynamic_previous_label" v-model="exec.lastexecstep.effectiverole.name">
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-danger btn-sm" @click="rejeterEtape(exec.uuid,currentstep.rejectaction,enumvalues)">Rejéter</button>
                    <button type="button" class="btn btn-warning btn-sm" @click="validerEtape(exec.uuid)" :disabled="!isValidCreateForm">Valider</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
        <ValidateReject></ValidateReject>
    </div>
</template>

<script>
    import ValidateReject from './reject'
    import Multiselect from 'vue-multiselect'

    export default {
        name: "process",
        props: {
        },
        components: { Multiselect, ValidateReject },
        mounted() {
            this.$parent.$on('traiter_etape', ( process_data ) => {

                console.log('traiter_etape: ', process_data)

                this.actionvalues = process_data.actionvalues
                this.enumvalues = process_data.enumvalues
                this.exec = process_data.exec
                this.currentstep = process_data.currentstep
                this.moredata = process_data.moredata

                this.workflowexecForm = new Form(process_data.actionvalues)

                //$('#processExec').modal()

                // reset modal if it isn't visible
                if (!($('.modal.in').length)) {
                    $('.modal-dialog').css({
                        top: 50,
                        left: 50
                    });
                }
                $('#processExec').modal({
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

            this.$on('reject_validated', (data) => {

                this.workflowexecForm.rejected = true
                this.workflowexecForm.reject_comment = data.motif

                this.submitForm(data.execId);
            })
        },
        created() {
            axios.get('/roles.fetch')
                .then(({data}) => this.roles = data);
        },
        data() {
            return {
                roles: [],
                exec: {},
                currentstep: {},
                actionvalues: {},
                enumvalues: {},
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
            rejeterEtape(execId, rejectaction, enumvalues) {
                this.$emit('validate_reject', {execId, rejectaction, enumvalues})
            },
            submitForm(execId) {
                if (this.workflowexecForm.role_dynamic_selection === 'role_dynamic_previous') {
                    this.workflowexecForm.current_step_role = this.exec.lastexecstep.effectiverole
                }
                const fd = this.addFileToForm(this.filefieldname)

                this.workflowexecForm
                    .put(`/workflowexecs/${execId}`, fd)
                    .then(data => {

                        console.log("etape_traitee: ",data)
                        this.$parent.$emit('etape_traitee', data)
                        $('#processExec').modal('hide')

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
            roleDynamicSelectionTypeChange(event) {
                console.log('roleDynamicSelectionTypeChange: ', this.workflowexecForm.role_dynamic_selection);
            },
        },
        computed: {
            isValidCreateForm() {
                return !this.loading && (this.isNextstepRoleDynamic ? ( this.workflowexecForm.role_dynamic_selection === 'role_dynamic_selected' ? (this.workflowexecForm.current_step_role && true) : true ) : true)
            },
            isNextstepRoleDynamic() {
                if (this.exec.nextstep) {
                    return this.exec.nextstep.role_dynamic
                } else {
                    return false
                }
            }
        }
    }
</script>

<style scoped>
    #processExec {
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
