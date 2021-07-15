<?php

namespace App\Models;

use PHPUnit\Util\Json;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class WorkflowExecModel
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
class WorkflowExecModel extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;
}
