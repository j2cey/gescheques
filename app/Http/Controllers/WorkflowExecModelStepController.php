<?php

namespace App\Http\Controllers;

use App\Models\Bordereauremise;
use App\Models\WorkflowExec;
use App\Models\WorkflowExecModelStep;
use App\Models\WorkflowStep;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class WorkflowExecModelStepController extends Controller
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
     * @param  \App\Models\WorkflowExecModelStep  $workflowexecmodelstep
     * @return \Illuminate\Http\Response
     */
    public function show(WorkflowExecModelStep $workflowexecmodelstep)
    {
        $workflowexecmodelsteps = WorkflowExecModelStep::where('id', $workflowexecmodelstep->id)
            ->first()
            ->load(['exec','step','actions', 'actions.type']);
        $actionvalues = [];
        if ($workflowexecmodelsteps->exec && $workflowexecmodelsteps->exec->currentstep) {
            foreach ($workflowexecmodelsteps->actions as $action) {
                if ($action->objectfield->valuetype_string) {
                    $actionvalues[$action->objectfield->db_field_name] = "";
                } elseif ($action->objectfield->valuetype_integer) {
                    $actionvalues[$action->objectfield->db_field_name] = "";
                } elseif ($action->objectfield->valuetype_boolean) {
                    $actionvalues[$action->objectfield->db_field_name] = "";
                } elseif ($action->objectfield->valuetype_datetime) {
                    $actionvalues[$action->objectfield->db_field_name] = "";
                } elseif ($action->objectfield->valuetype_image) {
                    $actionvalues[$action->objectfield->db_field_name] = "";
                } else {
                    $actionvalues[$action->objectfield->db_field_name] = "";
                }
            }
        }

        return ['data' => $workflowexecmodelsteps, 'actionvalues' => $actionvalues];
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WorkflowExecModelStep  $workflowexecmodelstep
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkflowExecModelStep $workflowexecmodelstep)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WorkflowExecModelStep  $workflowexecmodelstep
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkflowExecModelStep $workflowexecmodelstep)
    {
        $formInput = $request->all();

        //dd($formInput);

        // Validation
        $currmodelstep = WorkflowExecModelStep::with(['exec','exec.workflow','step','actions','actions.objectfield'])->where('id', $workflowexecmodelstep->id)->first();
        $validation_rules = [];
        $validation_messages = [];

        foreach ($currmodelstep->actions as $action) {
            $action->setValidationRules();
            $validation_rules = array_merge($validation_rules, $action->validation_rules);
            $validation_messages = array_merge($validation_messages, $action->validation_messages);
        }

        //request()->validate($validation_rules, $validation_messages);
        $request->validate($validation_rules, $validation_messages);
        //dd($request, $validation_rules,$validation_messages);

        //dd($validation_rules, $validation_messages,$formInput);

        // Parcourir et traiter les actions
        foreach ($currmodelstep->actions as $action) {
            // TODO: placer l'attribut image_dir dans la définition de la classe du model
            $action->Traiter($workflowexecmodelstep, $request, 'bordereauremises_scans');
        }

        // TODO: voir comment gérer dynamiquement le modèle traité (et son parent si besoin)
        if ($currmodelstep->model_type === "App\Models\BordereauremiseLigne") {
            $model_type = $currmodelstep->model_type;
            $model_sub = $model_type::where('id', $currmodelstep->model_id)->first();
            $model = Bordereauremise::where('id', $model_sub->bordereauremise_id)->first();
        } else {
            $model_type = $currmodelstep->model_type;
            $model = $model_type::where('id', $currmodelstep->model_id)->first();
        }
        $model->load(['type','localisation', 'modepaiement', 'lignes', 'lignes.currmodelstep','lignes.currmodelstep.exec','lignes.currmodelstep.step']);
        $model->load(['currmodelstep','currmodelstep.exec','currmodelstep.step','currmodelstep.actions']);

        return $model;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WorkflowExecModelStep  $workflowexecmodelstep
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkflowExecModelStep $workflowexecmodelstep)
    {
        //
    }

    public function canexecstep($stepid) {

        $user = auth()->user();

        $exec_step = WorkflowStep::where('id', $stepid)->first();
        $exec_step->load('profile');

        $hasexecrole = $exec_step ? ( $user->hasRole([$exec_step->profile->name]) ? 1 : 0 ) : 0;

        //dd($stepid, $hasexecrole, $exec_step);

        $data = ['hasroles' => $hasexecrole];

        return response()->json($data);
        //return $hasexecrole;
    }

    public function actionstoexec(Request $request) {

        $user = auth()->user();
        $formInput = $request->all();
        $data = ['actionstoexec' => 0];

        if ($request->has('objects')) {
            $objects = $formInput['objects'];
            foreach ($objects as $object) {
                if ($object['currmodelstep']) {
                    if ($object['currmodelstep']['exec']) {
                        $exec = $object['currmodelstep']['exec'];
                    } else {
                        $exec = WorkflowExec::where('id',$object['currmodelstep']['workflow_exec_id'])->toArray();
                    }
                    if ($object['currmodelstep']['workflow_step_id'] === $exec['current_step_id']) {
                        $exec_step = WorkflowStep::where('id', $exec['current_step_id'])->first();
                        $exec_step->load('profile');

                        $data['actionstoexec'] += $exec_step ? ( $user->hasRole([$exec_step->profile->name]) ? 1 : 0 ) : 0;
                    }
                }
            }
        }
        return response()->json($data);
    }
}
