<?php

namespace App\Http\Controllers;

use App\Models\Workflow;
use Illuminate\Http\Request;
use App\Models\WorkflowStep;
use Illuminate\Http\Response;
use App\Models\WorkflowStepType;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Contracts\View\View;
use App\Models\WorkflowTreatmentType;
use Illuminate\Contracts\View\Factory;
use App\Models\WorkflowStepTransition;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Foundation\Application;
use App\Http\Requests\Workflow\CreateWorkflowRequest;
use App\Http\Requests\WorkflowFlowchart\UpdateWorkflowFlowchartRequest;

class WorkflowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Workflow[]|Application|Factory|View|Collection|Response
     */
    public function index()
    {
        return view('workflows.index');
    }

    public function fetchflowchart($id) {

        $nodes = WorkflowStep::where('workflow_id', $id)
            //->orWhereIn('workflow_steps.code', ['step_start','step_end'])
            ->select(
                'workflow_steps.id as id',
                'workflow_steps.flowchart_position_x as x',
                'workflow_steps.flowchart_position_y as y',
                'workflow_steps.flowchart_size_width as width',
                'workflow_steps.flowchart_size_height as height',
                'workflow_steps.titre as name',
                'workflow_steps.description as description',
                'workflow_steps.code as code',
                'workflow_step_types.code as type'
            )
            ->join('workflow_step_types', 'workflow_step_types.id','=', 'workflow_steps.workflow_step_type_id')
            ->get();

        $connections_raw = DB::table('workflow_steps')
            ->where('workflow_steps.workflow_id', $id)
            ->orWhereIn('workflow_steps.code', ['step_start','step_end'])
            ->select(
                'workflow_step_transitions.id as id',
                'workflow_treatment_types.code as type',
                'workflow_step_transitions.workflow_step_destination_id as destination',
                'workflow_steps.id as source',
                'workflow_step_transitions.flowchart_source_position',
                'workflow_step_transitions.flowchart_destination_position',
                'workflow_step_transitions.code'
            )
            ->join('workflow_step_transitions', 'workflow_step_transitions.workflow_step_source_id','=', 'workflow_steps.id')
            ->join('workflow_treatment_types', 'workflow_treatment_types.id','=', 'workflow_step_transitions.workflow_treatment_type_id')
            ->join('workflow_steps as destination', 'destination.id','=', 'workflow_step_transitions.workflow_step_destination_id')
            ->get()
        ;

        $connections = [];
        foreach ($connections_raw as $item) {
            $connections[] = [
                'id' => $item->id,
                'type' => $item->type,
                'source' => [
                    'id' => $item->source,
                    'position' => $item->flowchart_source_position
                ],
                'destination' => [
                    'id' => $item->destination,
                    'position' => $item->flowchart_destination_position
                ]
            ];
        }

        $approvers = Role::select('id','name')->get();

        //dd('states: ', $states, 'states json: ', json_encode($states, JSON_UNESCAPED_SLASHES), 'transitions raw : ', $transitions, 'transitions json: ', json_encode($transitions, JSON_UNESCAPED_SLASHES));
        return ['nodes' => $nodes, 'connections' => $connections, 'approvers' => $approvers];
    }

    public function flowchart($id) {
        $workflow = Workflow::where('id', $id)->first();
        $flowchart_data = $this->fetchflowchart($id);

        //dd('states: ', $states, 'states json: ', json_encode($states, JSON_UNESCAPED_SLASHES), 'transitions raw : ', $transitions, 'transitions json: ', json_encode($transitions, JSON_UNESCAPED_SLASHES));
        return view('workflows.flowchart')
            ->with('workflow', $workflow)
            ->with('nodes', $flowchart_data['nodes'])
            ->with('connections', $flowchart_data['connections'])
            ->with('approvers', $flowchart_data['approvers'])
            ;
    }

    public function storeflowchart(UpdateWorkflowFlowchartRequest $request, Workflow $workflow) {
        $flowchart_data_old = $this->fetchflowchart($workflow->id);
        //$workflow = new Workflow();
        //$workflow = Workflow::where('id', $id)->first();
        // enregistrement des nodes (steps)
        $nodes_saved = [];
        foreach ($request->nodes as $node) {
            $node_saved_tmp = [];
            $node_saved_tmp['old_id'] = $node['id'];

            $step = $workflow->addOrUpdateStep($node['code'], $node['name'], $node['description']);

            $type = WorkflowStepType::where('code', $node['type'])->first();
            $step->setFlochartSize($node['width'], $node['height'], true)
                ->setFlochartPosition($node['x'], $node['y'], true)
                ->setStepType($type, true)
            ;
            $node_saved_tmp['step'] = $step;
            $nodes_saved[] = $node_saved_tmp;
        }

        // suppression des noeuds rétirés
        foreach ($workflow->steps as $step) {
            $is_in_flowchart = false;
            foreach ($nodes_saved as $node) {
                if($step->code === $node['step']->code) {
                    $is_in_flowchart = true;
                    break;
                }
            }
            if ( ! $is_in_flowchart ) {
                $workflow->removeStep($step);
            }
        }

        // enregistrement des connections (transitions)
        $connections_saved = [];
        foreach ($request->connections as $connection) {
            $connection_saved_tmp = [];
            $connection_saved_tmp['old_id'] = $connection['id'];

            $source = null;
            foreach ($nodes_saved as $node) {
                if ($connection['source']['id'] === $node['old_id']) {
                    $source = $node['step'];
                    break;
                }
            }
            $destination = null;
            foreach ($nodes_saved as $node) {
                if ($connection['destination']['id'] === $node['old_id']) {
                    $destination = $node['step'];
                    break;
                }
            }

            $connection_saved_tmp['connection'] = WorkflowStepTransition::setOne(
                WorkflowTreatmentType::getType($connection['type']),
                $source, $destination,
                $connection['source']['position'],
                $connection['destination']['position'], true);

            $connections_saved[] = $connection_saved_tmp;
        }

        dd($workflow, $request, $request->nodes, $request->connections);
    }

    public function fetch() {
        $workflows = Workflow::all();

        $workflows->load([
            'object',
            'steps',
            'steps.approvers','steps.stepparent','steps.transitionpassstep','steps.transitionrejectstep',
            'steps.transitionexpirestep','steps.otherstonotify',
            'steps.actions',
            'steps.actions.actiontype',
            'steps.actions.mimetypes',
            'steps.actions.actionsrequiredwithout','steps.actions.actionsrequiredwith',
            'steps.actionspass',
            'steps.actionspass.actiontype','steps.actionspass.mimetypes',
            'steps.actionspass.actionsrequiredwithout','steps.actionspass.actionsrequiredwith',
            'steps.actionsreject',
            'steps.actionsreject.actiontype','steps.actionsreject.mimetypes',
            'steps.actionsreject.actionsrequiredwithout','steps.actionsreject.actionsrequiredwith',
            'steps.actionsreject',
            'steps.actionsreject.actiontype','steps.actionsreject.mimetypes',
            'steps.actionsreject.actionsrequiredwithout','steps.actionsreject.actionsrequiredwith'
        ]);
        return $workflows;
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
     * @param CreateWorkflowRequest $request
     * @return Response
     */
    public function store(CreateWorkflowRequest $request)
    {
        $user = auth()->user();

        $formInput = $request->all();

        $new_workflow = Workflow::create([
            'titre' => $formInput['titre'],
            'description' => $formInput['description'],
            'user_id' => $user->id,
            'workflow_object_id' => $formInput['object']['id'],
            'model_type' => $formInput['object']['model_type'],
        ]);

        return $new_workflow->load([
            'object',
            'steps',
            'steps.approvers','steps.stepparent',
            'steps.actions',
            'steps.actions.actiontype',
            'steps.actions.mimetypes',
            'steps.actions.actionsrequiredwithout','steps.actions.actionsrequiredwith',
            'steps.actionspass',
            'steps.actionspass.actiontype','steps.actionspass.mimetypes',
            'steps.actionspass.actionsrequiredwithout','steps.actionspass.actionsrequiredwith',
            'steps.actionsreject',
            'steps.actionsreject.actiontype','steps.actionsreject.mimetypes',
            'steps.actionsreject.actionsrequiredwithout','steps.actionsreject.actionsrequiredwith',
            'steps.actionsreject',
            'steps.actionsreject.actiontype','steps.actionsreject.mimetypes',
            'steps.actionsreject.actionsrequiredwithout','steps.actionsreject.actionsrequiredwith'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Workflow $workflow
     * @return Response
     */
    public function show(Workflow $workflow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Workflow $workflow
     * @return Response
     */
    public function edit(Workflow $workflow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Workflow $workflow
     * @return Workflow|Response
     */
    public function update(Request $request, Workflow $workflow)
    {
        $formInput = $request->all();
        foreach ($formInput as $key => $value) {
            if ($value === "null") {
                $request->replace([$key => null]);
            }
        }

        // TODO: Validadtion

        $formInput['object'] = json_decode($formInput['object'], true);

        $workflow->update([
            'titre' => $formInput['titre'],
            'description' => $formInput['description'],
            'workflow_object_id' => $formInput['object']['id'],
            'model_type' => $formInput['object']['model_type'],
        ]);

        return $workflow->load(['object','steps','steps.approvers','steps.stepparent',
            'steps.actions',
            'steps.actions.actiontype',
            'steps.actions.mimetypes',
            'steps.actions.actionsrequiredwithout','steps.actions.actionsrequiredwith',
            'steps.actionspass',
            'steps.actionspass.actiontype','steps.actionspass.mimetypes',
            'steps.actionspass.actionsrequiredwithout','steps.actionspass.actionsrequiredwith',
            'steps.actionsreject',
            'steps.actionsreject.actiontype','steps.actionsreject.mimetypes',
            'steps.actionsreject.actionsrequiredwithout','steps.actionsreject.actionsrequiredwith',
            'steps.actionsreject',
            'steps.actionsreject.actiontype','steps.actionsreject.mimetypes',
            'steps.actionsreject.actionsrequiredwithout','steps.actionsreject.actionsrequiredwith'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Workflow $workflow
     * @return Response
     */
    public function destroy(Workflow $workflow)
    {
        //TODO: Supprimer le Workflow
    }
}
