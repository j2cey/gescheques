<?php

namespace App\Models;

use PHPUnit\Util\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Mail\WorkflowStepNext;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;
use App\Events\WorkflowStepCompleted;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Workflow\HasWorkflowStatus;
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
 * @property Carbon|null $start_at
 * @property Carbon|null $end_at
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WorkflowExec extends BaseModel implements Auditable
{
    use HasFactory, HasWorkflowStatus, \OwenIt\Auditing\Auditable;
    protected $guarded = [];

    #region Eloquent Relationships

    public function workflow() {
        return $this->belongsTo(Workflow::class,'workflow_id');
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

    public function prevstep() {
        return $this->belongsTo(WorkflowStep::class,'prev_step_id');
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

    public function workflowprocessstatus() {
        return $this->belongsTo(WorkflowProcessStatus::class,'workflow_process_status_id');
    }

    public function currentsteprole() {
        return $this->belongsTo(Role::class, 'current_step_role_id');
    }

    public function nextStep_old() {
        return $this->workflow->nextStep($this->currentstep->posi);
    }

    public function firstexecstep() {
        return $this->hasOne(WorkflowExecStep::class, 'workflow_exec_id')
            ->where('posi', 0)
            ->latest();
    }

    public function lastexecstep() {
        return $this->hasOne(WorkflowExecStep::class, 'workflow_exec_id')
            ->orderBy('posi', 'desc')
            ->latest();
    }

    #endregion

    #region Custom Functions

    public function process(Request $request) {

        // marquer la date de début d exécution
        if ( is_null($this->start_at) ) {
            $this->setStartAt(true);
        }

        // on marque l exec comme en cours de traitement
        $this->setWorkflowStatus('processing', true)
            ->setWorkflowProcessStatus('processing', true);

        // On lance l'exécution de l'étape courrante
        // ce qui aura pour effet de créer une instance d'exécution d'étape (WorkflowExecStep)
        $current_step_exec = $this->currentstep->launch($this);
        // On procède au traitement de l'étape (traitement de son WorkflowExecStep)
        $current_step_exec = $current_step_exec->process($request);

        // On assigne le role effectif de l'étape exec courante
        $current_step_exec->setEffectiveRole($this->currentprofile);

        $this->setPrevStep($this->currentstep);
        // Redirection
        if ($current_step_exec->isWorkflowStatusRejected()) {
            // Rejété
            $this->setCurrentStep($this->currentstep->rejectednextstep);
        } elseif ($current_step_exec->isWorkflowStatusExpired()) {
            // Expiré
            $this->setCurrentStep($this->currentstep->expirednextstep);
        } else {
            // Traitement validé
            $this->setCurrentStep($this->currentstep->validatednextstep);
        }
        $this->setNextStep($this->currentstep->validatednextstep);

        if ($this->currentstep->isLastStep()) {
            if ($current_step_exec->isWorkflowStatusRejected()) {
                // si nous sommes à la dernière étape suite à un réjet,
                // on marque le traitement comme rejétée
                $this->setWorkflowStatus('rejected', true)
                    ->setWorkflowProcessStatus('processed', true);

                // Et l étape courante sera "Traitement Rejété"
                $this->setCurrentStepRejected();
            } elseif ($current_step_exec->isWorkflowStatusExpired()) {
                // si nous sommes à la dernière étape suite à une expiration,
                // on marque le traitement comme expiré
                $this->setWorkflowStatus('expired', true)
                    ->setWorkflowProcessStatus('processed', true);

                // Et l étape courante sera "Traitement Expiré"
                $this->setCurrentStepExpired();
            } else {
                // marquer l exec comme terminée
                $this->setWorkflowStatus('validated', true)
                    ->setWorkflowProcessStatus('processed', true);
            }

            // marquer la date de fin d exécution
            if ( is_null($this->end_at) ) {
                $this->setEndAt(true);
            }
            // Puis l'étape suivante sera null
            $this->unsetNextStep();
        } else {
            // marquer l exec comme en pending
            $this->setWorkflowStatus('pending', true)
                ->setWorkflowProcessStatus('processed', true);
        }

        $this->save();

        $dynamic_role = json_decode($request->current_step_role, true);

        $this->setCurrentRole($dynamic_role ? $dynamic_role["id"] : null);

        $this->save();

        return $this;
    }

    public function setCurrentRole($dynamic_role_id = null) {
        $currentstep = WorkflowStep::where('id',$this->current_step_id)->first();
        if ($currentstep) {
            if ($currentstep->role_dynamic) {
                $this->update(['current_step_role_id' => $dynamic_role_id]);
            } else {
                $currentrole = Role::where('id',$currentstep->role_id)->first();
                if ($currentrole) {
                    $this->currentprofile()->associate($currentrole)->save();
                } else {
                    $this->currentprofile()->disassociate()->save();
                }
            }
        }
    }

    public function unsetCurrentStep() {
        $this->currentstep()->disassociate()->save();
    }

    public function setCurrentStep(?WorkflowStep $step) {
        if ( is_null($step) ) {
            $this->unsetCurrentStep();
        } else {
            $this->currentstep()->associate($step)->save();
        }
    }

    public function setCurrentStepEnd() {
        // Traitement Terminé
        $step_end = WorkflowStep::where("code","step_end")->first();
        $this->setCurrentStep($step_end);
    }

    public function setCurrentStepRejected() {
        // Traitement Rejeté
        $step_rejected = WorkflowStep::where("code","step_rejected")->first();
        $this->setCurrentStep($step_rejected);
    }

    public function setCurrentStepExpired() {
        // Traitement Expiré
        $step_expired = WorkflowStep::createNew("code","step_expired")->first();
        $this->setCurrentStep($step_expired);
    }

    public function unsetNextStep() {
        $this->nextstep()->disassociate()->save();
    }

    public function setNextStep(?WorkflowStep $step) {
        if ( is_null($step) ) {
            $this->unsetNextStep();
        } else {
            $this->nextstep()->associate($step)->save();
        }
    }

    public function unsetPrevStep() {
        $this->prevstep()->disassociate()->save();
    }

    public function setPrevStep(?WorkflowStep $step) {
        if ( is_null($step) ) {
            $this->unsetPrevStep();
        } else {
            $this->prevstep()->associate($step)->save();
        }
    }

    #endregion

    public static function boot(){
        parent::boot();

        // Avant création ...
        self::creating(function($model){
            // config des statuts
            $model->setWorkflowStatus('new', false)
                ->setWorkflowProcessStatus('pending', false)
            ;
        });
    }
}
