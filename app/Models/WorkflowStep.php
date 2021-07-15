<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class WorkflowStep
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
 * @property integer $posi
 * @property string|null $description
 *
 * @property integer|null $workflow_id
 * @property integer|null $role_id
 * @property string $code
 *
 * @property boolean $role_static
 * @property boolean $role_dynamic
 * @property string|null $role_dynamic_label
 *
 * @property integer|null $validated_nextstep_id
 * @property integer|null $rejected_nextstep_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WorkflowStep extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    #region Eloquent Relationships

    public function workflow() {
        return $this->belongsTo(Workflow::class);
    }

    public function profile() {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function actions() {
        return $this->hasMany(WorkflowAction::class, 'workflow_step_id');
    }

    public function validatednextstep() {
        return $this->belongsTo(WorkflowStep::class, 'validated_nextstep_id');
    }

    public function rejectednextstep() {
        return $this->belongsTo(WorkflowStep::class, 'rejected_nextstep_id');
    }

    #endregion

    #region Validation Rules

    public static function defaultRules() {
        return [
            'titre' => 'required',
            'profile' => 'required',
        ];
    }
    public static function createRules() {
        return array_merge(self::defaultRules(), [

        ]);
    }
    public static function updateRules($model) {
        return array_merge(self::defaultRules(), [
            'actions' => 'required',
        ]);
    }

    #endregion

    #region Scopes

    public function scopeCoded($query, $code) {
        return $query
            ->where('code', $code)
            ;
    }

    #endregion

    #region Custom Functions

    /**
     * @return WorkflowExecStep
     */
    public function launch($exec) : WorkflowExecStep {
        $execstep = WorkflowExecStep::where('workflow_exec_id', $exec->id)
            ->where('workflow_step_id', $this->id)
            ->first();
        if ($execstep) {
            return $execstep;
        } else {
            return WorkflowExecStep::create([
                'workflow_exec_id' => $exec->id,
                'workflow_step_id' => $this->id,
                'posi' => WorkflowExecStep::where('workflow_exec_id', $exec->id)->count() + 1,
                'report' => json_encode([]),
            ]);
        }
    }

    /**
     * Traitement de l étape
     *
     */
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

    public function updateModel($model) {
        $values_to_update = [];
        if (isset($model->workflow_currentstep_titre)) {
            $values_to_update['workflow_currentstep_titre'] = $this->titre;
        }
        if (isset($model->workflow_currentstep_code)) {
            $values_to_update['workflow_currentstep_code'] = $this->code;
        }

        if ( count($values_to_update) > 0 ) {
            $model->update($values_to_update);
            return true;
        } else {
            return false;
        }
    }

    #endregion

    public static function boot(){
        parent::boot();

    }
}
