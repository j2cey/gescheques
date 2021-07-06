<?php

namespace App\Http\Controllers;

use App\Http\Requests\Workflow\CreateWorkflowRequest;
use App\Models\Workflow;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class WorkflowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Workflow[]|Collection|Response
     */
    public function index()
    {
        return view('workflows.index');
    }

    public function fetch() {
        $workflows = Workflow::all();
        $workflows->load(['object','steps','steps.profile','steps.actions','steps.actions.type','steps.actions.objectfield','steps.actions.fieldsrequiredwithout','steps.actions.fieldsrequiredwith']);
        return $workflows;
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
     * @param CreateWorkflowRequest $request
     * @return Response
     */
    public function store(CreateWorkflowRequest $request)
    {
        $user = auth()->user();

        $formInput = $request->all();

        $new_workflow = Workflow::create([
            'titre' => $formInput['titre'],
            'description' => $formInput['description'],
            'user_id' => $user->id,
            'workflow_object_id' => $formInput['object']['id'],
            'model_type' => $formInput['object']['model_type'],
        ]);

        // Insert model_workflow
        /*DB::table('model_has_workflow')->insert([
            'workflow_id' => $new_workflow->id,
            'model_type' => $formInput['object']['model_type'],
        ]);*/

        return $new_workflow->load(['object','steps','steps.profile','steps.actions','steps.actions.type','steps.actions.objectfield','steps.actions.fieldsrequiredwithout','steps.actions.fieldsrequiredwith']);
    }

    /**
     * Display the specified resource.
     *
     * @param Workflow $workflow
     * @return Response
     */
    public function show(Workflow $workflow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Workflow $workflow
     * @return Response
     */
    public function edit(Workflow $workflow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Workflow $workflow
     * @return Response
     */
    public function update(Request $request, Workflow $workflow)
    {
        $formInput = $request->all();
        foreach ($formInput as $key => $value) {
            if ($value === "null") {
                $request->replace([$key => null]);
            }
        }

        // TODO: Validadtion

        $formInput['object'] = json_decode($formInput['object'], true);

        $workflow->update([
            'titre' => $formInput['titre'],
            'description' => $formInput['description'],
            'workflow_object_id' => $formInput['object']['id'],
            'model_type' => $formInput['object']['model_type'],
        ]);

        return $workflow->load(['object','steps','steps.profile','steps.actions','steps.actions.type','steps.actions.objectfield','steps.actions.fieldsrequiredwithout','steps.actions.fieldsrequiredwith']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Workflow $workflow
     * @return Response
     */
    public function destroy(Workflow $workflow)
    {
        //TODO: Supprimer le Workflow
    }
}
