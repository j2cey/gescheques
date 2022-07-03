<?php

namespace App\Traits\Reminder;

use App\Models\Reminder;
use App\Models\ModelType;
use App\Models\ReminderObject;

/**
 * Trait HasReminder
 * @package App\Traits\Reminder
 *
 * @property integer $id
 */
trait HasReminder
{
    abstract public function getBroadcastlists(): ?array;

    public function getReminders() {
        $model_type = ModelType::where('full_type', get_called_class())->first();
        if (! $model_type) {
            return [];
        }
        return Reminder::where('model_type_id', $model_type->id)->get();
    }

    public function launchReminderObject() {
        $reminders = $this->getReminders();
        foreach ($reminders as $reminder) {
            $is_start_criteria_met = false;
            // Check all start critera
            foreach ($reminder->criteria as $criterion) {
                if ($criterion->is_start_criterion) {
                    $is_start_criteria_met = $criterion->isMet($this);
                }
            }
            // Add new reminder object
            if ($is_start_criteria_met) {
                $reminder_object = ReminderObject::createNew($reminder, "reminder object for " . $this->id, $this->id);
            }
        }
    }

    public function stopReminderObject() {

    }

    public static function bootHasReminder()
    {
        static::saving(function ($model) {
            // create reminder_object if any (start) criterion is met
            $model->launchReminderObject();
        });
    }
}
