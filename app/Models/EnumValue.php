<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class EnumValue
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 *
 * @property string $val
 * @property string|null $description
 *
 * @property integer|null $enum_value_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class EnumValue extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;
    
    protected $guarded = [];

    #region Eloquent Relationships

    public function enumtype() {
        return $this->belongsTo(EnumType::class, 'enum_type_id');
    }

    #endregion
}
