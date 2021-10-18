<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ReminderCriterion
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
 * @property string $code
 * @property boolean $is_start_criterion
 * @property boolean $is_stop_criterion
 *
 * @property string $criterion_value
 * @property string $criterion_role
 * @property string|null $description
 *
 * @property integer|null $reminder_criterion_type_id
 * @property integer|null $reminder_id
 * @property integer|null $model_attribute_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property ReminderCriterionType $criteriontype
 * @property Reminder $reminder
 * @property ModelAttribute $modelattribute
 */
class ReminderCriterion extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    #region Validation Rules

    public static function defaultRules() {
        return [
            'title' => 'required',
            'is_start_criterion' => 'required_if:is_stop_criterion,0',
            'is_stop_criterion' => 'required_if:is_start_criterion,0',
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
            'title.required' => 'The Name is required',
            'is_start_criterion.required_if' => 'Must be start criterion when not stop',
            'is_stop_criterion.required_if' => 'Must be stop criterion when not start',
        ];
    }

    #endregion

    #region Eloquent Relationships

    public function criteriontype() {
        return $this->belongsTo(ReminderCriterionType::class, 'reminder_criterion_type_id');
    }

    public function reminder() {
        return $this->belongsTo(Reminder::class, 'reminder_id');
    }

    public function modelattribute() {
        return $this->belongsTo(ModelAttribute::class, 'model_attribute_id');
    }

    #endregion

    #region Custom Functions - CRUD

    public static function createNew(ReminderCriterionType $criteriontype, Reminder $reminder, $title, ModelAttribute $modelattribute, $criterion_value, $is_start_criterion = true, $is_stop_criterion = false, $description = null, $criterion_role = null): ReminderCriterion {
        $remindercriterion = ReminderCriterion::create([
            'title' => $title,
            'criterion_role' => $criterion_role,
            'criterion_value' => $criterion_value,
            'is_start_criterion' => $is_start_criterion,
            'is_stop_criterion' => $is_stop_criterion,
            'description' => $description,
        ]);

        if( ! is_null($criteriontype) ) $remindercriterion->setCriterionType($criteriontype, false);
        if( ! is_null($reminder) ) $remindercriterion->setReminder($reminder, false);
        if( ! is_null($modelattribute) ) $remindercriterion->setModelattribute($modelattribute, false);

        $remindercriterion->save();

        return $remindercriterion;
    }

    public function setCriterionType(ReminderCriterionType $remindercriteriontype = null, $save = true) {
        if ( is_null($remindercriteriontype) ) {
            $this->criteriontype()->disassociate();
        } else {
            $this->criteriontype()->associate($remindercriteriontype);
        }

        if ($save) { $this->save(); }

        return $this;
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

    public function setModelattribute(ModelAttribute $modelattribute = null, $save = true) {
        if ( is_null($modelattribute) ) {
            $this->modelattribute()->disassociate();
        } else {
            $this->modelattribute()->associate($modelattribute);
        }

        if ($save) { $this->save(); }

        return $this;
    }

    #endregion

    #region Custom Functions - Criterion Validation

    /**
     * Check if this criterion is met for a given object
     * @param $model
     * @return bool
     */
    public function isMet($model) {
        $is_met = false;

        if (!$model) {
            return false;
        } else {

            if ($this->criteriontype->code === "duration_greater_or_equal_hours") {
                $start = Carbon::parse($model->{$this->modelattribute->label});
                $end = Carbon::now();
                $duration = $end->diffInHours($start);
                $is_met = ($duration >= $this->criterion_value);
            } elseif ($this->criteriontype->code === "duration_greater_or_equal_mins") {
                $start = Carbon::parse($model->{$this->modelattribute->label});
                $end = Carbon::now();
                $duration = $end->diffInHours($start) * 60;
                $is_met = ($duration >= $this->criterion_value);
            } elseif ($this->criteriontype->code === "field_equals_value") {
                $is_met = ($model->{$this->modelattribute->label} == $this->criterion_value);
            } elseif ($this->criteriontype->code === "field_not_equals_value") {
                $is_met = ($model->{$this->modelattribute->label} != $this->criterion_value);
            }

            return $is_met;
        }
    }

    #endregion
}
