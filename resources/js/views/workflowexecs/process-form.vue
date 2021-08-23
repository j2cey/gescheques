<template>

    <div class="content">
        <form class="form-horizontal" @submit.prevent @keydown="wfexecForm.errors.clear()">

            <div class="card-body">
                <div class="form-group row" v-for="(action, index) in actions" v-if="actions">
                    <div class="col-sm-10" v-if="action.actiontype.code === 'BIGINT_value' && action.dedicated_form === 'validation'">
                        <input type="text" class="form-control form-control-sm text-xs" :id="action.code" :name="action.code" :placeholder="action.titre" v-model="wfexecForm[action.code]">
                        <span class="invalid-feedback d-block" role="alert" v-if="wfexecForm.errors.has(`${action.code}`)" v-text="wfexecForm.errors.get(`${action.code}`)"></span>
                    </div>
                    <div class="col-sm-10" v-if="action.actiontype.code === 'BLOB_value' && action.dedicated_form === 'validation'">
                        <input type="text" class="form-control form-control-sm" :id="action.code" :name="action.code" :placeholder="action.titre" v-model="wfexecForm[action.code]">
                        <span class="invalid-feedback d-block" role="alert" v-if="wfexecForm.errors.has(`${action.code}`)" v-text="wfexecForm.errors.get(`${action.code}`)"></span>
                    </div>
                    <div class="col-sm-10" v-else-if="action.actiontype.code === 'BOOLEAN_value' && action.dedicated_form === 'validation'">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" :id="action.code" :name="action.code" :placeholder="action.titre" v-model="wfexecForm[action.code]">
                            <label class="form-check-label" :for="action.code">{{ action.titre }}</label>
                            <span class="invalid-feedback d-block" role="alert" v-if="wfexecForm.errors.has(`${action.code}`)" v-text="wfexecForm.errors.get(`${action.code}`)"></span>
                        </div>
                    </div>
                    <div class="col-sm-10" v-if="action.actiontype.code === 'CHAR_value' && action.dedicated_form === 'validation'">
                        <input type="text" class="form-control form-control-sm text-xs" :id="action.code" :name="action.code" :placeholder="action.titre" v-model="wfexecForm[action.code]">
                        <span class="invalid-feedback d-block" role="alert" v-if="wfexecForm.errors.has(`${action.code}`)" v-text="wfexecForm.errors.get(`${action.code}`)"></span>
                    </div>
                    <div class="col-sm-10" v-else-if="action.actiontype.code === 'DATETIME_value' && action.dedicated_form === 'validation'">
                        <VueCtkDateTimePicker v-model="wfexecForm[action.code]" :label="action.titre" format="YYYY-MM-DD hh:mm:ss" />
                        <span class="invalid-feedback d-block" role="alert" v-if="wfexecForm.errors.has(`${action.code}`)" v-text="wfexecForm.errors.get(`${action.code}`)"></span>
                    </div>
                    <div class="col-sm-10" v-else-if="action.code === 'DATE_value' && action.dedicated_form === 'validation'">
                        <VueCtkDateTimePicker v-model="wfexecForm[action.code]" :label="action.titre" format="YYYY-MM-DD" />
                        <span class="invalid-feedback d-block" role="alert" v-if="wfexecForm.errors.has(`${action.code}`)" v-text="wfexecForm.errors.get(`${action.code}`)"></span>
                    </div>
                    <div class="col-sm-10" v-if="action.actiontype.code === 'DECIMAL_value' && action.dedicated_form === 'validation'">
                        <input type="text" class="form-control form-control-sm text-xs" :id="action.code" :name="action.code" :placeholder="action.titre" v-model="wfexecForm[action.code]">
                        <span class="invalid-feedback d-block" role="alert" v-if="wfexecForm.errors.has(`${action.code}`)" v-text="wfexecForm.errors.get(`${action.code}`)"></span>
                    </div>
                    <div class="col-sm-10" v-if="action.actiontype.code === 'DOUBLE_value' && action.dedicated_form === 'validation'">
                        <input type="text" class="form-control form-control-sm text-xs" :id="action.code" :name="action.code" :placeholder="action.titre" v-model="wfexecForm[action.code]">
                        <span class="invalid-feedback d-block" role="alert" v-if="wfexecForm.errors.has(`${action.code}`)" v-text="wfexecForm.errors.get(`${action.code}`)"></span>
                    </div>
                    <div class="col-sm-10" v-if="action.actiontype.code === 'FLOAT_value' && action.dedicated_form === 'validation'">
                        <input type="text" class="form-control form-control-sm text-xs" :id="action.code" :name="action.code" :placeholder="action.titre" v-model="wfexecForm[action.code]">
                        <span class="invalid-feedback d-block" role="alert" v-if="wfexecForm.errors.has(`${action.code}`)" v-text="wfexecForm.errors.get(`${action.code}`)"></span>
                    </div>
                    <div class="col-sm-10" v-if="action.actiontype.code === 'INTEGER_value' && action.dedicated_form === 'validation'">
                        <input type="text" class="form-control form-control-sm text-xs" :id="action.code" :name="action.code" :placeholder="action.titre" v-model="wfexecForm[action.code]">
                        <span class="invalid-feedback d-block" role="alert" v-if="wfexecForm.errors.has(`${action.code}`)" v-text="wfexecForm.errors.get(`${action.code}`)"></span>
                    </div>
                    <div class="col-sm-10" v-if="action.actiontype.code === 'IPADDRESS_value' && action.dedicated_form === 'validation'">
                        <input type="text" class="form-control form-control-sm text-xs" :id="action.code" :name="action.code" :placeholder="action.titre" v-model="wfexecForm[action.code]">
                        <span class="invalid-feedback d-block" role="alert" v-if="wfexecForm.errors.has(`${action.code}`)" v-text="wfexecForm.errors.get(`${action.code}`)"></span>
                    </div>
                    <div class="col-sm-10" v-if="action.actiontype.code === 'STRING_value' && action.dedicated_form === 'validation'">
                        <input type="text" class="form-control form-control-sm text-xs" :id="action.code" :name="action.code" :placeholder="action.titre" v-model="wfexecForm[action.code]">
                        <span class="invalid-feedback d-block" role="alert" v-if="wfexecForm.errors.has(`${action.code}`)" v-text="wfexecForm.errors.get(`${action.code}`)"></span>
                    </div>
                    <div class="col-sm-10" v-if="action.actiontype.code === 'TEXT_value' && action.dedicated_form === 'validation'">
                        <input type="text" class="form-control form-control-sm text-xs" :id="action.code" :name="action.code" :placeholder="action.titre" v-model="wfexecForm[action.code]">
                        <span class="invalid-feedback d-block" role="alert" v-if="wfexecForm.errors.has(`${action.code}`)" v-text="wfexecForm.errors.get(`${action.code}`)"></span>
                    </div>
                    <div class="col-sm-10" v-else-if="action.actiontype.code === 'FILE_ref' && action.dedicated_form === 'validation'">
                        <input type="file" class="custom-file-input" :id="action.code" :name="action.code"  :ref="action.code" @change="handleFileUpload">
                        <label class="custom-file-label" :for="action.code">{{ filename }}</label>
                        <span class="invalid-feedback d-block" role="alert" v-if="wfexecForm.errors.has(`${action.code}`)" v-text="wfexecForm.errors.get(`${action.code}`)"></span>
                    </div>
                    <div class="col-sm-10" v-else-if="action.actiontype.code === 'EnumType'">
                        <multiselect
                            :id="action.code"
                            v-model="wfexecForm[action.code]"
                            selected.sync="wfexecForm[action.code]"
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
                        <input type="radio" class="custom-control-input" id="role_dynamic_selected" name="role_dynamic_selection" v-model="wfexecForm.role_dynamic_selection" @change="roleDynamicSelectionTypeChange($event)" value="role_dynamic_selected">
                        <label for="role_dynamic_selected" class="custom-control-label"><span class="text text-xs">{{ nextstep.role_dynamic_label }}</span></label>
                    </div>
                    <div class="col-sm-6">
                        <multiselect
                            id="m_select_current_step_role"
                            v-model="wfexecForm.current_step_role"
                            selected.sync="wfexecForm.current_step_role"
                            value=""
                            :options="roles"
                            :searchable="true"
                            :multiple="false"
                            label="name"
                            track-by="id"
                            key="id"
                            :placeholder="nextstep.role_dynamic_label"
                        >
                        </multiselect>
                    </div>
                </div>
                <div class="form-group row" v-if="isNextstepRoleDynamic && wfexec.lastexecstep && wfexec.lastexecstep.effectiverole">
                    <div class="custom-control custom-radio col-sm-4">
                        <input type="radio" class="custom-control-input" id="role_dynamic_previous" name="role_dynamic_selection" v-model="wfexecForm.role_dynamic_selection" @change="roleDynamicSelectionTypeChange($event)" value="role_dynamic_previous">
                        <label for="role_dynamic_previous" class="custom-control-label"><span class="text text-xs">{{ nextstep.role_dynamic_previous_label }}</span></label>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" readonly class="form-control form-control-sm text-xs" id="role_dynamic_previous_chosen" name="role_dynamic_previous_chosen" :placeholder="nextstep.role_dynamic_previous_label" v-model="wfexec.lastexecstep.effectiverole.name">
                    </div>
                </div>
            </div>

        </form>

        <div class="justify-content-between text-right">
            <button type="button" class="btn btn-warning btn-sm" @click="processData(wfexec.uuid)" :disabled="!isValidCreateForm">Valider</button>
        </div>
    </div>

