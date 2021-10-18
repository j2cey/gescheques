<?php

namespace App\Http\Resources;

use App\Models\Status;
use App\Models\Reminder;
use App\Models\ModelType;
use Illuminate\Support\Carbon;
use App\Models\ReminderBroadlist;
use App\Models\ReminderCriterion;
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
 *
 * @property Reminder $reminder
 * @property ReminderCriterion $defaultcriterionduration
 * @property ReminderBroadlist $defaultbroadlist
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

            'status' => StatusResource::make($this->status),

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

            'reminder' => ReminderResource::make($this->reminder),
            'reminder_status' => $this->reminder ? $this->reminder->status : StatusResource::make(Status::where('code', "active")->first()),
            'reminder_modeltype' => $this->reminder ? $this->reminder->modeltype : ModelTypeResource::make(ModelType::where('code', "AppModelsWorkflowExec")->first()),
            'reminder_title' => $this->reminder ? $this->reminder->title : '',
            'reminder_description' => $this->reminder ? $this->reminder->description : '',
            'reminder_duration' => $this->defaultcriterionduration ? $this->defaultcriterionduration->criterion_value : '',
            'reminder_msg' => $this->defaultbroadlist ? $this->defaultbroadlist->msg : '',
            'reminder_notification_interval' => $this->defaultbroadlist ? $this->defaultbroadlist->notification_interval : '',
        ];
    }

    private function getReminderDuration(Reminder $reminder = null) {
        if (! $reminder || is_null($reminder)) {
            return "";
        } else {
            $step_duration = $reminder->criteria()->where('criterion_role', "step_duration")->first();
            if ($step_duration) {
                return $step_duration->criterion_value;
            } else {
                return "";
            }
        }
    }
    private function getReminderMsg(Reminder $reminder = null) {
        if (! $reminder || is_null($reminder)) {
            return "";
        } else {
            $step_reminder_broadlist = $reminder->broadcastlists()->where('broadlist_role', "step_reminder_broadlist")->first();
            if ($step_reminder_broadlist) {
                return $step_reminder_broadlist->msg;
            } else {
                return "";
            }
        }
    }
    private function getReminderNotificationInterval(Reminder $reminder = null) {
        if (! $reminder || is_null($reminder)) {
            return "";
        } else {
            $step_reminder_broadlist = $reminder->broadcastlists()->where('broadlist_role', "step_reminder_broadlist")->first();
            if ($step_reminder_broadlist) {
                return $step_reminder_broadlist->notification_interval;
            } else {
                return "";
            }
        }
    }
    private function getReminderRoles(Reminder $reminder = null) {
        if (! $reminder || is_null($reminder)) {
            return "";
        } else {
            $step_reminder_broadlist = $reminder->broadcastlists()->where('broadlist_role', "step_reminder_broadlist")->first();
            if ($step_reminder_broadlist) {
                return RoleResource::collection($step_reminder_broadlist->roles);
            } else {
                return "";
            }
        }
    }
    private function getReminderUsers(Reminder $reminder = null) {
        if (! $reminder || is_null($reminder)) {
            return "";
        } else {
            $step_reminder_broadlist = $reminder->broadcastlists()->where('broadlist_role', "step_reminder_broadlist")->first();
            if ($step_reminder_broadlist) {
                return UserResource::collection($step_reminder_broadlist->users);
            } else {
                return "";
            }
        }
    }
}
