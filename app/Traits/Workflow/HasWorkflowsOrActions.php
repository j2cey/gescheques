<?php

namespace App\Traits\Workflow;

use App\Models\Workflow;
use App\Models\WorkflowAction;
use App\Models\WorkflowExec;
use App\Models\WorkflowExecAction;
use App\Models\WorkflowExecModelStep;
use App\Models\WorkflowExecStep;
use App\Models\WorkflowStep;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

trait HasWorkflowsOrActions
{
    /**
     * Le(s) Workflow(s) rattaché(s) a ce type de modèle le cas échéant
     * @return Collection|null
     */
    public function workflows() {
        $model_type = get_called_class();
        $workflows = Workflow::where('model_type', $model_type)
            ->get();

        if ($workflows) {
            return $workflows;
        } else {
            return null;
        }
    }

    public function workflowactions() {
        $model_type = get_called_class();
        $workflowactions = WorkflowAction::where('model_type', $model_type)
            ->get();

        if ($workflowactions) {
            return $workflowactions;
        } else {
            return null;
        }
    }

    public function currexec() {
        $modelstep_first = $this->modelSteps()->first();
        return WorkflowExec::where('id', $modelstep_first->workflow_exec_id);
    }

    /**
     * Renvoie l'étape (+ actions) en cours d'exécution pour ce model
     */
    public function currmodelstep() {
        $model_type = get_called_class();
        $currexec = $this->currexec();
        if ($currexec) {
            return $this->hasOne(WorkflowExecModelStep::class, 'model_id')
                ->select('workflow_exec_model_steps.*')
                ->join('workflow_execs', 'workflow_execs.current_step_id', '=', 'workflow_exec_model_steps.workflow_step_id')
                ->where('workflow_exec_model_steps.model_type', $model_type)
                ->where('workflow_exec_model_steps.traitement_effectif', 0)
                ->latest();
        } else {
            return null;
        }
    }

    public function modelSteps() {
        $model_type = get_called_class();
        return $this->hasMany(WorkflowExecModelStep::class, 'model_id', 'id')
            ->where('model_type', $model_type);
    }

    public function launchWorkflowActions() {
        $model_type = get_called_class();
        foreach ($this->workflowactions() as $workflowaction) {

            $workflow_exec_model_step = WorkflowExecModelStep::where('model_type', $model_type)
                ->where('model_id', $this->id)
                ->where('workflow_step_id', $workflowaction->workflow_step_id)
                ->first();

            if (! $workflow_exec_model_step) {
                // si l'instance n existe pas
                // on récupère ou crée l'instance d'exécution de workflow
                if ($workflowaction->objectfield->object->parent) {
                    // action d'objet enfant
                    // on prend la dernière exec du workflow ayant l'id du parent
                    $model_parent_type = $workflowaction->objectfield->object->parent->model_type;
                    $model_parent = $model_parent_type::where('id', $this->{$workflowaction->objectfield->object->ref_field})->first();
                    $workflow_exec = WorkflowExec::where('workflow_id', $workflowaction->step->workflow_id)
                        ->where('model_id', $model_parent->id)
                        ->where('model_type', $model_parent_type)
                        ->orderBy('id', 'desc')->first();
                } else {
                    // action d'objet principal
                    // on prend la dernière exec du workflow
                    $workflow_exec = WorkflowExec::where('workflow_id', $workflowaction->step->workflow_id)
                        ->where('model_type', $model_type)
                        ->orderBy('id', 'desc')->first();
                }

                $workflow_exec_model_step = WorkflowExecModelStep::create([
                    'workflow_exec_id' => $workflow_exec->id,
                    'workflow_step_id' => $workflowaction->workflow_step_id,
                    'model_id' => $this->id,
                    'model_type' => $model_type,
                    'report' => json_encode([]),
                ]);
            }

            // on y a joute l'action en cours (de boucle)
            DB::table('model_step_actions')->insert([
                'workflow_exec_model_step_id' => $workflow_exec_model_step->id,
                'workflow_action_id' => $workflowaction->id,
            ]);
        }
    }

    public function launchWorkflows() {
        foreach ($this->workflows() as $workflow) {
            $model_type = get_called_class();
            $workflowexec = WorkflowExec::where('model_type', $model_type)
                ->where('model_type', $model_type)
                ->where('model_id', $this->id)->first();
            if (! $workflowexec) {
                // On lance le Workflow pour cet objet s'il n'en a pas un en cours
                $this->createWorkflowExec($workflow, $model_type);
            }
        }
    }

    private function createWorkflowExec($workflow, $model_type) {
        return WorkflowExec::create([
            'workflow_id' => $workflow->id,
            'current_step_id' => $this->getFirstStepId($workflow->id),
            'model_type' => $model_type,
            'model_id' => $this->id,
            'report' => json_encode([]),
        ]);
    }

    private function createWorkflowExecStep($workflow_exec,$workflowstep) {
        return WorkflowExecStep::create([
            'workflow_exec_id' => $workflow_exec->id,
            'workflow_step_id' => $workflowstep->id,
            'report' => json_encode([]),
        ]);
    }

    private function createWorkflowExecAction($workflow_exec, $workflowaction, $model_type) {
        return WorkflowExecAction::create([
            'workflow_exec_id' => $workflow_exec->id,
            'workflow_action_id' => $workflowaction->id,
            'model_type' => $model_type,
            'model_id' => $this->id,
            'report' => json_encode([]),
        ]);
    }

    /**
     * Retourne la dernière instance d'un modèle donné
     *
     * @param string $model_type type du modèle
     * @return mixed
     */
    private function getLastModelId(string $model_type){
        return $model_type::orderBy('id', 'DESC')->first()->id;
    }

    /**
     * Renvoie l'id de la première étape du workflow
     * @return |null
     */

    /**
     * Retourne l'id de la première étape d'un workflow donné
     * @param $workflow_id
     * @return integer|null
     */
    private function getFirstStepId($workflow_id) {
        $first_step = WorkflowStep::where('workflow_id', $workflow_id)
            ->where('posi', 0)
            ->first();
        if ($first_step) {
            return $first_step->id;
        } else {
            return null;
        }
    }
}
