<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ModelTypeResource
 * @package App\Http\Resources
 *
 * @property integer $id
 * @property string $code
 *
 * @property string $label
 * @property string $namespace
 * @property string $relative_type
 * @property string $full_type
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ModelTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'code' => $this->code,

            'label' => $this->label,
            'namespace' => $this->namespace,
            'relative_type' => $this->relative_type,
            'full_type' => $this->full_type,

            'modelattributes' => ModelAttributeResource::collection($this->modelattributes),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
