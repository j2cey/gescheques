<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ReminderCriterionType
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $name
 * @property string $code
 * @property string|null $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ReminderCriterionType extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    #region Validation Rules

    public static function defaultRules() {
        return [
            'name' => 'required',
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
            'name.required' => 'The Name is required',
        ];
    }

    #endregion

    #region Eloquent Relationships

    public function criteria() {
        return $this->hasMany(ReminderCriterion::class, 'reminder_criterion_type_id');
    }

    #endregion

    #region Custom Functions - CRUD

    public static function createNew($name, $description = null, $code = null): ReminderCriterionType {
        $remindercriteriontype = ReminderCriterionType::create([
            'name' => $name,
            'code' => is_null($code) ? Str::slug('crit_typ_' . (string)Str::orderedUuid(), "_" ) : $code,
            'description' => $description,
        ]);

        $remindercriteriontype->save();

        return $remindercriteriontype;
    }

    #endregion
}
