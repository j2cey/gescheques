<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Broadcastlist\HasBroadcastlists;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ReminderObject
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property integer|null $reminder_id
 *
 * @property string|null $title
 * @property integer $model_id
 *
 * @property string|null $description
 *
 * @property Carbon $notification_start_at
 * @property Carbon $notification_last_time
 * @property Carbon $notification_end_at
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ReminderObject extends BaseModel implements Auditable
{
    use HasFactory, HasBroadcastlists, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    #region Validation Rules

    public static function defaultRules() {
        return [
            'model_type' => 'required',
            'model_id' => 'required',
        ];
    }
    public static function createRules() {
        return array_merge(self::defaultRules(), [

        ]);
    }
    public static function updateRules($model) {
        return array_merge(self::defaultRules(), [

        ]);
    }
    public static function messagesRules() {
        return [
            'model_type.required' => 'The Model Type is required',
            'model_id.required' => 'The Model ID is required',
        ];
    }

    #endregion

    #region Eloquent Relationships

    public function reminder() {
        return $this->belongsTo(Reminder::class, 'reminder_id');
    }

    public function object() {
        return $this->belongsTo($this->reminder->modeltype->full_type, 'model_id');
    }

    public function broadcastlists() {
        return $this->belongsToMany(ReminderBroadlist::class, 'reminder_custom_broadlist', 'reminder_object_id', 'broadlist_id');
    }

    #endregion

    #region Custom Functions - CRUD

    public static function createNew(Reminder $reminder, $title, $model_id, $description = null): ReminderObject {
        $remindercriterion = ReminderObject::create([
            'title' => $title,
            'model_id' => $model_id,
            'description' => $description,
        ]);

        if( ! is_null($reminder) ) $remindercriterion->setReminder($reminder, false);

        $remindercriterion->save();

        return $remindercriterion;
    }

    public function setReminder(Reminder $reminder = null, $save = true) {
        if ( is_null($reminder) ) {
            $this->reminder()->disassociate();
        } else {
            $this->reminder()->associate($reminder);
        }

        if ($save) { $this->save(); }

        return $this;
    }

    #endregion
}
