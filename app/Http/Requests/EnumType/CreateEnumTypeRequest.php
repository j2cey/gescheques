<?php

namespace App\Http\Requests\EnumType;

use App\Models\EnumType;

class CreateEnumTypeRequest extends EnumTypeRequest
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
        return EnumType::createRules();
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            //'enumvalues' => $this->decodeJsonField($this->input('enumvalues')),
        ]);
    }
}
