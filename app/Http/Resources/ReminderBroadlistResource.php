<?php

namespace App\Http\Resources;

use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ReminderBroadlistResource
 * @package App\Http\Resources
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $title
 * @property string $msg
 * @property string|null $description
 *
 * @property integer $notification_interval
 * @property Carbon $notification_start_at
 * @property Carbon $notification_last_time
 * @property Carbon $notification_end_at
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ReminderBroadlistResource extends JsonResource
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
            'msg' => $this->msg,
            'notification_interval' => $this->notification_interval,
            'notification_start_at' => $this->notification_start_at,
            'notification_last_time' => $this->notification_last_time,
            'notification_end_at' => $this->notification_end_at,

            'description' => $this->description,

            'roles' => RoleResource::collection($this->roles),
            'users' => User::collection($this->users),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
