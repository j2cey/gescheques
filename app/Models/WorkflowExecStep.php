<?php

namespace App\Models;

use PHPUnit\Util\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
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
 * @property integer|null $posi
 *
 * @property string|null $username
 * @property boolean $rejected
 * @property string|null $reject_comment
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

    #region Custom Functions

    public function process(Request $request) {
        $user = auth()->user();
        if ($request->rejected) {
            $this->rejected = true;
            $this->reject_comment = $request->reject_comment;
            $workflow_status = WorkflowStatus::where('code', "5")->first(); // Rejété
        } else {
            // Parcourir et traiter les actions
            foreach ($this->step->actions as $action) {
                $execaction = $action->launch($this);

                $execaction->process($request);
            }
            $workflow_status = WorkflowStatus::where('code', "4")->first(); // Traitement Terminé
        }
        $this->user_id = $user->getAuthIdentifier();
        $this->username = $user->name;
        $this->workflow_status_id = $workflow_status->id;
        $this->save();
    }

    #endregion
}
