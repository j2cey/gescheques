<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ReminderCriterionResource
 * @package App\Http\Resources
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 *
 * @property string $title
 * @property boolean $is_start_criterion
 * @property boolean $is_stop_criterion
 *
 * @property string $object_field
 * @property string $criterion_value
 * @property string|null $description
 *
 * @property integer|null $reminder_criterion_type_id
 * @property integer|null $reminder_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ReminderCriterionResource extends JsonResource
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
            'is_start_criterion' => $this->is_start_criterion,
            'is_stop_criterion' => $this->is_stop_criterion,
            'modelattribute' => ModelAttributeResource::make($this->modelattribute),
            'criterion_value' => $this->criterion_value,

            'criteriontype' => ReminderCriterionTypeResource::make($this->criteriontype),

            'reminder_id' => $this->reminder_id,
            //'reminder' => ReminderResource::make($this->reminder),

            'description' => $this->description,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
