<?php

namespace App\Listeners;

use App\Models\User;
use App\Models\WorkflowExec;
use App\Models\WorkflowStep;
use App\Mail\WorkflowStepNext;
use Illuminate\Support\Facades\Mail;
use App\Events\WorkflowStepCompleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;

class SendNextWorkflowStepEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  WorkflowStepCompleted  $event
     * @return void
     */
    public function handle(WorkflowStepCompleted $event)
    {
        $users_to_notify = $this->getApproversToNotify($event->exec, $event->nextStep);
        $users_to_notify = $this->getUsersMerged($users_to_notify, $this->getOthersToNotify($event->exec, $event->nextStep));

        $this->notifyRaw($users_to_notify, $event->exec, $event->nextStep);
    }

    private function notifyRaw($users, WorkflowExec $exec, WorkflowStep $step) {
        foreach ($users as $user) {
            if ($user->email) {
                if (filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
                    Mail::to($user->email)
                        ->send(new WorkflowStepNext($exec, $step));
                }
            }
        }
    }

    /**
     * @param WorkflowExec $exec
     * @param WorkflowStep $step
     * @return User[]
     */
    private function getApproversToNotify(WorkflowExec $exec, WorkflowStep $step) {
        if ($step->notify_to_approvers) {
            return User::role($exec->currentapprovers->pluck('name'))->get();
        } else {
            return [];
        }
    }

    /**
     * @param WorkflowExec $exec
     * @param WorkflowStep $step
     * @return User[]
     */
    private function getOthersToNotify(WorkflowExec $exec, WorkflowStep $step) {
        if ($step->notify_to_others) {
            return $step->otherstonotify;
        } else {
            return [];
        }
    }

    private function getUsersMerged($users_list1, $users_list2) {
        $users_merged = [];
        foreach ($users_list1 as $user_1) {
            $users_merged[] = $user_1;
        }

        foreach ($users_list2 as $user_2) {
            $found = false;
            foreach ($users_merged as $user_m) {
                if ($user_m->id === $user_2->id) {
                    $found = true;
                    break;
                }
            }
            if ( ! $found ) {
                $users_merged[] = $user_2;
            }
        }
        return $users_merged;
    }
}
