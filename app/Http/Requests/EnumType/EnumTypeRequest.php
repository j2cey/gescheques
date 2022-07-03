<?php

namespace App\Http\Requests\EnumType;

use App\Models\EnumType;
use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class EnumTypeRequest
 * @package App\Http\Requests\EnumType
 *
 *
 * @property string $name
 * @property string $description
 * @property mixed $enumvalues
 */
class EnumTypeRequest extends FormRequest
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
        return EnumType::defaultRules();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return EnumType::messagesRules();
    }
}
