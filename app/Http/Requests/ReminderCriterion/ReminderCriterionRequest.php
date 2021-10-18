<?php

namespace App\Http\Requests\ReminderCriterion;

use App\Models\Reminder;
use App\Models\ModelAttribute;
use App\Models\ReminderCriterion;
use App\Traits\Request\RequestTraits;
use App\Models\ReminderCriterionType;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ReminderCriterionRequest
 * @package App\Http\Requests\ReminderCriterion
 *
 * @property string $title
 * @property string $criterion_value
 * @property ReminderCriterion $remindercriterion
 * @property Reminder $reminder
 * @property boolean $is_start_criterion
 * @property boolean $is_stop_criterion
 * @property ReminderCriterionType $criteriontype
 * @property string $description
 * @property ModelAttribute $modelattribute
 */
class ReminderCriterionRequest extends FormRequest
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
        return ReminderCriterion::defaultRules();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return ReminderCriterion::messagesRules();
    }
}
