<?php

namespace App\Http\Resources;

use Illuminate\Support\Carbon;
use App\Models\WorkflowStepTransition;
use App\Http\Resources\User as UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class WorkflowStepResource
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
 * @property string $titre
 * @property integer $posi
 * @property string|null $description
 *
 * @property integer|null $workflow_id
 *
 * @property boolean $role_static
 *
 * @property boolean $role_dynamic
 * @property string|null $role_dynamic_label
 * @property string|null $role_dynamic_previous_label
 *
 * @property boolean $role_previous
 *
 * @property boolean $can_expire
 * @property integer| $expire_hours
 * @property integer| $expire_days
 *
 * @property boolean $notify_to_approvers
 * @property boolean $notify_to_others
 *
 * @property integer|null $step_parent_id
 * @property integer|null $workflow_step_type_id
 *
 * @property string|null $stylingClass
 * @property integer|null $flowchart_position_x
 * @property integer|null $flowchart_position_y
 * @property integer|null $flowchart_size_width
 * @property integer|null $flowchart_size_height
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WorkflowStepResource extends JsonResource
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

            'code' => $this->code,
            'titre' => $this->titre,
            'posi' => $this->posi,
            'description' => $this->description,

            'workflow_id' => $this->workflow_id,

            'role_static' => $this->role_static,

            'role_dynamic' => $this->role_dynamic,
            'role_dynamic_label' => $this->role_dynamic_label,
            'role_dynamic_previous_label' => $this->role_dynamic_previous_label,

            'role_previous' => $this->role_previous,

            'can_expire' => $this->can_expire,
            'expire_hours' => $this->expire_hours,
            'expire_days' => $this->expire_days,

            'notify_to_approvers' => $this->notify_to_approvers,
            'notify_to_others' => $this->notify_to_others,

            'stylingClass' => $this->stylingClass,
            'flowchart_position_x' => $this->flowchart_position_x,
            'flowchart_position_y' => $this->flowchart_position_y,
            'flowchart_size_width' => $this->flowchart_size_width,
            'flowchart_size_height' => $this->flowchart_size_height,

            'actions' => WorkflowActionResource::collection($this->actions),
            'staticapprovers' => RoleResource::collection($this->staticapprovers),
            'stepparent' => WorkflowStepResource::make($this->stepparent),

            'actionspass' => WorkflowActionResource::collection($this->actionspass),
            'actionsreject' => WorkflowActionResource::collection($this->actionsreject),
            'actionsexpire' => WorkflowActionResource::collection($this->actionsexpire),

            'transitionpassstep' => WorkflowStepTransitionResource::make($this->transitionpassstep),
            'transitionrejectstep' => WorkflowStepTransitionResource::make($this->transitionrejectstep),
            'transitionexpirestep' => WorkflowStepTransitionResource::make($this->transitionexpirestep),

            'otherstonotify' => UserResource::collection($this->otherstonotify),
        ];
    }
}
