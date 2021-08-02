<template>
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
</template>

<script>
    export default {
        name: "process-form"
    }
</script>

<style scoped>

</style>
