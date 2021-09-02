<?php

namespace App\Http\Resources;

use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class WorkflowStepTransitionResource
 * @package App\Http\Resources
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $code
 *
 * @property integer|null $workflow_step_source_id
 * @property integer|null $workflow_step_destination_id
 * @property integer|null $workflow_treatment_type_id
 *
 * @property string|null $flowchart_source_position
 * @property string|null $flowchart_destination_position
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WorkflowStepTransitionResource extends JsonResource
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
            'code' => $this->code,

            'status' => StatusResource::make($this->status),

            'source' => WorkflowStepResource::make($this->source),
            'treatmenttype' => WorkflowTreatmentTypeResource::make($this->treatmenttype),
            'destination' => WorkflowStepResource::make($this->destination),
        ];
    }
}
