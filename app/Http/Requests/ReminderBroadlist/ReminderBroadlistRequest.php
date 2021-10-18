<?php

namespace App\Http\Requests\ReminderBroadlist;

use App\Models\ReminderBroadlist;
use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ReminderBroadlistRequest
 * @package App\Http\Requests\ReminderBroadlist
 *
 * @property string $title
 * @property string $msg
 * @property string|null $description
 * @property integer $notification_interval
 * @property mixed $roles
 * @property mixed $users
 * @property ReminderBroadlist $reminderbroadlist
 * @property string $objecttype
 * @property string $objectid
 * @property mixed $object
 */
class ReminderBroadlistRequest extends FormRequest
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
        return ReminderBroadlist::defaultRules();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return ReminderBroadlist::messagesRules();
    }
}
