<?php

namespace App\Models;

use PHPUnit\Util\Json;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class WorkflowExecStep
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property integer|null $workflow_exec_id
 * @property integer|null $workflow_step_id
 *
 * @property Json $report
 * @property integer|null $workflow_status_id
 * @property integer|null $user_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WorkflowExecStep extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;
    protected $guarded = [];

    #region Eloquent Relationships

    public function exec() {
        return $this->belongsTo(WorkflowExec::class, 'workflow_exec_id');
    }

    public function step() {
        return $this->belongsTo(WorkflowStep::class, 'workflow_step_id');
    }

    public function execactions() {
        return $this->hasMany(WorkflowExecAction::class, 'workflow_exec_step_id');
    }

    public function execstatus() {
        return $this->belongsTo(WorkflowStatus::class, 'workflow_status_id');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    #endregion
}
