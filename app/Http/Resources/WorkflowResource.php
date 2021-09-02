<?php

namespace App\Http\Resources;

use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class WorkflowResource
 * @package App\Http\Resources
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $titre
 * @property string $description
 * @property string|null $model_type
 *
 * @property integer|null $user_id
 * @property integer|null $workflow_object_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WorkflowResource extends JsonResource
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

            'titre' => $this->titre,
            'description' => $this->description,
            'model_type' => $this->model_type,

            'object' => WorkflowObjectResource::make($this->object),
            'steps' => WorkflowStepResource::collection($this->steps),
        ];
    }
}
