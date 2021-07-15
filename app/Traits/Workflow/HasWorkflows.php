<?php

namespace App\Traits\Workflow;


use App\Models\Workflow;
use App\Models\WorkflowExec;
use Illuminate\Support\Collection;

trait HasWorkflows
{
    /**
     * Renvoie l entree config du chemin de fichier le cas échéant
     * @return string
     */
    abstract public function getFilePath(): string;
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

    /**
     * Démarre les workflows actifs rattachés à cet objet
     */
    public function launchWorkflows() {
        // On récupère le type de cet objet
        $model_type = get_called_class();
        // On parcoure tous les workflows rattachés à cet objet
        foreach ($this->workflows() as $workflow) {
            $workflowexec = WorkflowExec::where('model_type', $model_type)
                ->where('model_id', $this->id)
                ->where('workflow_status_id', 4) // Traitement Terminé
                ->orWhere('workflow_status_id', 5) // Rejété
                ->first();
            if (! $workflowexec) {
                // On lance le Workflow pour cet objet s'il n'en a pas un en cours et non traité
                $workflow->launch($model_type,$this->id);
            }
        }
    }
}
