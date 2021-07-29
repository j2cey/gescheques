<?php

namespace App\Http\Requests\WorkflowAction;

use App\Models\WorkflowAction;
use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;

class WorkflowActionRequest extends FormRequest
{
    use RequestTraits;

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
        return WorkflowAction::defaultRules();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return WorkflowAction::messagesRules();
    }
}
