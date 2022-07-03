<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ReminderResource
 * @package App\Http\Resources
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 *
 * @property string $title
 * @property string $model_type_id
 * @property string|null $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ReminderResource extends JsonResource
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
            'uuid' => $this->uuid,
            'is_default' => $this->is_default,
            'tags' => $this->tags,
            'status' => StatusResource::make($this->status),

            'title' => $this->title,
            'modeltype' => ModelTypeResource::make($this->modeltype),
            'model_type_id' => $this->model_type_id,
            'description' => $this->description,

            'criteria' => ReminderCriterionResource::collection($this->criteria),
            'broadcastlists' => ReminderBroadlistResource::collection($this->broadcastlists),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
