<?php

namespace App\Http\Requests\WorkflowAction;

use App\WorkflowAction;
use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkflowActionRequest extends FormRequest
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
}
