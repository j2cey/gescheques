<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class EnumType
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 *
 * @property string $name
 * @property string $code
 * @property string|null $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class EnumType extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    #region Eloquent Relationships

    public function enumvalues() {
        return $this->hasMany(EnumValue::class, 'enum_type_id');
    }

    #endregion

    #region Custom Functions - Create/Update

    public static function createNew($name, $code = null, $description = null): EnumType {
        $enumval = EnumType::create([
            'name' => $name,
            'code' => is_null($code) ? Str::slug('enum_type_' . (string)Str::orderedUuid(), "_" ) : $code,
            'description' => $description,
        ]);

        $enumval->save();

        return $enumval;
    }

    public function addValue($val, $description = null) : EnumType {
        $this->enumvalues()->save(
            new EnumValue(['val' => $val, 'description' => $description])
        );

        $this->refresh();

        return $this;
    }

    public function addValues($vals) : EnumType {

        foreach ($vals as $val) {
            $this->addValue($val[0], $val[1]);
        }

        return $this;
    }

    #endregion
}
