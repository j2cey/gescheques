<?php

namespace App\Http\Requests\Reminder;

use App\Models\Status;
use App\Models\Reminder;
use App\Models\ModelType;
use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ReminderRequest
 * @package App\Http\Requests\Reminder
 *
 * @property string $title
 * @property ModelType $modeltype
 * @property string $description
 * @property Reminder $reminder
 * @property Status $status
 */
class ReminderRequest extends FormRequest
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
        return Reminder::defaultRules();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return Reminder::messagesRules();
    }
}
