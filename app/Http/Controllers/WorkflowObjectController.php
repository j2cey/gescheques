<?php

namespace App\Http\Controllers;

use App\Models\WorkflowObject;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class WorkflowObjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return WorkflowObject[]|Collection
     */
    public function index()
    {
        $workflowobjects = WorkflowObject::all();
        $workflowobjects->load(['fields']);
        return $workflowobjects;
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WorkflowObject  $workflowObject
     * @return \Illuminate\Http\Response
     */
    public function show(WorkflowObject $workflowObject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WorkflowObject  $workflowObject
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkflowObject $workflowObject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WorkflowObject  $workflowObject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkflowObject $workflowObject)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WorkflowObject  $workflowObject
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkflowObject $workflowObject)
    {
        //
    }
}
