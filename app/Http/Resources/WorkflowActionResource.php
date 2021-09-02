<?php

namespace App\Http\Resources;

use Illuminate\Support\Carbon;
use App\Models\WorkflowTreatmentType;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class WorkflowActionResource
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
 * @property string $code
 * @property string $description
 *
 * @property integer|null $workflow_step_id
 * @property integer|null $workflow_action_type_id
 * @property integer|null $workflow_treatment_type_id
 * @property integer|null $enum_type_id
 *
 * @property integer|null $workflow_object_field_id
 *
 * @property boolean $field_required
 * @property string|null $field_required_msg
 *
 * @property boolean $field_required_without
 * @property string|null $field_required_without_msg
 *
 * @property boolean $field_required_with
 * @property string|null $field_required_with_msg
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WorkflowActionResource extends JsonResource
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

            'code' => $this->code,
            'titre' => $this->titre,
            'description' => $this->description,

            'workflow_step_id' => $this->workflow_step_id,

            'actiontype' => WorkflowActionTypeResource::make($this->actiontype),
            'treatmenttype' => WorkflowTreatmentTypeResource::make($this->treatmenttype),
            'enumtype' => EnumTypeResource::make($this->enumtype),
            'mimetypes' => MimeTypeResource::collection($this->mimetypes),

            'actionsrequiredwithout' => WorkflowActionResource::collection($this->actionsrequiredwithout),
            'actionsrequiredwith' => WorkflowActionResource::collection($this->actionsrequiredwith),
        ];
    }
}
