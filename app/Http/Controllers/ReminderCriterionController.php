<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Models\ReminderCriterion;
use App\Http\Resources\ReminderResource;
use App\Http\Resources\ReminderCriterionResource;
use App\Http\Requests\ReminderCriterion\CreateReminderCriterionRequest;
use App\Http\Requests\ReminderCriterion\UpdateReminderCriterionRequest;

class ReminderCriterionController extends Controller
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
        return ReminderCriterionResource::collection(ReminderCriterion::all());
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
     * @param CreateReminderCriterionRequest $request
     * @return array|void
     */
    public function store(CreateReminderCriterionRequest $request)
    {
        $remindercriterion = ReminderCriterion::createNew(
            $request->criteriontype,
            $request->reminder,
            $request->title,
            $request->modelattribute,
            $request->criterion_value,
            $request->is_start_criterion,
            $request->is_stop_criterion,
            $request->description
        );

        return [
            'reminder' => new ReminderResource($request->reminder->refresh()),
            'criterion' => new ReminderCriterionResource($remindercriterion)
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param ReminderCriterion $remindercriterion
     * @return Response
     */
    public function show(ReminderCriterion $remindercriterion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ReminderCriterion $reminderCriterion
     * @return Response
     */
    public function edit(ReminderCriterion $reminderCriterion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateReminderCriterionRequest $request
     * @param ReminderCriterion $remindercriterion
     * @return array|void
     */
    public function update(UpdateReminderCriterionRequest $request, ReminderCriterion $remindercriterion)
    {
        $remindercriterion->update([
            'title' => $request->title,
            'criterion_value' => $request->criterion_value,
            'is_start_criterion' => $request->is_start_criterion,
            'is_stop_criterion' => $request->is_stop_criterion,
            'description' => $request->description
        ]);
        $remindercriterion->setCriterionType($request->criteriontype, true)
            ->setModelattribute($request->modelattribute, true);

        return [
            'reminder' => new ReminderResource($request->reminder->refresh()),
            'criterion' => new ReminderCriterionResource($remindercriterion->refresh())
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ReminderCriterion $remindercriterion
     * @return array|Response
     * @throws \Exception
     */
    public function destroy(ReminderCriterion $remindercriterion)
    {
        $reminder = $remindercriterion->reminder;
        $remindercriterion->delete();

        return [
            'reminder' => new ReminderResource($reminder->refresh()),
            'criterion' => $remindercriterion
        ];
    }
}
