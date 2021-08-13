<?php

namespace App\Http\Controllers;

use App\Models\WorkflowTreatmentType;
use Illuminate\Http\Request;

class WorkflowTreatmentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function fetchsplitted() {
        $validation_treatment_type = WorkflowTreatmentType::getValidationType();
        $rejection_treatment_type = WorkflowTreatmentType::getRejectionType();
        $expiration_treatment_type = WorkflowTreatmentType::getExpirationType();

        return [
            'validation_treatment_type' => $validation_treatment_type,
            'rejection_treatment_type' => $rejection_treatment_type,
            'expiration_treatment_type' => $expiration_treatment_type
        ];
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
     * @param  \App\Models\WorkflowTreatmentType  $workflowTreatmentType
     * @return \Illuminate\Http\Response
     */
    public function show(WorkflowTreatmentType $workflowTreatmentType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WorkflowTreatmentType  $workflowTreatmentType
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkflowTreatmentType $workflowTreatmentType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WorkflowTreatmentType  $workflowTreatmentType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkflowTreatmentType $workflowTreatmentType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WorkflowTreatmentType  $workflowTreatmentType
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkflowTreatmentType $workflowTreatmentType)
    {
        //
    }
}
