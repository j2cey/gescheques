<?php

namespace App\Models;

use PHPUnit\Util\Json;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class WorkflowExecModelStep
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
 * @property string|null $model_type
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
class WorkflowExecModelStep extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;
    // TODO: définir ICI la fonction qui retourne le tableau actionvalues (destiné notamment à être utilisé dans le formulaire d'exécution d'actions)
    protected $guarded = [];

    #region Eloquent Relationships

    public function exec()
    {
        return $this->belongsTo(WorkflowExec::class, 'workflow_exec_id');
    }

    public function step()
    {
        return $this->belongsTo(WorkflowStep::class, 'workflow_step_id');
    }

    public function model() {
        $model_type = $this->model_type;
        return $model_type::where('id', $this->model_id)->first();
    }

    public function actions()
    {
        //return $this->belongsToMany('App\Models\Role', 'role_user', 'user_id', 'role_id');
        return $this->belongsToMany(WorkflowAction::class, 'model_step_actions', 'workflow_exec_model_step_id', 'workflow_action_id')
            ->wherePivot('traitement_effectif', 0)
            ->withPivot('traitement_effectif')
            ->withPivot('rejete')
            ->withTimestamps();
    }

    public function execstatus()
    {
        return $this->belongsTo(WorkflowStatus::class, 'workflow_status_id');
    }

    #endregion

    #region Custom Functions

    public function Traiter() {
        $nb_actions_non_traitees = DB::table('model_step_actions')
            ->where('workflow_exec_model_step_id', $this->id)
            ->where('traitement_effectif', 0)
            ->count('id');
        if ($nb_actions_non_traitees === 0) {
            // si toutes les actions sont exécutées, on marque l'étape traitée
            $affected = $this->update([
                'traitement_effectif' => 1,
            ]);
            // et on traite l'exécution principale
            $this->exec->Traiter();
        }
    }

    #endregion
}
