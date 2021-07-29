<?php

namespace App\Http\Requests\WorkflowStep;

use App\Models\WorkflowStep;
use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;

class WorkflowStepRequest extends FormRequest
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
        return WorkflowStep::defaultRules($this->can_expire,$this->expire_hours,$this->expire_days);
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return WorkflowStep::messagesRules();
    }
}
