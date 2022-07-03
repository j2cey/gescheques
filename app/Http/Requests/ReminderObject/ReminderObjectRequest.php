<?php

namespace App\Http\Requests\ReminderObject;

use App\Models\Reminder;
use App\Models\ReminderObject;
use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ReminderObjectRequest
 * @package App\Http\Requests\ReminderObject
 *
 * @property string $title
 * @property integer $model_id
 *
 * @property integer|null $reminder_id
 * @property string|null $description
 *
 * @property Reminder $reminder
 * @property ReminderObject $reminderobject
 * @property mixed $broadcastlists
 */
class ReminderObjectRequest extends FormRequest
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
        return ReminderObject::defaultRules();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return ReminderObject::messagesRules();
    }
}
