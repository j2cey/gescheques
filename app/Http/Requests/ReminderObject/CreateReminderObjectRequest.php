<?php

namespace App\Http\Requests\ReminderObject;

use App\Models\ReminderObject;

class CreateReminderObjectRequest extends ReminderObjectRequest
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
        return ReminderObject::createRules();
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->reminder = $this->setRelevantReminder($this->input('reminder'));
        $this->merge([
            'reminder' => $this->reminder,
            'broadcastlists' => $this->setRelevantReminderObjectBroadlists($this->broadcastlists),
        ]);
    }
}
