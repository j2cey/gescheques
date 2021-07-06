<?php

namespace App\Http\Controllers;

use App\Http\Requests\CleanRequestTrait;
use App\Http\Requests\WorkflowStep\CreateWorkflowStepRequest;
use App\Models\WorkflowStep;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WorkflowStepController extends Controller
{
    use CleanRequestTrait;
    /**
     * Display a listing of the resource.
     *
     * @return WorkflowStep[]|Collection
     */
    public function index()
    {
        $workflowsteps = WorkflowStep::orderBy('posi','ASC')->get();
        $workflowsteps->load(['profile','actions']);

        return $workflowsteps;
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
     * @param CreateWorkflowStepRequest $request
     * @return Response
     */
    public function store(CreateWorkflowStepRequest $request)
    {
        $user = auth()->user();

        $formInput = $request->all();

        $posi = WorkflowStep::where('workflow_id', $formInput['workflow_id'])->count('id');

        $new_workflowstep = WorkflowStep::create([
            'titre' => $formInput['titre'],
            'code' => "step_" . $posi,//(string) Str::orderedUuid(),
            'description' => $formInput['description'],
            'workflow_id' => $formInput['workflow_id'],
            'role_id' => $formInput['profile']['id'],
            'posi' => $posi,
        ]);

        return $new_workflowstep->load(['actions','profile']);
    }

    /**
     * Display the specified resource.
     *
     * @param WorkflowStep $workflowstep
     * @return Response
     */
    public function show(WorkflowStep $workflowstep)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param WorkflowStep $workflowstep
     * @return Response
     */
    public function edit(WorkflowStep $workflowstep)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param WorkflowStep $workflowstep
     * @return WorkflowStep|WorkflowStep[]|Collection
     */
    public function update(Request $request, WorkflowStep $workflowstep)
    {
        $user = auth()->user();

        //$request->replace($request->all());
        $formInput = $request->all();

        if ($request->has('oldIndex') && $request->has('newIndex')) {
            $this->reorder($workflowstep, $formInput['oldIndex'], $formInput['newIndex']);
            $workflowsteps = WorkflowStep::where('workflow_id',$formInput['workflow_id'])->orderBy('posi','ASC')->get();
            return $workflowsteps->load(['actions','profile']);
        } else {

            $formInput['profile'] = json_decode($formInput['profile'], true);

            $workflowstep->update([
                'titre' => $formInput['titre'],
                'description' => $formInput['description'],
                'workflow_id' => $formInput['workflow_id'],
                'role_id' => $formInput['profile']['id'],
            ]);

            return $workflowstep->load(['actions','profile']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param WorkflowStep $workflowstep
     * @return Response
     */
    public function destroy(WorkflowStep $workflowstep)
    {
        //TODO: Supprimer l'étape de Workflow
    }

    public function reorder(WorkflowStep $workflowstep, $oldIndex, $newIndex) {
        if ( ($newIndex - $oldIndex) < 0) {
            DB::table('workflow_steps')
                ->where('workflow_id', $workflowstep->workflow_id)
                ->where('posi', '>=', $newIndex)
                ->where('posi', '<=', $oldIndex)
                ->increment('posi', 1);
        } else {
            DB::table('workflow_steps')
                ->where('workflow_id', $workflowstep->workflow_id)
                ->where('posi', '>=', $oldIndex)
                ->where('posi', '<=', $newIndex)
                ->decrement('posi', 1);
        }
        $workflowstep->update([
            'posi' => $newIndex,
        ]);
    }
}
