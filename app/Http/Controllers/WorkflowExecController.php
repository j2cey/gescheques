<?php

namespace App\Http\Controllers;

use App\Models\Workflow;
use App\Models\WorkflowExec;
use App\Models\WorkflowStep;
use Illuminate\Http\Request;
use App\Models\WorkflowStatus;
use Illuminate\Support\Carbon;
use App\Models\WorkflowTreatmentType;
use App\Http\Requests\CleanRequestTrait;
use App\Http\Requests\WorkflowExec\UpdateWorkflowExecRequest;

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
     * @return array|\Illuminate\Http\Response
     */
    public function show(WorkflowExec $workflowexec)
    {
        $workflowexec = WorkflowExec::where('id', $workflowexec->id)
            ->first()
            ->load(['workflow',
                //'nextstep',
                'lastexecstep','lastexecstep.effectiveapprovers']);
        $currentstep = WorkflowStep::where('id', $workflowexec->current_step_id)
            ->first()
            ->load(['actions',

                'transitionpassstep',
                'transitionrejectstep',
                'transitionexpirestep',

                'actionsreject',
                'actionsreject.actiontype',
                'actionsreject.enumtype',
                'actionsreject.enumtype.enumvalues',
                'actions.actiontype',
                'actionspass',
                'actionspass.actiontype',
                'actionspass.enumtype',
                'actionspass.enumtype.enumvalues']);
        $actionvalues = [
            'rejected' => false,
            'reject_comment' => "",
            'current_step_role' => null,
            'role_dynamic_selection' => "role_dynamic_selected",
            'treatment_type' => WorkflowTreatmentType::getPassType()
        ];
        $rejectactionvalues = [
            'rejected' => true,
            'reject_comment' => "",
            'current_step_role' => null,
            'role_dynamic_selection' => "role_dynamic_selected",
            'treatment_type' => WorkflowTreatmentType::getRejectType()
        ];
        $enumvalues = [];

        if ($workflowexec && $workflowexec->currentstep) {
            foreach ($workflowexec->currentstep->actionspass as $action) {
                $actionvalues = $action->addToArrayAssoc($actionvalues);
            }
        }

        if ($workflowexec && $workflowexec->currentstep) {
            foreach ($workflowexec->currentstep->actionsreject as $action) {
                $rejectactionvalues = $action->addToArrayAssoc($rejectactionvalues);
            }
        }

        if ($workflowexec && $workflowexec->currentstep) {
            foreach ($workflowexec->currentstep->actions as $action) {
                $enumvalues = $action->addToEnumTypeList($enumvalues);
            }
        }

        return ['exec' => $workflowexec, 'currentstep' => $currentstep, 'actionvalues' => $actionvalues, 'rejectactionvalues' => $rejectactionvalues, 'enumvalues' => $enumvalues];
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
     * @param UpdateWorkflowExecRequest $request
     * @param WorkflowExec $workflowexec
     * @return WorkflowExec
     */
    public function update(UpdateWorkflowExecRequest $request, WorkflowExec $workflowexec)
    {
        $formInput = $request->all();

        $workflowexec->process($request);

        //$model_type = $exec->model_type;
        //$model = $model_type::where('id', $exec->model_id)->first();

        //$model->load(['workflowexec','workflowexec.currentprofile','workflowexec.currentstep','workflowexec.execsteps','workflowexec.execsteps.step','workflowexec.execsteps.workflowstatus','workflowexec.execsteps.workflowprocessstatus']);

        $workflowexec->load([
            'prevstep',
            //'nextstep',
            'execsteps',
            'execsteps.step',
            'currentapprovers',
            'execsteps.effectiveapprovers',
            'execsteps.execactions',
            'execsteps.execactions.file',
            'execsteps.execactions.file.mimetype',
            'execsteps.execactions.workflowprocessstatus',

            'currentstep',
            'currentstep.type',
            'currentstep.actions',
            'currentstep.transitionpassstep',
            'currentstep.transitionrejectstep',
            'currentstep.transitionexpirestep',

            'workflowstatus','workflowprocessstatus',
            'execsteps.workflowstatus','execsteps.workflowprocessstatus'
        ]);

        return $workflowexec;
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
