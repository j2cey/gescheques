<?php

namespace App\Http\Controllers;

use App\Models\WorkflowStep;
use Illuminate\Http\Response;
use App\Models\WorkflowAction;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Resources\WorkflowStepResource;
use App\Http\Resources\WorkflowActionResource;
use App\Http\Requests\WorkflowAction\CreateWorkflowActionRequest;
use App\Http\Requests\WorkflowAction\UpdateWorkflowActionRequest;

class WorkflowActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return WorkflowAction[]|Collection
     */
    public function index()
    {
        $workflowactions = WorkflowAction::all();
        $workflowactions->load(['type','objectfield','fieldsrequiredwithout','fieldsrequiredwith','mimetypes']);

        return $workflowactions;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateWorkflowActionRequest $request
     * @return WorkflowStepResource|array|Response
     */
    public function store(CreateWorkflowActionRequest $request)
    {
        $user = auth()->user();
        $formInput = $request->all();

        $workflowstep = WorkflowStep::where('id', $formInput['workflow_step_id'])->first();

        $new_workflowaction = WorkflowAction::createNew($formInput['titre'],$formInput['description'])
            ->setStep($workflowstep, true)
            ->setActionType($formInput['actiontype'], true)
            ->setTreatmentType($formInput['treatmenttype'], true)
            ->setMimeTypes($formInput['mimetypes'], true)
            ->setRequired($formInput['field_required'],$formInput['field_required_msg'], true)
            ->setRequiredWithout($formInput['field_required_without'],$formInput['actionsrequiredwithout'], $formInput['field_required_without_msg'], true)
            ->setRequiredWith($formInput['field_required_with'],$formInput['actionsrequiredwith'], $formInput['field_required_with_msg'], true)
        ;

        return [
            'step' => new WorkflowStepResource($workflowstep->refresh()),
            'action' => new WorkflowActionResource($new_workflowaction)
        ];

        //return $new_workflowaction->load(['workflowstep','actiontype','actionsrequiredwithout','actionsrequiredwith','mimetypes']);
    }

    /**
     * Display the specified resource.
     *
     * @param WorkflowAction $workflowaction
     * @return Response
     */
    public function show(WorkflowAction $workflowaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param WorkflowAction $workflowaction
     * @return Response
     */
    public function edit(WorkflowAction $workflowaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateWorkflowActionRequest $request
     * @param WorkflowAction $workflowaction
     * @return WorkflowAction|array
     */
    public function update(UpdateWorkflowActionRequest $request, WorkflowAction $workflowaction)
    {
        $user = auth()->user();
        $formInput = $request->all();

        $workflowaction->update([
            'titre' => $formInput['titre'],
            'description' => $formInput['description'],
        ]);

        $workflowstep = WorkflowStep::where('id', $formInput['workflow_step_id'])->first();

        $workflowaction->setStep($workflowstep, true)
            ->setActionType($formInput['actiontype'], true)
            ->setTreatmentType($formInput['treatmenttype'], true)
            ->setMimeTypes($formInput['mimetypes'], true)
            ->setRequired($formInput['field_required'],$formInput['field_required_msg'], true)
            ->setRequiredWithout($formInput['field_required_without'],$formInput['actionsrequiredwithout'], $formInput['field_required_without_msg'], true)
            ->setRequiredWith($formInput['field_required_with'],$formInput['actionsrequiredwith'], $formInput['field_required_with_msg'], true)
        ;

        return [
            'step' => new WorkflowStepResource($workflowstep->refresh()),
            'action' => new WorkflowActionResource($workflowaction)
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param WorkflowAction $workflowaction
     * @return array|Response
     */
    public function destroy(WorkflowAction $workflowaction)
    {
        $workflowstep = WorkflowStep::where('id', $workflowaction->workflow_step_id)->first();
        $workflowaction->delete();

        return [
            'step' => new WorkflowStepResource($workflowstep->refresh()),
            'action' => $workflowaction
        ];
    }

    public function fetchbystep($id) {
        if ($id == 0) {
            return WorkflowAction::all();
        } else {
            $steps = WorkflowAction::where('workflow_step_id', $id)
                ->orderBy('id', 'desc')
                ->get();
            return $steps;
        }
    }
}
