<?php

namespace App\Http\Controllers;

use App\Models\EnumValue;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\EnumTypeResource;
use App\Http\Resources\EnumValueResource;
use App\Http\Requests\EnumValue\CreateEnumValueRequest;
use App\Http\Requests\EnumValue\UpdateEnumValueRequest;

class EnumValueController extends Controller
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

    public function fetch()
    {
        return EnumValueResource::collection(EnumValue::all());
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
     * @param CreateEnumValueRequest $request
     * @return EnumValueResource|array|Response
     */
    public function store(CreateEnumValueRequest $request)
    {
        $enumvalue = EnumValue::createNew($request->enumtype, $request->val, $request->description);

        return [
            'enumtype' => new EnumTypeResource($enumvalue->enumtype->refresh()),
            'enumvalue' => new EnumValueResource($enumvalue)
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param EnumValue $enumvalue
     * @return Response
     */
    public function show(EnumValue $enumvalue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param EnumValue $enumvalue
     * @return Response
     */
    public function edit(EnumValue $enumvalue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateEnumValueRequest $request
     * @param EnumValue $enumvalue
     * @return EnumValueResource|array|void
     */
    public function update(UpdateEnumValueRequest $request, EnumValue $enumvalue)
    {
        $enumvalue->update([
            'val' => $request->val,
            'description' => $request->description
        ]);

        return [
            'enumtype' => new EnumTypeResource($enumvalue->enumtype->refresh()),
            'enumvalue' => new EnumValueResource($enumvalue)
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param EnumValue $enumvalue
     * @return array|Response
     */
    public function destroy(EnumValue $enumvalue)
    {
        $enumtype = $enumvalue->enumtype;
        $enumvalue->delete();

        return [
            'enumtype' => new EnumTypeResource($enumtype->refresh()),
            'enumvalue' => $enumvalue
        ];
    }
}
