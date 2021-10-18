<?php

namespace App\Http\Requests\EnumValue;

use App\Models\EnumValue;

class UpdateEnumValueRequest extends EnumValueRequest
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
        return EnumValue::updateRules($this->enumvalue);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->enumtype = $this->setEnumTypeFromId($this->input('enum_type_id'));
        $this->merge([
            'enumtype' => $this->enumtype,
        ]);
    }
}
