<?php

namespace App\Http\Requests\WorkflowStep;

use App\Models\WorkflowStep;
use Spatie\Permission\Models\Role;

class UpdateWorkflowStepRequest extends WorkflowStepRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return WorkflowStep::updateRules($this->workflowstep,$this->can_expire,$this->expire_hours,$this->expire_days);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'staticapprovers' => $this->setRelevantIdsList($this->input('staticapprovers'), true),
            'validatednextstep' => $this->setRelevantStep($this->input('validatednextstep'), true),
            'rejectednextstep' => $this->setRelevantStep($this->input('rejectednextstep'), true),
            'expirednextstep' => $this->setRelevantStep($this->input('expirednextstep'), true),
            'role_static' => $this->setCheckOrOptionValue($this->input('role_static')),
            'role_dynamic' => $this->setCheckOrOptionValue($this->input('role_dynamic')),
            'role_previous' => $this->setCheckOrOptionValue($this->input('role_previous')),
            'can_expire' => $this->setCheckOrOptionValue($this->input('can_expire')),
            'notify_to_approvers' => $this->setCheckOrOptionValue($this->input('notify_to_approvers')),
            'notify_to_others' => $this->setCheckOrOptionValue($this->input('notify_to_others')),
            'expire_hours' => intval($this->input('expire_hours')),
            'expire_days' => intval($this->input('expire_days')),
            'otherstonotify' => $this->setRelevantIdsList($this->input('otherstonotify'), true),
            'stepparent' => $this->setRelevantStep($this->input('stepparent'), true),
        ]);
    }
}
