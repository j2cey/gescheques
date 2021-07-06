<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class WorkflowObject
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $model_type
 * @property string $model_title
 *
 * @property integer|null $workflow_object_parent_id
 * @property string|null $ref_field
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WorkflowObject extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;
    protected $guarded = [];

    #region Eloquent Relationships

    public function fields() {
        return $this->hasMany(WorkflowObjectField::class);
    }

    public function parent() {
        return $this->belongsTo(WorkflowObject::class, 'workflow_object_parent_id');
    }

    #endregion
}
