<?php

namespace App\Http\Resources;

use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ReminderObjectResource
 * @package App\Http\Resources
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property integer|null $reminder_id
 *
 * @property string|null $title
 * @property integer $model_id
 *
 * @property string|null $description
 *
 * @property Carbon $notification_start_at
 * @property Carbon $notification_last_time
 * @property Carbon $notification_end_at
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ReminderObjectResource extends JsonResource
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
            'is_default' => $this->is_default,
            'tags' => $this->tags,
            'status' => StatusResource::make($this->status),

            'title' => $this->title,
            'model_id' => $this->model_id,

            'reminder' => ReminderResource::make($this->reminder),
            'broadcastlists' => ReminderBroadlistResource::collection($this->broadcastlists),

            'reminder_id' => $this->reminder_id,
            'description' => $this->description,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
