<?php

namespace App\Mail;

use App\Models\WorkflowExec;
use App\Models\WorkflowStep;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WorkflowStepNext extends Mailable
{
    use Queueable, SerializesModels;

    public $step;
    public $step_url;

    /**
     * Create a new message instance.
     *
     * @param WorkflowExec $exec
     * @param WorkflowStep $next_step
     */
    public function __construct(WorkflowExec $exec, WorkflowStep $next_step)
    {
        $this->step = $next_step;
        $model_type = $exec->model_type;
        $model_obj = $model_type::where('id', $exec->model_id)->first();
        if ($model_obj) {
            $this->step_url = route($this->step->workflow->object->route_show, $model_obj->uuid);
        } else {
            $this->step_url = "";
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->step->workflow->titre)
            ->markdown('emails.workflows.steps.next');
    }
}
