<?php

namespace App\Http\Controllers;

use App\Models\Agence;
use App\Models\Workflow;
use Illuminate\View\View;
use App\Models\Encaissement;
use Illuminate\Http\Request;
use App\Models\WorkflowStep;
use Illuminate\Http\Response;
use App\Models\FileImportResult;
use App\Models\EncaissementsFile;
use App\Models\EtatRapprochement;
use App\Imports\EncaissementsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Contracts\View\Factory;
use App\Http\Resources\SearchCollection;
use App\Http\Requests\Encaissement\FetchRequest;
use App\Http\Resources\EncaissementResource;
use Illuminate\Contracts\Foundation\Application;
use App\Repositories\Contracts\IEncaissementRepositoryContract;

class EncaissementController extends Controller
{
    /**
     * @var IEncaissementRepositoryContract
     */
    private $repository;

    /**
     * EncaissementController constructor.
     *
     * @param IEncaissementRepositoryContract $repository [description]
     */
    public function __construct(IEncaissementRepositoryContract $repository) {
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

        return view('encaissements.index')
            ->with('perPage', new \Illuminate\Support\Collection(config('system.per_page')))
            ->with('defaultPerPage', config('system.default_per_page'))
            ->with('agences', $agences)
            ;
    }

    /**
     * Fetch records.
     *
     * @param \App\Http\Requests\Encaissement\FetchRequest $request [description]
     * @return SearchCollection          [description]
     */
    public function fetch(FetchRequest $request)
    {
        return new SearchCollection(
            $this->repository->search($request), EncaissementResource::class
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
     * @param  \App\Models\Encaissement  $encaissement
     * @return \Illuminate\Http\Response
     */
    public function show(Encaissement $encaissement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Encaissement  $encaissement
     * @return \Illuminate\Http\Response
     */
    public function edit(Encaissement $encaissement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Encaissement  $encaissement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Encaissement $encaissement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Encaissement  $encaissement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Encaissement $encaissement)
    {
        //
    }

    public function upload() {
        return view('encaissements.upload');
    }

    public function uploadpost(Request $request) {
        $formInput = $request->all();

        $new_encaissementsfile = EncaissementsFile::create();
        // verifyAndStoreFile( Request $request, $fieldname_rqst, $file_role, $directory = 'unknown', File $curr_file = null )
        $new_encaissementsfile->verifyAndStoreFile( $request, "fichier_encaissements", "fichier", "encaissements_files");
        /*$new_import_result = FileImportResult::create([
            'report' => json_encode([]),
        ]);
        $new_encaissementsfile->fileimportresult()->associate($new_import_result)->save();*/

        //Excel::import(new EncaissementsImport($new_encaissementsfile->fileimportresult), config('app.encaissements_files') . '/' . $new_encaissementsfile->fichier);
    }
}
