<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReminderBroadlist;
use App\Http\Resources\ReminderBroadlistResource;
use App\Http\Requests\ReminderBroadlist\CreateReminderBroadlistRequest;

class ReminderBroadlistController extends Controller
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

    public function fetch()
    {
        return ReminderBroadlistResource::collection(ReminderBroadlist::all());
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
     * @param CreateReminderBroadlistRequest $request
     * @return ReminderBroadlistResource[]|void
     */
    public function store(CreateReminderBroadlistRequest $request)
    {
        $broadlist = ReminderBroadlist::createNew(
            $request->title,
            $request->msg,
            $request->notification_interval,
            $request->description
        );
        $broadlist->syncRoles($request->roles)
            ->syncUsers($request->users);

        $request->object->addBroadlist($broadlist);

        return [
            'object' => $request->object,
            'broadlist' => new ReminderBroadlistResource($broadlist)
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReminderBroadlist  $reminderBroadlist
     * @return \Illuminate\Http\Response
     */
    public function show(ReminderBroadlist $reminderBroadlist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReminderBroadlist  $reminderBroadlist
     * @return \Illuminate\Http\Response
     */
    public function edit(ReminderBroadlist $reminderBroadlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReminderBroadlist  $reminderbroadlist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReminderBroadlist $reminderbroadlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReminderBroadlist  $reminderBroadlist
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReminderBroadlist $reminderBroadlist)
    {
        //
    }
}
