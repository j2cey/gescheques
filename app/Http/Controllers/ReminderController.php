<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use App\Http\Resources\ReminderResource;
use Illuminate\Contracts\Foundation\Application;
use App\Http\Requests\Reminder\CreateReminderRequest;
use App\Http\Requests\Reminder\UpdateReminderRequest;

class ReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        return view('reminders.index');
    }

    public function fetch()
    {
        return ReminderResource::collection(Reminder::all());
    }

    public function fetchone($id) {
        $reminder = Reminder::where('uuid', $id)->first();
        return new ReminderResource($reminder);
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
     * @param CreateReminderRequest $request
     * @return ReminderResource|void
     */
    public function store(CreateReminderRequest $request)
    {
        $reminder = Reminder::createNew($request->modeltype, $request->title, $request->description);
        $reminder->setStatus($request->status, true);

        return new ReminderResource($reminder);
    }

    /**
     * Display the specified resource.
     *
     * @param Reminder $reminder
     * @return Response
     */
    public function show(Reminder $reminder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Reminder $reminder
     * @return Response
     */
    public function edit(Reminder $reminder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateReminderRequest $request
     * @param Reminder $reminder
     * @return ReminderResource|Response
     */
    public function update(UpdateReminderRequest $request, Reminder $reminder)
    {
        $reminder->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);
        $reminder->setModelType($request->modeltype, true);
        $reminder->setStatus($request->status, true);

        return new ReminderResource($reminder->refresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Reminder $reminder
     * @return Response
     */
    public function destroy(Reminder $reminder)
    {
        //
    }
}
