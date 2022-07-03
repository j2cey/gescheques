<?php

namespace App\Http\Resources;

use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ModelAttributeResource
 * @package App\Http\Resources
 *
 * @property integer $id
 *
 * @property string $label
 * @property string $type
 * @property integer|null $model_type_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ModelAttributeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,

            'label' => $this->label,
            'type' => $this->type,
            'model_type_id' => $this->model_type_id,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
