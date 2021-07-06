<?php

namespace App\Http\Controllers;

use App\Models\WorkflowObjectField;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WorkflowObjectFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return WorkflowObjectField[]|Collection
     */
    public function index()
    {
        $workflowobjectfields = WorkflowObjectField::all();
        $workflowobjectfields->load(['object']);
        return $workflowobjectfields;
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
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WorkflowObjectField  $workflowobjectfield
     * @return Response
     */
    public function show(WorkflowObjectField $workflowobjectfield)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WorkflowObjectField  $workflowobjectfield
     * @return Response
     */
    public function edit(WorkflowObjectField $workflowobjectfield)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WorkflowObjectField  $workflowobjectfield
     * @return Response
     */
    public function update(Request $request, WorkflowObjectField $workflowobjectfield)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WorkflowObjectField  $workflowobjectfield
     * @return Response
     */
    public function destroy(WorkflowObjectField $workflowobjectfield)
    {
        //
    }
}
