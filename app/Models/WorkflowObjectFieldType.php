<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class WorkflowObjectFieldType
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
 * @property string $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WorkflowObjectFieldType extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;
}
