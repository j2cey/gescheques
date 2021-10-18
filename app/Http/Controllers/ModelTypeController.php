<?php

namespace App\Http\Controllers;

use App\Models\ModelType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Resources\ModelTypeResource;

class ModelTypeController extends Controller
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

    public function fetch() {
        ModelType::updateList();
        return ModelTypeResource::collection(ModelType::all());
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
     * @param  \App\Models\ModelType  $modelType
     * @return \Illuminate\Http\Response
     */
    public function show(ModelType $modelType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ModelType  $modelType
     * @return \Illuminate\Http\Response
     */
    public function edit(ModelType $modelType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ModelType  $modelType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ModelType $modelType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ModelType  $modelType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ModelType $modelType)
    {
        //
    }
}
