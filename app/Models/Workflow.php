<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Workflow\WorkflowExecTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Workflow
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $titre
 * @property string|null $model_type
 *
 * @property integer|null $user_id
 * @property integer|null $workflow_object_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Workflow extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable, WorkflowExecTrait;

    protected $guarded = [];

    #region Eloquent Relationships

    public function steps() {
        return $this->hasMany(WorkflowStep::class)->orderBy('posi');
    }

    public function object() {
        return $this->belongsTo(WorkflowObject::class,'workflow_object_id');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    #endregion

    #region Validation Rules

    public static function defaultRules() {
        return [
            'titre' => 'required',
            'object' => 'required',
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

    #endregion

    #region Custom

    public function nextStep($posi) {
        $next_step = $this->steps()
            ->where('posi', $posi + 1)
            ->first();
        if (! $next_step) {
            // s'il n'y a pas d'étape à la suite de cette position,
            // on est à la fin du workflow
            $next_step = WorkflowStep::coded("step_end")->first();
        }
        return $next_step;
    }

    #endregion
}
