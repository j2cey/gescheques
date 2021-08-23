<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class WorkflowStepType
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
class WorkflowStepType extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    #region Custom Functions - Create/Update

    public static function createNew($name, $code, $description): WorkflowStepType {
        $action = WorkflowStepType::create([
            'name' => $name,
            'code' => is_null($code) ? Str::slug('workflow_step_type_' . (string)Str::orderedUuid(), "_" ) : $code,
            'description' => $description,
        ]);

        $action->save();

        return $action;
    }

    public static function getStartType() : WorkflowStepType {
        return self::where('code', "start")->first();
    }

    public static function getEndType() : WorkflowStepType {
        return self::where('code', "end")->first();
    }

    public static function getOperationType() : WorkflowStepType {
        return self::where('code', "operation")->first();
    }

    #endregion
}
