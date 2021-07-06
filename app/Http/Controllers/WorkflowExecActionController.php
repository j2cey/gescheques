<?php

namespace App\Http\Controllers;

use App\Models\WorkflowExecAction;
use App\Models\WorkflowStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WorkflowExecActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
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
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param WorkflowExecAction $workflowexecaction
     * @return Response
     */
    public function show(WorkflowExecAction $workflowexecaction)
    {
        $workflowexecaction = WorkflowExecAction::where('id',$workflowexecaction->id)
            ->first()
        ->load(['workflowexec','action','action.step','action.type','action.objectfield','workflowstatus','prevexec','nextexec']);
        return view('workflowexecactions.show', ['workflowexecaction' => $workflowexecaction]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param WorkflowExecAction $workflowexecaction
     * @return Response
     */
    public function edit(WorkflowExecAction $workflowexecaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param WorkflowExecAction $workflowexecaction
     * @return Response
     */
    public function update(Request $request, WorkflowExecAction $workflowexecaction)
    {
        $valueimage = request()->file('valueimage');
        //dd($workflowexecaction,$request);
        $user = auth()->user();
        $formInput = $request->all();

        $new_state['current'] = 0;

        if (is_null($formInput['motif_rejet'])) {
            // Action validée
            // On deplace le curseur vers l'avant s'il y a une action à la suite
            if ( ! is_null($workflowexecaction->next_exec_id) ) {
                $nextexec = WorkflowExecAction::where('id', $workflowexecaction->next_exec_id)->first();
                $nextexec->update([
                    'current' => 1,
                    'workflow_status_id' => WorkflowStatus::coded("2")->first()->id,
                ]);
                $nextexec->notifierActeur();
            }
            $new_state['workflow_status_id'] = WorkflowStatus::coded("4")->first()->id;
        } else {
            // Action rejétée
            // On ramène le curseur vers l'arrière s'il y a une action
            if ( ! is_null($workflowexecaction->prev_exec_id) ) {
                $prevexec = WorkflowExecAction::where('id', $workflowexecaction->prev_exec_id)->first();
                $prevexec->update([
                    'current' => 1
                ]);
                $prevexec->notifierActeur();
            }
            $new_state['workflow_status_id'] = WorkflowStatus::coded("5")->first()->id;
        }

        $workflowexecaction->update($new_state);

        return $workflowexecaction;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param WorkflowExecAction $workflowexecaction
     * @return Response
     */
    public function destroy(WorkflowExecAction $workflowexecaction)
    {
        //
    }
}
