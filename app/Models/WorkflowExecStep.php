<?php

namespace App\Models;

use PHPUnit\Util\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Workflow\HasWorkflowStatus;
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
 *
 * @property boolean $rejected
 * @property string|null $reject_comment
 *
 * @property boolean $expired
 * @property string|null $expire_comment
 *
 * @property Json $report
 *
 * @property integer|null $effective_role_id
 * @property integer|null $workflow_status_id
 * @property integer|null $workflow_process_status_id
 *
 * @property integer|null $user_id
 * @property Carbon|null $start_at
 * @property Carbon|null $end_at
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WorkflowExecStep extends BaseModel implements Auditable
{
    use HasFactory, HasWorkflowStatus, \OwenIt\Auditing\Auditable;
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

    public function workflowstatus() {
        return $this->belongsTo(WorkflowStatus::class, 'workflow_status_id');
    }

    public function workflowprocessstatus() {
        return $this->belongsTo(WorkflowProcessStatus::class,'workflow_process_status_id');
    }

    /**
     * Role utilisé à l'exécution
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function effectiverole() {
        return $this->belongsTo(Role::class, 'effective_role_id');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    #endregion

    #region Custom Functions

    public function process(Request $request) {
        // marquer la date de début d exécution
        if ( is_null($this->start_at) ) {
            $this->setStartAt(true);
        }

        // on récupère les différent types de traitement
        $rejection_treatment = WorkflowTreatmentType::getRejectionType();

        // on marque l exec d étape comme en cours de traitement
        $this->setWorkflowStatus('processing', true)
            ->setWorkflowProcessStatus('processing', true);

        $user = auth()->user();
        if ($request->treatment_type->id === $rejection_treatment->id) {
            $this->setWorkflowStatus('rejected', true)
                ->setWorkflowProcessStatus('rejected', true);
        } else {
            $this->setWorkflowStatus('validated', true)
                ->setWorkflowProcessStatus('processed', true);
        }

        // Parcourir et traiter les actions
        $nb_actions_process = 0;
        $nb_actions_failed = 0;

        foreach ($this->step->actions as $action) {

            if ($action->treatmenttype->id === $request->treatment_type->id) {

                $execaction = $action->launch($this);
                $execaction->process($request);

                $nb_actions_process += $execaction->save_result > 0 ? 1 : 0;
                $nb_actions_failed += $execaction->save_result > 0 ? 0 : 1;
            }
        }

        if ($nb_actions_process) {
            // si au moins 1 action est processée,
            // tout s'est bien passé
        } else {
            // sinon
            // on marque l exec d action d étape comme échouée
            $this->setWorkflowStatus('pending', true)
                ->setWorkflowProcessStatus('failed', true);
        }

        $this->user_id = $user->getAuthIdentifier();
        $this->username = $user->name;

        // marquer la date de fin d exécution
        if ( is_null($this->end_at) ) {
            $this->setEndAt(true);
        }

        $this->save();
        return $this;
    }

    public function process_old(Request $request) {
        // marquer la date de début d exécution
        if ( is_null($this->start_at) ) {
            $this->setStartAt(true);
        }

        // on marque l exec d étape comme en cours de traitement
        $this->setWorkflowStatus('processing', true)
            ->setWorkflowProcessStatus('processing', true);

        $user = auth()->user();
        if ($request->rejected) {
            //$this->rejected = true;
            //$this->reject_comment = $request->reject_comment;

            //$this->processMotifRejet($request->reject_comment);

            foreach ($this->step->rejectionactions as $action) {
                $execaction = $action->launch($this);
                $execaction->process($request);
            }

            // on marque l exec d étape comme Rejété
            $this->setWorkflowStatus('rejected', true)
                ->setWorkflowProcessStatus('rejected', true);
        } else {
            // Parcourir et traiter les actions
            $nb_actions_process = 0;
            $nb_actions_failed = 0;
            foreach ($this->step->validationactions as $action) {
                $execaction = $action->launch($this);

                $execaction->process($request);

                $nb_actions_process += $execaction->save_result > 0 ? 1 : 0;
                $nb_actions_failed += $execaction->save_result > 0 ? 0 : 1;
            }

            if ($nb_actions_process) {
                // si au moins 1 action est processée,
                // on marque l exec d étape comme Validé
                $this->setWorkflowStatus('validated', true)
                    ->setWorkflowProcessStatus('processed', true);
            } else {
                // sinon
                // on marque l exec d action d étape comme échouée
                $this->setWorkflowStatus('pending', true)
                    ->setWorkflowProcessStatus('failed', true);
            }
        }

        $this->user_id = $user->getAuthIdentifier();
        $this->username = $user->name;

        // marquer la date de fin d exécution
        if ( is_null($this->end_at) ) {
            $this->setEndAt(true);
        }

        $this->save();
        return $this;
    }

    public function processMotifRejet($value) {
        $motif_rejet_action = WorkflowAction::where('code', "motif_rejet_action")->first();

        $request_field = $motif_rejet_action->code;
        $execaction = $motif_rejet_action->launch($this);
        $execaction->processFromValue($value, $request_field);
    }

    public function setEffectiveRole(?Role $role) {
        if ( is_null($role) ) {
            $this->effectiverole()->disassociate();
        } else {
            $this->effectiverole()->associate($role)->save();
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
