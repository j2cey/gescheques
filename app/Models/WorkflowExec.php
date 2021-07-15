<?php

namespace App\Models;

use PHPUnit\Util\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Mail\WorkflowStepNext;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;
use App\Events\WorkflowStepCompleted;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class WorkflowExec
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property integer|null $prev_step_id
 * @property integer|null $current_step_id
 * @property integer|null $next_step_id
 *
 * @property integer|null $current_step_role_id
 * @property integer|null $workflow_id
 * @property string $model_type
 * @property integer|null $model_id
 *
 * @property Json $report
 * @property integer|null $workflow_status_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WorkflowExec extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;
    protected $guarded = [];

    #region Eloquent Relationships

    public function workflow() {
        return $this->belongsTo(Workflow::class,'workflow_id');
    }

    public function prevstep() {
        return $this->belongsTo(WorkflowStep::class,'prev_step_id');
    }

    /**
     * Retourne l'étape qui doit être traitée.
     * Sert de curseur de traitement pour l'exécution
     * @return BelongsTo|WorkflowStep
     */
    public function currentstep() {
        return $this->belongsTo(WorkflowStep::class,'current_step_id');
    }

    public function currentprofile() {
        return $this->belongsTo(Role::class,'current_step_role_id');
    }

    public function nextstep() {
        return $this->belongsTo(WorkflowStep::class,'next_step_id');
    }

    public function execsteps() {
        return $this->hasMany(WorkflowExecStep::class,'workflow_exec_id');
    }

    public function currexecsteps() {
        return $this->hasMany(WorkflowExecModelStep::class,'workflow_exec_id')
            ->where('workflow_step_id', $this->current_step_id)
            ->where('traitement_effectif', 0)
            ;
    }

    public function execactions() {
        return $this->hasMany(WorkflowExecAction::class,'workflow_exec_id');
    }

    public function currentstepactions() {
        return $this->hasMany(WorkflowExecAction::class,'workflow_exec_id')
            ->whereHas('action', function ($q) {
                $q->where('workflow_step_id', $this->current_step_id);
            })
            ;
    }

    public function currentstepuser() {
        /*$userprofile = Role::whereIn('id',
            DB::table('model_has_roles')
                ->where('model_type', 'App\User')
                ->where('model_id', Auth::user()->id)
            ->pluck('role_id')->toArray()
        )->first();*/
        //$user = User::where('id', Auth::user()->id)->first();

        return $this->belongsTo(WorkflowStep::class,'current_step_id');
    }

    public function workflowstatus() {
        return $this->belongsTo(WorkflowStatus::class,'workflow_status_id');
    }

    public function currentsteprole() {
        return $this->belongsTo(Role::class, 'current_step_role_id');
    }

    public function nextStep_old() {
        return $this->workflow->nextStep($this->currentstep->posi);
    }

    #endregion

    #region Custom Functions

    public function process(Request $request) {
        // On lance l'exécution de l'étape courrante
        // ce qui aura pour effet de créer une instance d'exécution d'étape (WorkflowExecStep)
        $current_step_exec = $this->currentstep->launch($this);
        // On procède au traitement de l'étape (traitement de son WorkflowExecStep)
        $current_step_exec->process($request);

        $prev_step = $this->currentstep;
        // Redirection
        if ($current_step_exec->execstatus->code == "5") {
            // Rejété
            $this->current_step_id = $this->currentstep->rejectednextstep->id;
        } else {
            // Traitement terminé
            $this->current_step_id = $this->currentstep->validatednextstep->id;
        }
        $next_step = $this->currentstep->validatednextstep;

        $this->prev_step_id = $prev_step ? $prev_step->id : null;
        $this->next_step_id = $next_step ? $next_step->id : null;

        $dynamic_role = json_decode($request->current_step_role, true);

        //$this->current_step_role_id = $dynamic_role ? $dynamic_role["id"] : $dynamic_role;

        $this->save();

        $this->setCurrentRole($dynamic_role ? $dynamic_role["id"] : null);

        /*if (is_null($dynamic_role)) {
            $this->setCurrentRole();
        } else {
            $this->setCurrentRole($dynamic_role["id"]);
        }*/

        //dd($dynamic_role);
    }

    public function setCurrentRole($dynamic_role_id = null) {
        $currentstep = WorkflowStep::where('id',$this->current_step_id)->first();
        if ($currentstep) {
            if ($currentstep->role_dynamic) {
                $this->update(['current_step_role_id' => $dynamic_role_id]);
            } else {
                $currentrole = Role::where('id',$currentstep->role_id)->first();
                $this->update(['current_step_role_id' => $currentrole->id]);
            }
        }
    }

    #endregion

    public static function boot(){
        parent::boot();

        // Après enregistrement, on met à jour l'id du role de l'actuel étape
    }
}
