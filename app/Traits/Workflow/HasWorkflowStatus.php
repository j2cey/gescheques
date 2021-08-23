<?php

namespace App\Traits\Workflow;

use App\Models\WorkflowStatus;
use App\Models\WorkflowProcessStatus;

trait HasWorkflowStatus
{

    #region WorkflowProcessStatus

    public function setWorkflowProcessStatus($code, $save = true) {
        $status = WorkflowProcessStatus::where('code', $code)->first();
        if ($status) {
            $this->workflowprocessstatus()->associate($status);

            if ($save) $this->save();
        }
        return $this;
    }

    public function setWorkflowProcessStatusPending($save = true) {
        return $this->setWorkflowProcessStatus(WorkflowProcessStatus::CODE_PENDING, $save);
    }
    public function isWorkflowProcessStatusPending() {
        return $this->workflowprocessstatus->code === WorkflowProcessStatus::CODE_PENDING;
    }

    public function setWorkflowProcessStatusProcessing($save = true) {
        return $this->setWorkflowProcessStatus(WorkflowProcessStatus::CODE_PROCESSING, $save);
    }
    public function isWorkflowProcessStatusProcessing() {
        return $this->workflowprocessstatus->code === WorkflowProcessStatus::CODE_PROCESSING;
    }

    public function setWorkflowProcessStatusProcessed($save = true) {
        return $this->setWorkflowProcessStatus(WorkflowProcessStatus::CODE_PROCESSED, $save);
    }
    public function isWorkflowProcessStatusProcessed() {
        return $this->workflowprocessstatus->code === WorkflowProcessStatus::CODE_PROCESSED;
    }

    public function setWorkflowProcessStatusFailed($save = true) {
        return $this->setWorkflowProcessStatus(WorkflowProcessStatus::CODE_FAILED, $save);
    }
    public function isWorkflowProcessStatusFailed() {
        return $this->workflowprocessstatus->code === WorkflowProcessStatus::CODE_FAILED;
    }

    #endregion

    #region WorkflowStatus

    public function setWorkflowStatus($code, $save = true) {
        $status = WorkflowStatus::where('code', $code)->first();
        if ($status) {
            $this->workflowstatus()->associate($status);

            if ($save) $this->save();
        }
        return $this;
    }

    public function setWorkflowStatusNew($save = true) {
        return $this->setWorkflowStatus(WorkflowStatus::CODE_NEW, $save);
    }
    public function isWorkflowStatusNew() {
        return $this->workflowstatus->code === WorkflowStatus::CODE_NEW;
    }

    public function setWorkflowStatusPending($save = true) {
        return $this->setWorkflowStatus(WorkflowStatus::CODE_PENDING, $save);
    }
    public function isWorkflowStatusPending() {
        return $this->workflowstatus->code === WorkflowStatus::CODE_PENDING;
    }

    public function setWorkflowStatusProcessing($save = true) {
        return $this->setWorkflowStatus(WorkflowStatus::CODE_PROCESSING, $save);
    }
    public function isWorkflowStatusProcessing() {
        return $this->workflowstatus->code === WorkflowStatus::CODE_PROCESSING;
    }

    public function setWorkflowStatusValidated($save = true) {
        return $this->setWorkflowStatus(WorkflowStatus::CODE_VALIDATED, $save);
    }
    public function isWorkflowStatusValidated() {
        return $this->workflowstatus->code === WorkflowStatus::CODE_VALIDATED;
    }

    public function setWorkflowStatusRejected($save = true) {
        return $this->setWorkflowStatus(WorkflowStatus::CODE_REJECTED, $save);
    }
    public function isWorkflowStatusRejected() {
        return $this->workflowstatus->code === WorkflowStatus::CODE_REJECTED;
    }

    public function setWorkflowStatusExpired($save = true) {
        return $this->setWorkflowStatus(WorkflowStatus::CODE_EXPIRED, $save);
    }
    public function isWorkflowStatusExpired() {
        return $this->workflowstatus->code === WorkflowStatus::CODE_EXPIRED;
    }

    #endregion
}
