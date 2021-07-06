<?php

namespace App\Http\Controllers;

use App\Http\Requests\CleanRequestTrait;
use App\Models\Workflow;
use App\Models\WorkflowExec;
use App\Models\WorkflowStatus;
use App\Models\WorkflowStep;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class WorkflowExecController extends Controller
{
    use CleanRequestTrait;
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
        dd($request);
    }

    /**
     * Display the specified resource.
     *
     * @param WorkflowExec $workflowexec
     * @return \Illuminate\Http\Response
     */
    public function show(WorkflowExec $workflowexec)
    {
        $workflowexec = WorkflowExec::where('id',$workflowexec->id)
            ->first()
            ->load(['workflow','currentstep','currentstep.actions','currentstep.actions.type','currentstep.actions.objectfield','workflowstatus','workflow']);
        $actionvalues = [];
        foreach ($workflowexec->currentstep->actions as $action) {
            $actionvalues[$action->objectfield->db_field_name] = null;
        }
        $actionvalues['setvalue'] = null;
        $actionvalues['motif_rejet'] = null;
        return view('workflowexecs.show', ['workflowexec' => $workflowexec, 'actionvalues' => json_encode($actionvalues)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param WorkflowExec $workflowexec
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkflowExec $workflowexec)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param WorkflowExec $workflowexec
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkflowExec $workflowexec)
    {
        /*request()->validate([
            'file' => 'required',
            'type' => 'required'
        ],
        [
            'file.required' => 'You have to choose the file!',
            'type.required' => 'You have to choose type of the file!'
        ]
        );*/

        //$request->replace($request->all());
        $formInput = $request->all();
        /*foreach ($formInput as $key => $value) {
            if ($value === "null") {
                $request->replace([$key => null]);
            }
        }*/

        // Validation
        $currstep = WorkflowStep::with(['actions','actions.objectfield'])->where('id', $workflowexec->current_step_id)->first();
        $validation_rules = [];
        $validation_messages = [];

        foreach ($currstep->actions as $action) {
            if ($action->field_required) {
                $field_label = explode('|',$action->objectfield->field_label)[1];
                if ($action->objectfield->valuetype_string) {
                    // string required
                    $validation_rules[$action->objectfield->db_field_name] = 'required|string';
                    $validation_messages[$action->objectfield->db_field_name . '.string'] = $field_label . " doit être une chaine de caractères";
                } elseif ($action->objectfield->valuetype_integer) {
                    // integer required
                    $validation_rules[$action->objectfield->db_field_name] = 'required|integer';
                    $validation_messages[$action->objectfield->db_field_name . '.integer'] = $field_label . " doit être un nombre";
                } elseif ($action->objectfield->valuetype_boolean) {
                    // bool required
                    $validation_rules[$action->objectfield->db_field_name] = 'required|bool';
                    $validation_messages[$action->objectfield->db_field_name . '.bool'] = $field_label . " doit être un booléen";
                } elseif ($action->objectfield->valuetype_datetime) {
                    // datetime required
                    $validation_rules[$action->objectfield->db_field_name] = 'required|date';
                    $validation_messages[$action->objectfield->db_field_name . '.date'] = $field_label . " doit être une date valide";
                } elseif ($action->objectfield->valuetype_image) {
                    // image required
                    $validation_rules[$action->objectfield->db_field_name] = 'required|image';
                    $validation_messages[$action->objectfield->db_field_name . '.image'] = $field_label . " doit être une image valide";
                } else {
                    // default required
                    $validation_rules[$action->objectfield->db_field_name] = 'required';
                }

                if ($action->field_required_msg && ($action->field_required_msg !== "")) {
                    $validation_messages[$action->objectfield->db_field_name . '.required'] = $action->field_required_msg;
                }
            }
        }

        //request()->validate($validation_rules, $validation_messages);
        $request->validate($validation_rules, $validation_messages);
        //dd($request, $validation_rules,$validation_messages);

        //$step_file = $request->file('step_files');

        $formInput['motif_rejet'] = ($formInput['motif_rejet'] === "null" ? null : $formInput['motif_rejet']);

        $prevstep = WorkflowStep::where('workflow_id', $workflowexec->workflow_id)
            ->where('posi', $currstep->posi - 1)->first();
        $nextstep = WorkflowStep::where('workflow_id', $workflowexec->workflow_id)
            ->where('posi', $currstep->posi + 1)->first();

        $nextstep_id = WorkflowStep::coded("0")->first()->id;
        $workflow_status_id = $workflowexec->workflow_status_id;

        $model = null;

        if ( is_null($formInput['motif_rejet']) || $formInput['motif_rejet'] === "null" ) {
            // Validation de l'étape
            $model_type = $workflowexec->model_type;
            $model = $model_type::where('id', $workflowexec->model_id)->first();
            // On parcoure les actions pour assigner les valeurs
            foreach ($currstep->actions as $action) {
                if ($action->type->code === "2") {
                    // action sur objet
                    if ($action->objectfield->valuetype_datetime) {
                        // Type DateTime
                        $model->{$action->objectfield->db_field_name} = $formInput[$action->objectfield->db_field_name]; // Carbon::parse($formInput[$action->objectfield->db_field_name]);
                    } elseif ($action->objectfield->valuetype_image) {
                        $model->{$action->objectfield->db_field_name} = $this->verifyAndStoreImage($request, $action->objectfield->db_field_name, 'bordereauremises_scans');
                    } elseif ($action->objectfield->valuetype_string) {
                        $str_val = ($formInput[$action->objectfield->db_field_name] === "null" || $formInput[$action->objectfield->db_field_name] === null) ? "" : $formInput[$action->objectfield->db_field_name];
                        $model->{$action->objectfield->db_field_name} = $str_val;
                    } else {
                        $model->{$action->objectfield->db_field_name} = $formInput[$action->objectfield->db_field_name];
                    }
                } else {
                    // action sur workflow
                }
            }
            $model->save();
            if ($nextstep) {
                $nextstep_id = $nextstep->id;
            } else {
                // Statut Traitement Terminé
                $workflow_status_id = WorkflowStatus::coded("4")->first()->id;
            }
        } else {
            //dd('motif_rejet non null, Réjet de l étape ',$formInput,is_null($formInput['motif_rejet']));
            // Réjet de l'étape
            if ($prevstep) {
                $nextstep_id = $prevstep->id;
            } else {
                // Statut Rejété
                $workflow_status_id = WorkflowStatus::coded("5")->first()->id;
            }
        }
        $workflowexec->update([
            'current_step_id' => $nextstep_id,
            'workflow_status_id' => $workflow_status_id,
            'motif_rejet' => $formInput['motif_rejet'],
        ]);

        if (! is_null($model)) {
            $model->load(['workflowexec','workflowexec.currentstep','workflowexec.currentstep.actions','workflowexec.currentstep.actions.type','workflowexec.currentstep.actions.objectfield','workflowexec.currentstep.profile','workflowexec.workflowstatus']);
        }
        //$workflowexec->load(['currentstep','currentstep.actions','currentstep.actions.type','currentstep.actions.objectfield','currentstep.profile','workflowstatus']);

        return $model;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param WorkflowExec $workflowexec
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkflowExec $workflowexec)
    {
        //
    }
}
