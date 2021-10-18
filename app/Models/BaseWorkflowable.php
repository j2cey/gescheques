<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use App\Traits\Workflow\HasWorkflows;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class BaseWorkflowable
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
abstract class BaseWorkflowable extends BaseModel
{
    use HasFactory, HasWorkflows;

    public function workflowexec() {
        $model_type = get_called_class(); // 'App\Models\Cheque'
        return $this->hasOne(WorkflowExec::class, 'model_id')
            ->where('model_type', $model_type)
            ->latest();
        //->whereNotNull('current_step_id');
    }

    #endregion

    public static function boot(){
        parent::boot();

        // Après création
        self::created(function($model){
            // Launch workflows
            $model->launchWorkflows();

            // Launch actions
            //$model->launchWorkflowActions();
        });
    }
}
