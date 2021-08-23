<?php

namespace App\Http\Requests\WorkflowStep;

use App\Models\WorkflowStep;

class CreateWorkflowStepRequest extends WorkflowStepRequest
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
        return WorkflowStep::createRules($this->can_expire,$this->expire_hours,$this->expire_days);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'approvers' => $this->setRelevantIdsList($this->input('approvers')),
            'transitionpassstep' => $this->setRelevantStep($this->input('transitionpassstep')),
            'transitionrejectstep' => $this->setRelevantStep($this->input('transitionrejectstep')),
            'transitionexpirestep' => $this->setRelevantStep($this->input('transitionexpirestep')),
            'role_static' => $this->setCheckOrOptionValue($this->input('role_static')),
            'role_dynamic' => $this->setCheckOrOptionValue($this->input('role_dynamic')),
            'role_previous' => $this->setCheckOrOptionValue($this->input('role_previous')),
            'can_expire' => $this->setCheckOrOptionValue($this->input('can_expire')),
            'notify_to_approvers' => $this->setCheckOrOptionValue($this->input('notify_to_approvers')),
            'notify_to_others' => $this->setCheckOrOptionValue($this->input('notify_to_others')),
            'expire_hours' => intval($this->input('expire_hours')),
            'expire_days' => intval($this->input('expire_days')),
            'otherstonotify' => $this->setRelevantIdsList($this->input('otherstonotify')),
            'stepparent' => $this->setRelevantStep($this->input('stepparent')),
        ]);
    }
}
