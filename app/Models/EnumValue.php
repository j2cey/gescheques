<?php

namespace App\Models;

use Illuminate\Support\Str;
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

    #region Validation Rules

    public static function defaultRules() {
        return [
            'val' => 'required',
        ];
    }
    public static function createRules() {
        return array_merge(self::defaultRules(), [

        ]);
    }
    public static function updateRules($model) {
        return array_merge(self::defaultRules(), [

        ]);
    }
    public static function messagesRules() {
        return [
            'val.required' => 'Prière de Renseigner la Valeur',
        ];
    }

    #endregion

    #region Eloquent Relationships

    public function enumtype() {
        return $this->belongsTo(EnumType::class, 'enum_type_id');
    }

    #endregion

    #region Custom Functions - Create/Update

    public static function createNew(EnumType $enumtype, $val, $description = null): EnumValue {
        $enumval = EnumValue::create([
            'val' => $val,
            'description' => $description,
        ]);

        $enumval->enumtype()->associate($enumtype);
        $enumval->save();

        return $enumval;
    }

    #endregion
}
