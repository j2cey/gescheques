<?php

namespace App\Http\Requests\WorkflowExec;

use App\Models\WorkflowExec;
use Spatie\Permission\Models\Role;
use App\Models\WorkflowTreatmentType;

/**
 * Class UpdateWorkflowExecRequest
 * @package App\Http\Requests\WorkflowExec
 *
 * @property WorkflowExec workflowexec
 */
class UpdateWorkflowExecRequest extends WorkflowExecRequest
{
    private WorkflowTreatmentType $treatment_type;
    private ?Role $current_step_role;
    public array $validation_rules = [];
    public array $validation_messages = [];

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
        return $this->validation_rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return $this->validation_messages;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->setTreatmentType();
        $this->setCurrentSteRole();
        $this->setValidationRulesAndMessages();

        $this->merge([
            'treatment_type' => $this->treatment_type,
            'current_step_role' => $this->current_step_role,
        ]);
    }

    private function setCurrentSteRole() {
        $this->current_step_role = $this->setRelevantRole($this->input('current_step_role'), true);
    }

    private function setTreatmentType() {
        $this->treatment_type = $this->setRelevantTreatmentType($this->input('treatment_type'), true);
    }

    private function setValidationRulesAndMessages() {
        $exec = WorkflowExec::with(['workflow','currentstep','currentstep.actions','currentstep.actions.actiontype'])->where('id', $this->workflowexec->id)->first();
        foreach ($exec->currentstep->actions as $action) {
            if ($action->treatmenttype->id === $this->treatment_type->id) {
                $action->setValidationRules();
                $this->validation_rules = array_merge($this->validation_rules, $action->validation_rules);
                $this->validation_messages = array_merge($this->validation_messages, $action->validation_messages);
            }
        }
    }
}
