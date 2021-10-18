<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Broadcastlist\HasBroadcastlists;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Reminder
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $title
 * @property integer|null $model_type_id
 * @property string|null $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Reminder extends BaseModel implements Auditable
{
    use HasFactory, HasBroadcastlists, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    #region Validation Rules

    public static function defaultRules() {
        return [
            'title' => 'required',
            'modeltype' => 'required',
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
            'title.required' => 'The title is required',
            'modeltype.required' => 'The Model Type is required',
        ];
    }

    #endregion

    #region Eloquent Relationships

    public function modeltype() {
        return $this->belongsTo(ModelType::class, 'model_type_id');
    }

    public function criteria() {
        return $this->hasMany(ReminderCriterion::class, 'reminder_id');
    }

    public function broadcastlists() {
        return $this->belongsToMany(ReminderBroadlist::class, 'reminder_default_broadlist', 'reminder_id', 'broadlist_id');
    }

    #endregion

    #region Custom Functions - CRUD

    public static function createNew(ModelType $modeltype, $title, $description = null): Reminder {
        $reminder = Reminder::create([
            'title' => $title,
            'description' => $description,
        ]);

        if( ! is_null($modeltype) ) $reminder->setModelType($modeltype, false);

        $reminder->save();

        return $reminder;
    }

    public function setModelType(ModelType $modeltype = null, $save = true) : Reminder {
        if ( is_null($modeltype) ) {
            $this->modeltype()->disassociate();
        } else {
            $this->modeltype()->associate($modeltype);
        }

        if ($save) { $this->save(); }

        return $this;
    }

    public function addCriterion(ReminderCriterionType $criteriontype, $title, ModelAttribute $modelattribute, $criterion_value, $is_start_criterion = true, $is_stop_criterion = false, $description = null, $criterion_role = null) : Reminder {
        ReminderCriterion::createNew($criteriontype, $this, $title, $modelattribute, $criterion_value, $is_start_criterion, $is_stop_criterion, $description, $criterion_role);

        return $this;
    }

    public function addCriterionStart(ReminderCriterionType $criteriontype, $title, ModelAttribute $modelattribute, $criterion_value, $description = null, $criterion_role = null) : Reminder {
        ReminderCriterion::createNew($criteriontype, $this, $title, $modelattribute, $criterion_value, true, false, $description, $criterion_role);

        return $this;
    }

    public function addCriterionStop(ReminderCriterionType $criteriontype, $title, ModelAttribute $modelattribute, $criterion_value, $description = null, $criterion_role = null) : Reminder {
        ReminderCriterion::createNew($criteriontype, $this, $title, $modelattribute, $criterion_value, false, true, $description, $criterion_role);

        return $this;
    }

    public function addDefaultBroadlist($title, $msg, $roles, $users, $notification_interval, $description = null, $broadlist_role = null) : Reminder {
        $broadlist = ReminderBroadlist::createNew($title, $msg, $notification_interval, $description, $broadlist_role);

        if (! empty($roles)) {
            $broadlist->syncRoles($roles);
        }
        if (! empty($users)) {
            $broadlist->syncUsers($users);
        }

        $this->addBroadlist($broadlist->id);

        return $this;
    }

    #endregion
}
