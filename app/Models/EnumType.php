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

    #region Validation Rules

    public static function defaultRules() {
        return [
            'name' => 'required',
            'enumvalues' => 'required',
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
            'name.required' => 'Prière de Renseigner le Nom',
            'enumvalues.required' => 'Au moins une valeur est requise',
        ];
    }

    #endregion

    #region Eloquent Relationships

    public function enumvalues() {
        return $this->hasMany(EnumValue::class, 'enum_type_id');
    }

    #endregion

    #region Custom Functions - Create/Update

    public static function createNew($name, $code = null, $description = null): EnumType {
        $enumtype = EnumType::create([
            'name' => $name,
            'code' => is_null($code) ? Str::slug('enum_type_' . (string)Str::orderedUuid(), "_" ) : $code,
            'description' => $description,
        ]);

        $enumtype->save();

        return $enumtype;
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
            $this->addValue($val['val'], $val['description']);
        }

        return $this;
    }

    public function syncValues($vals) : EnumType {

        $new_vals_ids = [];
        foreach ($vals as $val) {
            if (array_keys($val, 'id'))  {
                $new_vals_ids[] = $val['id'];
            }
        }
        // On supprime les valeurs qui ne sont plus dans la liaison
        $this->enumvalues()->whereNotIn('id', $new_vals_ids)->delete();
        /*
        foreach ($this->enumvalues()->whereNotIn('id', $new_vals_ids)->get() as $enumvalue) {
            $enumvalue->delete();
        }
        */

        return $this->addValues($vals);
    }

    #endregion
}
