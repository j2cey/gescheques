<?php

namespace App\Models;

use PHPUnit\Util\Json;
use Illuminate\Support\Carbon;
use App\Mail\WorkflowStepNext;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;
use App\Events\WorkflowStepCompleted;
use OwenIt\Auditing\Contracts\Auditable;
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
 * @property integer|null $current_step_id
 * @property integer|null $current_step_role_id
 * @property integer|null $workflow_id
 * @property string $model_type
 * @property integer|null $model_id
 *
 * @property bool $traitement_effectif
 *
 * @property string|null $motif_rejet
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

    public function currentstep() {
        return $this->belongsTo(WorkflowStep::class,'current_step_id');
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

    public function nextStep() {
        return $this->workflow->nextStep($this->currentstep->posi);
    }

    #endregion

    #region Custom Functions

    public function Traiter() {
        $nb_currsteps_non_traitees = DB::table('workflow_exec_model_steps')
            ->where('workflow_exec_id', $this->id)
            ->where('workflow_step_id', $this->current_step_id)
            ->where('traitement_effectif', 0)
            ->count('id');
        if ( $nb_currsteps_non_traitees === 0) {
            // si toutes les occurences de l'étape en cours sont traitées,
            // on récupère l'étape suivante
            $next_step = $this->nextStep();

            if ($next_step->code == "step_end") {
                // le traitement est effectif si l'étape suivante est l'étape de fin (code = 0)
                $traitement_effectif = 1;
            } else {
                // On passe a l étape suivante
                $traitement_effectif = 0;
                // Notifier l'étape suivante
                event(new WorkflowStepCompleted($this, $this->currentstep, $next_step));
            }

            $this->update([
                'traitement_effectif' => $traitement_effectif,
                'current_step_id' => $next_step->id,
            ]);
        }
    }

    #endregion

    public static function boot(){
        parent::boot();

        // Après enregistrement, on met à jour l'id du role de l'actuel étape
        self::saving(function($model){
            if ($model->current_step_id) {
                $currentstep = WorkflowStep::where('id', $model->current_step_id)->first();
                if ($currentstep) {
                    $model->current_step_role_id = $currentstep->role_id;
                }
            }
        });

        self::saved(function($model){
            if ($model->current_step_id) {
                $currentstep = WorkflowStep::where('id', $model->current_step_id)->first();
                if ($currentstep) {
                    // TODO: changer App\Models\Bordereauremise par Bordereauremise::class
                    if ($model->model_type === 'App\Models\Bordereauremise') {
                        $bordereauremise = Bordereauremise::where('id', $model->model_id)->first();
                        if ($bordereauremise) {
                            $currentstep->updateBordereauremise($bordereauremise);
                        }
                    }
                }
            }
        });
    }
}
