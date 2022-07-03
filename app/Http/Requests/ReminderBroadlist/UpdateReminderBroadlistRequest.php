<?php

namespace App\Http\Requests\ReminderBroadlist;

use App\Models\ReminderBroadlist;

class UpdateReminderBroadlistRequest extends ReminderBroadlistRequest
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
        return ReminderBroadlist::updateRules($this->reminderbroadlist);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'object' => $this->objecttype::where('id', $this->objectid)->first(),
            'roles' => $this->setRelevantIdsList($this->input('roles'), true),
            'users' => $this->setRelevantIdsList($this->input('users'), true),
        ]);
    }
}