</template>

<script>
    import Multiselect from "vue-multiselect";
    import ExecBus from "./ExecBus";

    export default {
        name: "process-form",
        props: {
            treatment_type_prop: {},
        },
        watch: {
            $props: {
                handler() {
                    this.parsePropsData(); // anytime any props would change, I needed to parse my data again
                },
                deep: true, // so it not only watches $props but also it's nested values like e.g. props.myProp
                immediate: true,
            }
        },
        components: { Multiselect },
        mounted() {
            ExecBus.$on('step_process', (processdata) => {
                console.log('step_process: ', processdata)
                this.parseData(processdata.exec,processdata.currentstep,processdata.nextstep,processdata.actions,processdata.actionvalues,processdata.enumvalues)
            })
        },
        created() {
            axios.get('/roles.fetch')
                .then(({data}) => this.roles = data);
        },
        data() {
            return {
                treatment_type: this.treatment_type_prop,
                roles: null,
                wfexec: {},
                currentstep: {},
                nextstep: {},
                actions: [],
                actionvalues: {},
                enumvalues: {},
                wfexecForm: {},
                filename: 'Télécharger un fichier',
                filefieldname: null,
                selectedFile : null,
                loading: false
            }
        },
        methods: {
            parsePropsData() {
                this.treatment_type = this.treatment_type_prop
            },
            parseData(wfexec,currentstep,nextstep,actions,actionvalues,enumvalues) {
                                this.wfexec = wfexec
                this.currentstep = currentstep
                this.nextstep = nextstep[this.treatment_type.code]

                this.actions = actions[this.treatment_type.code]
                //let actionvalues_typed = actionvalues[this.treatment_type]
                this.actionvalues = actionvalues[this.treatment_type.code]

                this.enumvalues = enumvalues
                this.wfexecForm = new Form(actionvalues[this.treatment_type.code])

                this.wfexecForm.treatment_type = this.treatment_type

                this.setDynamicRoleDefault()
            },
            setDynamicRoleDefault() {
                if (this.isNextstepRoleDynamic) {
                    this.wfexecForm.role_dynamic_selection = 'role_dynamic_selected'
                }
            },
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
            rejeterEtape(execId, rejectactions, enumvalues) {
                let rejectactionvalues = this.rejectactionvalues
                this.$emit('validate_reject', {execId, rejectactions, rejectactionvalues, enumvalues})
            },
            processData(execId) {
                if (this.treatment_type.code === "reject") {

                    this.$swal({
                        html: '<small>Voulez-vous vraiment rejéter cette étape ?</small>',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Oui',
                        cancelButtonText: 'Non'
                    }).then((result) => {
                        if(result.value) {
                            this.submitForm(execId);
                        } else {
                            // stay here
                        }
                    })
                } else {
                    this.submitForm(execId);
                }
            },
            submitForm(execId) {
                if (this.wfexecForm.role_dynamic_selection === 'role_dynamic_previous') {
                    this.wfexecForm.current_step_role = this.wfexec.lastexecstep.effectiverole
                }
                const fd = this.addFileToForm(this.filefieldname)

                console.log('submitForm: ', this.wfexecForm)

                this.wfexecForm
                    .put(`/workflowexecs/${execId}`, fd)
                    .then(data => {

                        $('#processExec').modal('hide')

                        this.$swal({
                            html: '<small>Traitement effectué avec succès !</small>',
                            icon: 'success',
                            timer: 3000
                        }).then(() => {
                            ExecBus.$emit('step_processed', data)
                        })

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
                console.log('roleDynamicSelectionTypeChange: ', this.wfexecForm.role_dynamic_selection);
            },
            actionsFilled() {

            }
        },
        computed: {
            isValidCreateForm() {
                return !this.loading && (this.isNextstepRoleDynamic ? ( this.wfexecForm.role_dynamic_selection === 'role_dynamic_selected' ? (this.wfexecForm.current_step_role && true) : true ) : true)
            },
            isNextstepRoleDynamic() {
                if (this.nextstep) {
                    return this.nextstep.role_dynamic
                } else {
                    return false
                }
            }
        }
    }
</script>

<style scoped>

</style>
