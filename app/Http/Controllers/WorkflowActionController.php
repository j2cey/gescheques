<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkflowAction\CreateWorkflowActionRequest;
use App\Http\Requests\WorkflowAction\UpdateWorkflowActionRequest;
use App\Models\WorkflowAction;
use App\Models\WorkflowObject;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
        $workflowactions->load(['type','objectfield','fieldsrequiredwithout','fieldsrequiredwith']);

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

        //$val_bfor = $formInput['field_required'];
        $formInput['field_required'] = $this->getCheckValue($formInput, 'field_required');
        $formInput['field_required_without'] = $this->getCheckValue($formInput, 'field_required_without');
        $formInput['field_required_with'] = $this->getCheckValue($formInput, 'field_required_with');

        //dd($val_bfor,$formInput);

        $new_workflowaction = WorkflowAction::create([
            'titre' => $formInput['titre'],
            'description' => $formInput['description'],
            'workflow_step_id' => $formInput['workflow_step_id'],
            'workflow_action_type_id' => $formInput['type']['id'],
            'workflow_object_field_id' => $formInput['objectfield']['id'],
            'field_required' => $formInput['field_required'],
            'field_required_msg' => $formInput['field_required_msg'],

            'field_required_without' => $formInput['field_required_without'],
            'field_required_without_msg' => $formInput['field_required_without_msg'],

            'field_required_with' => $formInput['field_required_with'],
            'field_required_with_msg' => $formInput['field_required_with_msg'],
        ]);

        $this->attachFieldsrequiredwithout($new_workflowaction, $formInput['field_required_without'], $formInput['fieldsrequiredwithout']);
        $this->attachFieldsrequiredwith($new_workflowaction, $formInput['field_required_with'], $formInput['fieldsrequiredwith']);

        return $new_workflowaction->load(['type','objectfield','fieldsrequiredwithout','fieldsrequiredwith']);
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

        // TODO: Valider l'Action à Modifier

        $formInput['type'] = json_decode($formInput['type'], true);
        $formInput['objectfield'] = json_decode($formInput['objectfield'], true);

        $formInput['fieldsrequiredwithout'] = json_decode($formInput['fieldsrequiredwithout'], true);
        $formInput['fieldsrequiredwith'] = json_decode($formInput['fieldsrequiredwith'], true);

        //$val_bfor = $formInput['field_required'];
        $formInput['field_required'] = $this->getCheckValue($formInput, 'field_required');
        $formInput['field_required_without'] = $this->getCheckValue($formInput, 'field_required_without');
        $formInput['field_required_with'] = $this->getCheckValue($formInput, 'field_required_with');

        //dd($val_bfor,$formInput);

        $workflowaction->update([
            'titre' => $formInput['titre'],
            'description' => $formInput['description'],
            'workflow_step_id' => $formInput['workflow_step_id'],
            'workflow_action_type_id' => $formInput['type']['id'],
            'workflow_object_field_id' => $formInput['objectfield']['id'],
            'field_required' => $formInput['field_required'],
            'field_required_msg' => $formInput['field_required_msg'],

            'field_required_without' => $formInput['field_required_without'],
            'field_required_without_msg' => $formInput['field_required_without_msg'],

            'field_required_with' => $formInput['field_required_with'],
            'field_required_with_msg' => $formInput['field_required_with_msg'],
        ]);

        $this->syncFieldsrequiredwithout($workflowaction, $formInput['fieldsrequiredwithout']);
        $this->syncFieldsrequiredwith($workflowaction, $formInput['fieldsrequiredwith']);

        return $workflowaction->load(['type','objectfield','fieldsrequiredwithout','fieldsrequiredwith']);
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

    public function getCheckValue($formInput, $field) {
        if (array_key_exists($field, $formInput)) {
            if (is_null($formInput[$field])) {
                return 0;
            } else {
                return ($formInput[$field] === "true" || $formInput[$field] === "1" || $formInput[$field] === true) ? 1 : 0;
            }
        } else {
            return 0;
        }
    }

    private function attachFieldsrequiredwithout($workflowaction, $field_required_without, $fieldsrequiredwithout) {
        // field required without, fields list
        if ($field_required_without) {
            $fieldsrequiredwithout_ids = array_map( function (array $arr){
                return $arr['id'];
            },$fieldsrequiredwithout );
            $workflowaction->fieldsrequiredwithout()->attach($fieldsrequiredwithout_ids);
        }
    }

    private function syncFieldsrequiredwithout($workflowaction, $fieldsrequiredwithout) {
        // field required without, fields list
        $fieldsrequiredwithout_ids = array_map( function (array $arr){
            return $arr['id'];
        },$fieldsrequiredwithout );
        $workflowaction->fieldsrequiredwithout()->sync($fieldsrequiredwithout_ids);
    }

    private function attachFieldsrequiredwith($workflowaction, $field_required_with, $fieldsrequiredwith) {
        // field required with, fields list
        if ($field_required_with) {
            $fieldsrequiredwith_ids = array_map( function (array $arr){
                return $arr['id'];
            },$fieldsrequiredwith );
            $workflowaction->fieldsrequiredwith()->attach($fieldsrequiredwith_ids);
        }
    }

    private function syncFieldsrequiredwith($workflowaction, $fieldsrequiredwith) {
        // field required with, fields list
        $fieldsrequiredwith_ids = array_map( function (array $arr){
            return $arr['id'];
        },$fieldsrequiredwith );
        $workflowaction->fieldsrequiredwith()->sync($fieldsrequiredwith_ids);
    }
}
