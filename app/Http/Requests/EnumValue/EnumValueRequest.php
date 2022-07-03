<?php

namespace App\Http\Requests\EnumValue;

use App\Models\EnumType;
use App\Models\EnumValue;
use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class EnumValueRequest
 * @package App\Http\Requests\EnumValue
 *
 * @property string $val
 * @property mixed $description
 * @property EnumValue $enumvalue
 * @property EnumType $enumtype
 */
class EnumValueRequest extends FormRequest
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
        return EnumValue::defaultRules();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return EnumValue::messagesRules();
    }
}
