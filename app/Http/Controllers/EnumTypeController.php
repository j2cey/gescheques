<?php

namespace App\Http\Controllers;

use App\Models\EnumType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use App\Http\Resources\EnumTypeResource;
use Illuminate\Contracts\Foundation\Application;
use App\Http\Requests\EnumType\UpdateEnumTypeRequest;
use App\Http\Requests\EnumType\CreateEnumTypeRequest;

class EnumTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        return view('enumtypes.index');
    }

    public function fetch()
    {
        return EnumTypeResource::collection(EnumType::all());
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
     * @param CreateEnumTypeRequest $request
     * @return EnumTypeResource|void
     */
    public function store(CreateEnumTypeRequest $request)
    {
        $enumtype = EnumType::createNew($request->name, null, $request->description);
        $enumtype->addValues($request->enumvalues);

        return new EnumTypeResource($enumtype);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EnumType  $enumType
     * @return Response
     */
    public function show(EnumType $enumType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EnumType  $enumType
     * @return Response
     */
    public function edit(EnumType $enumType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateEnumTypeRequest $request
     * @param EnumType $enumtype
     * @return EnumTypeResource|void
     */
    public function update(UpdateEnumTypeRequest $request, EnumType $enumtype)
    {
        $enumtype->update([
            'name' => $request->name,
            'description' => $request->description,
            ]);
        $enumtype->syncValues($request->enumvalues);

        return new EnumTypeResource($enumtype->refresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EnumType  $enumType
     * @return Response
     */
    public function destroy(EnumType $enumType)
    {
        //
    }
}
