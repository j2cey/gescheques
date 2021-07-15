<?php

namespace App\Http\Controllers;

use App\Http\Requests\CleanRequestTrait;
use App\Models\Workflow;
use App\Models\WorkflowExec;
use App\Models\WorkflowStatus;
use App\Models\WorkflowStep;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class WorkflowExecController extends Controller
{
    use CleanRequestTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request);
    }

    /**
     * Display the specified resource.
     *
     * @param WorkflowExec $workflowexec
     * @return \Illuminate\Http\Response
     */
    public function show(WorkflowExec $workflowexec)
    {
        $workflowexec = WorkflowExec::where('id', $workflowexec->id)
            ->first()
            ->load(['workflow','nextstep']);
        $currentstep = WorkflowStep::where('id', $workflowexec->current_step_id)
            ->first()
            ->load(['actions','actions.objectfield','actions.objectfield.objectfieldtype']);
        $actionvalues = ['rejected' => false, 'reject_comment' => "", 'current_step_role' => null];
        if ($workflowexec && $workflowexec->currentstep) {
            foreach ($workflowexec->currentstep->actions as $action) {
                if ($action->objectfield->valuetype_string) {
                    $actionvalues[$action->objectfield->db_field_name] = "";
                } elseif ($action->objectfield->valuetype_integer) {
                    $actionvalues[$action->objectfield->db_field_name] = "";
                } elseif ($action->objectfield->valuetype_boolean) {
                    $actionvalues[$action->objectfield->db_field_name] = "";
                } elseif ($action->objectfield->valuetype_datetime) {
                    $actionvalues[$action->objectfield->db_field_name] = "";
                } elseif ($action->objectfield->valuetype_image) {
                    $actionvalues[$action->objectfield->db_field_name] = "";
                } else {
                    $actionvalues[$action->objectfield->db_field_name] = "";
                }
            }
        }

        return ['exec' => $workflowexec, 'currentstep' => $currentstep, 'actionvalues' => $actionvalues];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param WorkflowExec $workflowexec
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkflowExec $workflowexec)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param WorkflowExec $workflowexec
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkflowExec $workflowexec)
    {
        $formInput = $request->all();

        // Validation
        $exec = WorkflowExec::with(['workflow','currentstep','currentstep.actions','currentstep.actions.objectfield'])->where('id', $workflowexec->id)->first();
        $validation_rules = [];
        $validation_messages = [];

        foreach ($exec->currentstep->actions as $action) {
            $action->setValidationRules();
            $validation_rules = array_merge($validation_rules, $action->validation_rules);
            $validation_messages = array_merge($validation_messages, $action->validation_messages);
        }

        $request->validate($validation_rules, $validation_messages);

        $workflowexec->process($request);

        $model_type = $exec->model_type;
        $model = $model_type::where('id', $exec->model_id)->first();

        $model->load(['workflowexec','workflowexec.currentprofile','workflowexec.currentstep','workflowexec.execsteps','workflowexec.execsteps.step','workflowexec.execsteps.execstatus']);

        return $model;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param WorkflowExec $workflowexec
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkflowExec $workflowexec)
    {
        //
    }
}
