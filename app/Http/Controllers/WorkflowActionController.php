<?php

namespace App\Http\Controllers;

use App\Models\WorkflowStep;
use Illuminate\Http\Response;
use App\Models\WorkflowAction;
use Illuminate\Database\Eloquent\Collection;
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
     * @return Response
     */
    public function store(CreateWorkflowActionRequest $request)
    {
        $user = auth()->user();
        $formInput = $request->all();

        $workflow_step = WorkflowStep::where('id', $formInput['workflow_step_id'])->first();

        $new_workflowaction = WorkflowAction::createNew($formInput['titre'],$formInput['description'])
            ->setStep($workflow_step, true)
            ->setActionType($formInput['actiontype'], true)
            ->setMimeTypes($formInput['mimetypes'], true)
            ->setRequired($formInput['field_required'],$formInput['field_required_msg'], true)
            ->setRequiredWithout($formInput['field_required_without'],$formInput['actionsrequiredwithout'], $formInput['field_required_without_msg'], true)
            ->setRequiredWith($formInput['field_required_with'],$formInput['actionsrequiredwith'], $formInput['field_required_with_msg'], true)
        ;

        return $new_workflowaction->load(['workflowstep','actiontype','actionsrequiredwithout','actionsrequiredwith','mimetypes']);
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
     * @return WorkflowAction
     */
    public function update(UpdateWorkflowActionRequest $request, WorkflowAction $workflowaction)
    {
        $user = auth()->user();
        $formInput = $request->all();

        $workflowaction->update([
            'titre' => $formInput['titre'],
            'description' => $formInput['description'],
        ]);

        $workflow_step = WorkflowStep::where('id', $formInput['workflow_step_id'])->first();

        $workflowaction->setStep($workflow_step, true)
            ->setActionType($formInput['actiontype'], true)
            ->setMimeTypes($formInput['mimetypes'], true)
            ->setRequired($formInput['field_required'],$formInput['field_required_msg'], true)
            ->setRequiredWithout($formInput['field_required_without'],$formInput['actionsrequiredwithout'], $formInput['field_required_without_msg'], true)
            ->setRequiredWith($formInput['field_required_with'],$formInput['actionsrequiredwith'], $formInput['field_required_with_msg'], true)
        ;

        return $workflowaction->load(['workflowstep','actiontype','actionsrequiredwithout','actionsrequiredwith','mimetypes']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param WorkflowAction $workflowaction
     * @return Response
     */
    public function destroy(WorkflowAction $workflowaction)
    {
        // TODO: Supprimer Action
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
