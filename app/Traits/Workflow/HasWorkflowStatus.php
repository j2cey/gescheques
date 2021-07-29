<?php

namespace App\Traits\Workflow;

use App\Models\WorkflowStatus;
use App\Models\WorkflowProcessStatus;

trait HasWorkflowStatus
{
    public function setWorkflowStatus($code, $save = true) {
        $status = WorkflowStatus::where('code', $code)->first();
        if ($status) {
            $this->workflowstatus()->associate($status);

            if ($save) $this->save();
        }
        return $this;
    }

    public function setWorkflowProcessStatus($code, $save = true) {
        $status = WorkflowProcessStatus::where('code', $code)->first();
        if ($status) {
            $this->workflowprocessstatus()->associate($status);

            if ($save) $this->save();
        }
        return $this;
    }

    public function isWorkflowStatusRejected() {
        $status_rejected = WorkflowStatus::where('code', "rejected")->first();
        return $this->workflowstatus->code === $status_rejected->code;
    }

    public function isWorkflowStatusExpired() {
        $status_rejected = WorkflowStatus::where('code', "rejected")->first();
        return $this->workflowstatus->code === $status_rejected->code;
    }
}
