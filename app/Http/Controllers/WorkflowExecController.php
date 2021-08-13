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
     * @return \Illuminate\Http\Response
     */
    public function show(WorkflowExec $workflowexec)
    {
        $workflowexec = WorkflowExec::where('id', $workflowexec->id)
            ->first()
            ->load(['workflow','nextstep','lastexecstep','lastexecstep.effectiverole']);
        $currentstep = WorkflowStep::where('id', $workflowexec->current_step_id)
            ->first()
            ->load(['actions',

                'validatednextstep',
                'rejectednextstep',
                'expirednextstep',

                'rejectionactions',
                'rejectionactions.actiontype',
                'rejectionactions.enumtype',
                'rejectionactions.enumtype.enumvalues',
                'actions.actiontype',
                'validationactions',
                'validationactions.actiontype',
                'validationactions.enumtype',
                'validationactions.enumtype.enumvalues']);
        $actionvalues = [
            'rejected' => false,
            'reject_comment' => "",
            'current_step_role' => null,
            'role_dynamic_selection' => "role_dynamic_selected",
            'treatment_type' => WorkflowTreatmentType::getValidationType()
        ];
        $rejectactionvalues = [
            'rejected' => true,
            'reject_comment' => "",
            'current_step_role' => null,
            'role_dynamic_selection' => "role_dynamic_selected",
            'treatment_type' => WorkflowTreatmentType::getRejectionType()
        ];
        $enumvalues = [];

        if ($workflowexec && $workflowexec->currentstep) {
            foreach ($workflowexec->currentstep->validationactions as $action) {
                $actionvalues = $action->addToArrayAssoc($actionvalues);
            }
        }

        if ($workflowexec && $workflowexec->currentstep) {
            foreach ($workflowexec->currentstep->rejectionactions as $action) {
                $rejectactionvalues = $action->addToArrayAssoc($rejectactionvalues);
            }
        }

        if ($workflowexec && $workflowexec->currentstep) {
            foreach ($workflowexec->currentstep->actions as $action) {
                $enumvalues = $action->addToEnumTypeList($enumvalues);
            }
        }

        /*if ($workflowexec && $workflowexec->currentstep) {
            $action = $workflowexec->currentstep->rejectaction;
            if ($action) {
                $enumvalues = $action->addToEnumTypeList($enumvalues);
            }
        }*/

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
            'nextstep',
            'execsteps',
            'execsteps.step',
            'currentprofile',
            'execsteps.effectiverole',
            'execsteps.execactions',
            'execsteps.execactions.file',
            'execsteps.execactions.file.mimetype',
            'execsteps.execactions.workflowprocessstatus',

            'currentstep',
            'currentstep.actions',
            'currentstep.validatednextstep',
            'currentstep.rejectednextstep',
            'currentstep.expirednextstep',

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
