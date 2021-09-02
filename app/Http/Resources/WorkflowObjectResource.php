<?php

namespace App\Http\Resources;

use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class WorkflowObjectResource
 * @package App\Http\Resources
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $model_type
 * @property string $model_title
 *
 * @property integer|null $workflow_object_parent_id
 * @property string|null $ref_field
 *
 * @property string $route_raw
 * @property string $route_show
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WorkflowObjectResource extends JsonResource
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
            'uuid' => $this->uuid,
            'status' => StatusResource::make($this->status),

            'model_type' => $this->model_type,
            'model_title' => $this->model_title,
            'ref_field' => $this->ref_field,
            'route_raw' => $this->route_raw,
            'route_show' => $this->route_show,
        ];
    }
}
