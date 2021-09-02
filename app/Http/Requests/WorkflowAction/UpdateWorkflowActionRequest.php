<?php

namespace App\Http\Requests\WorkflowAction;

use App\Models\WorkflowAction;

class UpdateWorkflowActionRequest extends WorkflowActionRequest
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
        return WorkflowAction::updateRules($this->workflowaction);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'actiontype' => $this->setRelevantActionType($this->input('actiontype'), true),
            'treatmenttype' => $this->setRelevantTreatmentType($this->input('treatmenttype'), true),
            'mimetypes' => $this->setRelevantIdsList($this->input('mimetypes'), true),
            'field_required' => $this->setCheckOrOptionValue($this->input('field_required')),
            'field_required_without' => $this->setCheckOrOptionValue($this->input('field_required_without')),
            'actionsrequiredwithout' => $this->setRelevantIdsList($this->input('actionsrequiredwithout'), true),
            'field_required_with' => $this->setCheckOrOptionValue($this->input('field_required_with')),
            'actionsrequiredwith' => $this->setRelevantIdsList($this->input('actionsrequiredwith'), true),
        ]);
    }
}
