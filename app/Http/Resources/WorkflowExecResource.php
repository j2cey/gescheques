<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class WorkflowExecResource
 * @package App\Http\Resources
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property integer|null $current_step_id
 * @property integer|null $current_step_role_id
 * @property integer|null $workflow_id
 * @property string $model_type
 * @property integer|null $model_id
 *
 * @property bool $traitement_effectif
 *
 * @property string|null $motif_rejet
 */
class WorkflowExecResource extends JsonResource
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
            'uuid' => $this->uuid,
            'is_default' => $this->is_default,
            'tags' => $this->tags,
            'status_id' => $this->status_id,
            'current_step_id' => $this->current_step_id,

            'currentstep' => WorkflowStepResource::make($this->currentstep),
        ];
    }
}
