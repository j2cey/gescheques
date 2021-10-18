<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Models\ReminderObject;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use App\Http\Resources\ReminderResource;
use App\Http\Resources\ReminderObjectResource;
use Illuminate\Contracts\Foundation\Application;
use App\Http\Requests\ReminderObject\CreateReminderObjectRequest;
use App\Http\Requests\ReminderObject\UpdateReminderObjectRequest;

class ReminderObjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        return view('reminderobjects.index');
    }

    public function fetch()
    {
        return ReminderObjectResource::collection(ReminderObject::all());
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
     * @param CreateReminderObjectRequest $request
     * @return array
     */
    public function store(CreateReminderObjectRequest $request)
    {
        $reminderobject = ReminderObject::createNew($request->reminder, $request->title, $request->model_type, $request->model_id, $request->description);
        $reminderobject->syncBroadlists($request->broadcastlists);

        return [
            'reminder' => new ReminderResource($request->reminder->refresh()),
            'reminderobject' => new ReminderobjectResource($reminderobject->refresh())
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param ReminderObject $reminderObject
     * @return Response
     */
    public function show(ReminderObject $reminderObject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ReminderObject $reminderObject
     * @return Response
     */
    public function edit(ReminderObject $reminderObject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateReminderObjectRequest $request
     * @param ReminderObject $reminderobject
     * @return array|Response
     */
    public function update(UpdateReminderObjectRequest $request, ReminderObject $reminderobject)
    {
        $reminderobject->update( [
            'title' => $request->title,
            'model_type' => $request->model_type,
            'model_id' => $request->model_id,
            'description' => $request->description
        ] );
        $reminderobject->setReminder($request->reminder)
            ->syncBroadlists($request->broadcastlists);

        return [
            'reminder' => new ReminderResource($request->reminder->refresh()),
            'reminderobject' => new ReminderobjectResource($reminderobject->refresh())
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ReminderObject $reminderObject
     * @return Response
     */
    public function destroy(ReminderObject $reminderObject)
    {
        //
    }
}
