<?php

namespace App\Models;

use PHPUnit\Util\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Mail\WorkflowStepNext;
use App\Traits\Report\HasReport;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;
use App\Events\WorkflowStepCompleted;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Workflow\HasWorkflowStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Requests\WorkflowExec\UpdateWorkflowExecRequest;

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
 *
 * @property WorkflowStep $currentstep
 * @property WorkflowExecStep $lastexecstep
 * @property Role[] $currentapprovers
 * @property WorkflowStep $prevstep
 */
class WorkflowExec extends BaseModel implements Auditable
{
    use HasFactory, HasWorkflowStatus, HasReport, \OwenIt\Auditing\Auditable;
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

    /*public function currentprofile() {
        return $this->belongsTo(Role::class,'current_step_role_id');
    }*/

    public function currentapprovers() {
        return $this->belongsToMany(Role::class, 'workflow_exec_currentrole', 'workflow_exec_id', 'role_id');
    }

    public function prevstep() {
        return $this->belongsTo(WorkflowStep::class,'prev_step_id');
    }

    /*public function nextstep() {
        return $this->belongsTo(WorkflowStep::class,'next_step_id');
    }*/

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

    public function process(UpdateWorkflowExecRequest $request) {

        $prev_step_exec = $this->lastexecstep;

        // marquer la date de début d exécution
        if ( is_null($this->start_at) ) {
            $this->setStartAt(true);
        }

        // on marque l exec comme en cours de traitement
        $this->setWorkflowProcessStatusProcessing(true)
            ->setWorkflowStatusProcessing(true)
        ;

        // On lance l'exécution de l'étape courante
        // ce qui aura pour effet de créer une instance d'exécution d'étape (WorkflowExecStep)
        $current_exec_step = $this->currentstep->launch($this);

        if ( is_null($current_exec_step) ) {
            // l' exécution d'étape (WorkflowExecStep) est null, alors rien a exécuter
            $this->setWorkflowProcessStatusFailed(true)
                ->setWorkflowStatusPending(true)
            ;
            $this->addToReport(1, "l execution d étape est nulle", -1, true);
            $this->endProcess();
        } else {
            // On procède au traitement de l'étape (traitement de son WorkflowExecStep)
            $current_exec_step = $current_exec_step->process($request);

            if ( $current_exec_step->isWorkflowProcessStatusFailed() ) {
                // Le traitement de l'étape a échoué
                $this->setWorkflowProcessStatusFailed(true)
                    ->setWorkflowStatusPending(true)
                ;
                $this->addToReport(1, "l execution de la dernière étape a échoué", -1, true);
                $this->endProcess();
            } else {
                // On assigne le(s) role(s) effectif(s) de l'étape exec courante
                $current_exec_step->setEffectiveApprovers( $this->getRoleIds($this->currentapprovers) );
                // l'étape en cours sera l'étape précedente
                $this->setPrevStep($this->currentstep);

                // Redirection
                $transitions_arr = $this->currentstep->getTransitionsArray();
                $this->setCurrentStep($transitions_arr[$request->treatment_type->code]);

                // Statuts de l'exec
                if ($this->currentstep->isLastStep()) {
                    // si on est en fin de traitement, on assigne le statut de la dernière étape
                    $this->setWorkflowStatus($current_exec_step->workflowstatus->code, true)
                        ->setWorkflowProcessStatusProcessed(true);

                    // on reset les acurrent approvers de l'exec
                    $this->setCurrentApprovers(null);
                } else {
                    $this->setWorkflowStatusPending(true)
                        ->setWorkflowProcessStatusPending(true);

                    $this->save();

                    // approvers de l'étape suivante
                    if ($this->currentstep->role_dynamic) {
                        $custom_roles = $request->current_step_role ? [$request->current_step_role] : null;
                    } elseif ($this->currentstep->role_previous) {
                        $custom_roles = $prev_step_exec ? $prev_step_exec->effectiveapprovers : $this->currentstep->approvers;
                    } else {
                        $custom_roles = $this->currentstep->approvers;
                    }
                    $this->setCurrentApprovers($custom_roles);

                    // Notifier l'étape suivante
                    event(new WorkflowStepCompleted($this, $this->prevstep, $this->currentstep)); // $exec, $oldStep, $nextStep
                }

                $this->save();
            }
        }

        return $this;
    }

    private function getRoleIds($roles) {
        $role_ids = [];
        $ids_count = 0;

        if ( ! is_null($roles) ) {
            foreach ($roles as $role) {
                $role_ids[] = $role->id;
                $ids_count++;
            }
        }

        if ($ids_count > 0) {
            return $role_ids;
        } else {
            return null;
        }
    }

    private function endProcess() {
        // marquer la date de fin d exécution
        if ( is_null($this->end_at) ) {
            $this->setEndAt(true);
        }
    }

    public function setCurrentApprovers($custom_roles = null) {
        $custom_role_ids = $this->getRoleIds($custom_roles);
        if ( is_null($custom_role_ids) ) {
            $this->currentapprovers()->detach();
        } else {
            $this->currentapprovers()->sync($custom_role_ids);
        }
    }

    public function unsetCurrentStep() {
        $this->currentstep()->disassociate()->save();
    }

    public function setCurrentStep( ?WorkflowStep $step ) {
        if ( is_null($step) ) {
            $this->unsetCurrentStep();
        } else {
            $this->currentstep()->associate($step)->save();
        }
    }

    /*public function setCurrentStepEnd() {
        // Traitement Terminé
        $step_end = WorkflowStep::where("code","step_end")->first();
        $this->setCurrentStep($step_end);
    }*/

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

    /*public function setNextStep(?WorkflowStep $step) {
        if ( is_null($step) ) {
            $this->unsetNextStep();
        } else {
            $this->nextstep()->associate($step)->save();
        }
    }*/

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
