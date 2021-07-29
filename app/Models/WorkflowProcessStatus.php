<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class WorkflowProcessStatus
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $name
 * @property string $code
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WorkflowProcessStatus extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;
    protected $guarded = [];

    #region Scopes

    public function scopeCoded($query, $code) {
        return $query
            ->where('code', $code)
            ;
    }

    #endregion
}
