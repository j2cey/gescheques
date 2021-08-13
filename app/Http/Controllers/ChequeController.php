<?php

namespace App\Http\Controllers;

use App\Models\Cheque;
use App\Models\Agence;
use App\Models\Workflow;
use Illuminate\View\View;
use App\Models\ChequesFile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Imports\ChequesImport;
use App\Models\FileImportResult;
use App\Models\EtatRapprochement;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;

use Exception;
use App\Models\WorkflowStep;
use Illuminate\Http\RedirectResponse;
use App\Http\Resources\SearchCollection;
use App\Http\Requests\Cheque\FetchRequest;
use App\Http\Resources\Cheque as ChequeResource;
use App\Repositories\Contracts\IChequeRepositoryContract;
use Spatie\Permission\Models\Role;

class ChequeController extends Controller
{
    /**
     * @var IChequeRepositoryContract
     */
    private $repository;

    /**
     * ChequeController constructor.
     *
     * @param IChequeRepositoryContract $repository [description]
     */
    public function __construct(IChequeRepositoryContract $repository) {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|Response|View
     */
    public function index()
    {
        $agences = Agence::all();
        $etatrappros = EtatRapprochement::all();
        $cheques_wf = Workflow::where('model_type', 'App\Models\Cheque')->first();
        $statuts = $cheques_wf ? WorkflowStep::where('workflow_id', $cheques_wf->id)->orWhereNull('workflow_id')->get() : null;

        return view('cheques.index')
            ->with('perPage', new \Illuminate\Support\Collection(config('system.per_page')))
            ->with('defaultPerPage', config('system.default_per_page'))
            ->with('statuts', $statuts)
            ->with('agences', $agences)
            ->with('etatrappros', $etatrappros)
            ;
    }

    /**
     * Fetch records.
     *
     * @param \App\Http\Requests\Cheque\FetchRequest $request [description]
     * @return SearchCollection          [description]
     */
    public function fetch(FetchRequest $request)
    {
        return new SearchCollection(
            $this->repository->search($request), ChequeResource::class
        );
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
     * @param  \App\Models\Cheque  $cheque
     * @return \Illuminate\Http\Response
     */
    public function show(Cheque $cheque)
    {
        $user = auth()->user();
        $userprofiles = $user->roles()->get();

        $exec_step_profile = $cheque->workflowexec->currentstep->profile;

        // récupérer le bon profile utilisateur
        /*if (! is_null($exec_step_profile)) {
            if ($user->hasRole([$exec_step_profile->name])) {
                $userprofile = $exec_step_profile;
            }
        }*/

        $cheque = Cheque::where('id',$cheque->id)
            ->first();

        $cheque->load([
            'workflowexec',
            'workflowexec.prevstep',
            'workflowexec.nextstep',
            'workflowexec.execsteps',
            'workflowexec.execsteps.step',
            'workflowexec.currentprofile',
            'workflowexec.execsteps.effectiverole',
            'workflowexec.execsteps.execactions',
            'workflowexec.execsteps.execactions.file',
            'workflowexec.execsteps.execactions.file.mimetype',
            'workflowexec.execsteps.execactions.workflowprocessstatus',

            'workflowexec.currentstep',
            'workflowexec.currentstep.actions',
            'workflowexec.currentstep.validatednextstep',
            'workflowexec.currentstep.rejectednextstep',
            'workflowexec.currentstep.expirednextstep',

            'workflowexec.workflowstatus','workflowexec.workflowprocessstatus',
            'workflowexec.execsteps.workflowstatus','workflowexec.execsteps.workflowprocessstatus'
        ]);
        $cheque->load(['encaissement','encaissement.agence']);

        $hasexecrole = $exec_step_profile ? ( $user->hasRole([$exec_step_profile->name]) ? 1 : 0 ) : 0;

        $actionvalues = [];

        return view('cheques.show', ['cheque' => $cheque, 'actionvalues' => json_encode($actionvalues), 'hasexecrole' => $hasexecrole, 'userprofiles' => $userprofiles]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cheque  $cheque
     * @return \Illuminate\Http\Response
     */
    public function edit(Cheque $cheque)
    {
        $user = auth()->user();
        $userprofile = $user->roles()->first();

        $exec_step_profile = $cheque->workflowexec->currentstep->profile;

        // récupérer le bon profile utilisateur
        if ($user->hasRole([$exec_step_profile->name])) {
            $userprofile = $exec_step_profile;
        }

        $cheque = Cheque::where('id',$cheque->id)
            ->first();

        //$cheque->load(['currmodelstep','currmodelstep.exec','currmodelstep.exec.currentstep','currmodelstep.exec.currentstep.profile','currmodelstep.step','currmodelstep.actions']);
        $cheque->load(['workflowexec','workflowexec.currentstep','workflowexec.currentstep.profile']);

        $hasexecrole = $exec_step_profile ? ( $user->hasRole([$exec_step_profile->name]) ? 1 : 0 ) : 0;

        $actionvalues = [];

        return view('cheques.edit', ['cheque' => $cheque, 'actionvalues' => json_encode($actionvalues), 'hasexecrole' => $hasexecrole, 'userprofile' => $userprofile]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cheque  $cheque
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cheque $cheque)
    {
        $cheque->update([
            'CHEQUE_NB' => $request->CHEQUE_NB,
            'ACC_CODE' => $request->ACC_CODE,
            'DESCRIPTION' => $request->DESCRIPTION,
            'COMPLEMENTS1' => $request->COMPLEMENTS1,
        ]);

        $cheque->load([
            'workflowexec',
            'workflowexec.prevstep',
            'workflowexec.nextstep',
            'workflowexec.execsteps',
            'workflowexec.execsteps.step',
            'workflowexec.currentprofile',
            'workflowexec.execsteps.effectiverole',
            'workflowexec.execsteps.execactions',
            'workflowexec.execsteps.execactions.file',
            'workflowexec.execsteps.execactions.file.mimetype',
            'workflowexec.execsteps.execactions.workflowprocessstatus',

            'workflowexec.currentstep',
            'workflowexec.currentstep.actions',
            'workflowexec.currentstep.validatednextstep',
            'workflowexec.currentstep.rejectednextstep',
            'workflowexec.currentstep.expirednextstep',

            'workflowexec.workflowstatus','workflowexec.workflowprocessstatus',
            'workflowexec.execsteps.workflowstatus','workflowexec.execsteps.workflowprocessstatus'
        ]);
        $cheque->load(['encaissement','encaissement.agence']);

        return $cheque;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cheque  $cheque
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cheque $cheque)
    {
        //
    }

    public function upload() {
        return view('cheques.upload');
    }

    public function uploadpost(Request $request) {
        $formInput = $request->all();

        $new_chequesfile = ChequesFile::create([
            'fichier' => $formInput['fichier'],
        ]);

        $new_chequesfile->verifyAndStoreFile( $request, "fichier_cheques", "fichier", "cheques_files", $oldfile = ' ' );
        $new_import_result = FileImportResult::create([
            'report' => json_encode([]),
        ]);
        $new_chequesfile->fileimportresult()->associate($new_import_result)->save();

        //Excel::import(new ChequesImport, config('app.cheques_files') . '/' . $new_chequesfile->fichier);
    }
}
