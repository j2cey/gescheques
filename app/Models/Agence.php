<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Role;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Agence
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string|null $Location
 * @property string|null $LocationName
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Agence extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $table = 'agences';

    #region Eloquent Relationships

    public function cheques() {
        return $this->hasMany(Agence::class, 'agence_id');
    }

    #endregion

    #region Custom functions

    public function createRole() {
        $role = Role::where('name', $this->LocationName)->first();
        if (! $role) {
            Role::create([
                    'name' => $this->LocationName,
                    'description' => $this->LocationName
                ]
            );
        }
    }

    #endregion

    public static function boot(){
        parent::boot();

        // Après enregistrement
        self::saved(function($model){
            $model->createRole();
        });
    }
}
