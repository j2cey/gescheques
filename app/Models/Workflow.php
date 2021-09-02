<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use App\Events\WorkflowStepCompleted;
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
 * @property string $description
 * @property string|null $model_type
 *
 * @property integer|null $user_id
 * @property integer|null $workflow_object_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property WorkflowObject $object
 * @property WorkflowStep[] $steps
 */
class Workflow extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable, WorkflowExecTrait;

    protected $guarded = [];

    #region Eloquent Relationships

    public function steps() {
        return $this->hasMany(WorkflowStep::class)->orderBy('posi');
    }

    public function startnode() {
        $step_type = WorkflowStepType::getStartType();
        return $this->hasOne(WorkflowStep::class)
            ->where('workflow_step_type_id', $step_type->id)
            ->latest();
    }

    public function endnode() {
        $step_type = WorkflowStepType::getEndType();
        return $this->hasOne(WorkflowStep::class)
            ->where('workflow_step_type_id', $step_type->id)
            ->latest();
    }

    public function object() {
        return $this->belongsTo(WorkflowObject::class,'workflow_object_id');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function workflowstatus() {
        return $this->belongsTo(WorkflowStatus::class,'workflow_status_id');
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

    #region Custom Functions CRUD

    public static function createNew($titre, $description, $user_id, $workflow_object_id, $model_type) : Workflow {
        $wf = Workflow::create([
            'titre' => $titre,
            'description' => $description,
            'user_id' => $user_id,
            'workflow_object_id' => $workflow_object_id,
            'model_type' => $model_type,
        ]);

        $wf->setStartNode()
            ->setEndNode()
            ;

        return $wf;
    }

    public function getStartNode() : ?WorkflowStep {
        $step_type = WorkflowStepType::getStartType();
        return WorkflowStep::where('workflow_id', $this->id)
            ->where('workflow_step_type_id', $step_type->id)
            ->first();
    }

    public function setStartNode($titre = null, $description = null) : Workflow {
        $startnode = $this->getStartNode();
        if ( ! $startnode ) {
            WorkflowStep::createNewAsStartNode($titre ? $titre : config('Settings.flowchart.startnode.default_name'), $description ? $description : config('Settings.flowchart.startnode.default_description'), "approve", $this,null);
        }
        return $this;
    }

    public function getEndNode() : ?WorkflowStep {
        $step_type = WorkflowStepType::getEndType();
        return WorkflowStep::where('workflow_id', $this->id)
            ->where('workflow_step_type_id', $step_type->id)
            ->first();
    }

    public function setEndNode($titre = null, $description = null) : Workflow {
        $endnode = $this->getEndNode();
        if ( ! $endnode ) {
            WorkflowStep::createNewAsEndNode($titre ? $titre : config('Settings.flowchart.endnode.default_name'), $description ? $description : config('Settings.flowchart.endnode.default_description'), "approve", $this,null);
        }
        return $this;
    }

    public function addStep($titre, $description) : WorkflowStep {
        return WorkflowStep::createNew($titre,$description,"approve",$this);
    }

    public function addOrUpdateStep($code, $titre, $description) : WorkflowStep {
        $step = WorkflowStep::where('code', $code)->first();
        if ($step) {
            $step->update(['titre' => $titre, 'description' => $description]);
            return $step;
        } else {
            return $this->addStep($titre, $description);
        }
    }

    public function removeStep(WorkflowStep $step) {
        $step->removeFromWorkflow();
    }

    #endregion

    #region Custom Functions

    public function launch($model_type, $model_id) {
        // si le workflow est actif
        if ($this->status->code == "active") {
            $first_step = $this->getFirstStep();
            $exec = WorkflowExec::create([
                'workflow_id' => $this->id,
                'current_step_id' => $first_step ? $first_step->id : null,
                'next_step_id' => $first_step ? ( $first_step->transitionpassstep ? $first_step->transitionpassstep->id : null ) : null,
                'model_type' => $model_type,
                'model_id' => $model_id,
                'report' => json_encode([]),
            ]);
            $exec->setCurrentApprovers($first_step->staticapprovers);

            // Notifier l'étape suivante
            //event(new WorkflowStepCompleted($exec, $this->getStartNode(), $first_step));

            return $exec;
        } else {
            return false;
        }
    }

    /**
     * Retourne l'id de la première étape du workflow
     * @return WorkflowStep|null
     */
    private function getFirstStep() : ?WorkflowStep {
        return WorkflowStep::where('workflow_id', $this->id)
            ->where('posi', 0)
            ->first();
        /*if ($first_step) {
            return $first_step;
        } else {
            return null;
        }*/
    }

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
