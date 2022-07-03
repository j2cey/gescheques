<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ModelAttribute
 * @package App\Models
 *
 * @property integer $id
 * @property string $code
 *
 * @property string $label
 * @property string $type
 * @property integer|null $model_type_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ModelAttribute extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function modeltype() {
        return $this->belongsTo(ModelType::class, 'model_type_id');
    }
}
