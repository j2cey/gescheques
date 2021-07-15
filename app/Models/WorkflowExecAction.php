<?php

namespace App\Models;

use PHPUnit\Util\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class WorkflowExecAction
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property integer|null $workflow_exec_step_id
 * @property integer|null $workflow_action_id
 *
 * @property integer|null $user_id
 * @property string|null $username
 *
 * @property integer|null $posi
 *
 * @property string|null $model_type
 * @property integer|null $model_id
 * @property string|null $field_name
 * @property string|null $old_value
 * @property string|null $new_value
 * @property string|null $save_result
 *
 * @property Json $report
 * @property integer|null $workflow_status_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WorkflowExecAction extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;
    protected $guarded = [];

    #region Eloquent Relationships

    public function execstep() {
        return $this->belongsTo(WorkflowExecStep::class, 'workflow_exec_step_id');
    }

    /**
     * @return BelongsTo|WorkflowAction
     */
    public function action() {
        return $this->belongsTo(WorkflowAction::class, 'workflow_action_id');
    }

    public function execstatus() {
        return $this->belongsTo(WorkflowStatus::class, 'workflow_status_id');
    }

    #endregion

    #region Custom Functions

    public function process(Request $request) {
        $user = auth()->user();
        $input_vals = $request->all();

        $this->field_name = $this->action->objectfield->db_field_name;
        $this->new_value = isset($input_vals[$this->field_name]) ? $input_vals[$this->field_name] : "";

        $this->model_type = $this->execstep->exec->model_type;
        $this->model_id = $this->execstep->exec->model_id;
        $model = ($this->model_type)::where('id', $this->execstep->exec->model_id)->first();
        $this->old_value = null;

        if ($this->action->objectfield->objectfieldtype->code == "valuetype_boolean") {
            // Type Booleen
            $bool_val = ($this->new_value === "null" || $this->new_value === null || $this->new_value === "false" || $this->new_value === "") ? 0 : 1;
            $this->old_value = $model->{$this->field_name};
            $model->{$this->field_name} = $bool_val;
        } elseif ($this->action->objectfield->objectfieldtype->code == "valuetype_datetime") {
            // Type DateTime
            if (! empty($this->new_value)) {
                $this->old_value = $model->{$this->field_name};
                $model->{$this->field_name} = $this->new_value; // Carbon::parse($formInput[$action->objectfield->db_field_name]);
            }
        } elseif ($this->action->objectfield->objectfieldtype->code == "valuetype_image") {
            // Type Image
            $images_dir = $model->getFilePath();
            $this->old_value = $model->{$this->field_name};
            $model->{$this->field_name} = $model->verifyAndStoreImage($request, $this->field_name, $images_dir);
        } elseif ($this->action->objectfield->objectfieldtype->code == "valuetype_string") {
            // Type string
            $str_val = ($this->new_value === "null" || $this->new_value === null) ? "" : $this->new_value;
            $this->old_value = $model->{$this->field_name};
            $model->{$this->field_name} = $str_val;
        } elseif ($this->action->objectfield->objectfieldtype->code == "valuetype_integer") {
            // Type integer
            $str_val = ($this->new_value === "null" || $this->new_value === null || $this->new_value === null) ? 0 : (int)$this->new_value;
            $this->old_value = $model->{$this->field_name};
            $model->{$this->field_name} = $str_val;
        } else {
            $this->old_value = $model->{$this->field_name};
            $model->{$this->field_name} = $this->new_value;
        }

        $this->user_id = $user->getAuthIdentifier();
        $this->username = $user->name;

        $this->save_result = $model->save();

        $workflow_status = WorkflowStatus::where('code', "4")->first();
        $this->workflow_status_id = $workflow_status->id;

        return $this->save();
    }

    #endregion
}
