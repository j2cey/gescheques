<?php

namespace App\Http\Controllers;

use App\Models\Workflow;
use App\Models\Bordereau;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Foundation\Application;

use Exception;
use App\Models\WorkflowStep;
use Illuminate\Http\RedirectResponse;
use App\Http\Resources\SearchCollection;
use App\Http\Requests\Bordereau\FetchRequest;
use App\Http\Resources\Bordereau as BordereauResource;
use App\Repositories\Contracts\IBordereauRepositoryContract;
use Spatie\Permission\Models\Role;

class BordereauController extends Controller
{
    /**
     * @var IBordereauRepositoryContract
     */
    private $repository;

    /**
     * BordereauController constructor.
     *
     * @param IBordereauRepositoryContract $repository [description]
     */
    public function __construct(IBordereauRepositoryContract $repository) {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|Response|View
     */
    public function index()
    {
        $bordereaux_wf = Workflow::where('model_type', 'App\Models\Bordereau')->first();
        $statuts = $bordereaux_wf ? WorkflowStep::where('workflow_id', $bordereaux_wf->id)->orWhereNull('workflow_id')->get() : null;

        return view('bordereaux.index')
            ->with('perPage', new \Illuminate\Support\Collection(config('system.per_page')))
            ->with('defaultPerPage', config('system.default_per_page'))
            ->with('statuts', $statuts)
            ;
    }

    /**
     * Fetch records.
     *
     * @param  FetchRequest     $request [description]
     * @return SearchCollection          [description]
     */
    public function fetch(FetchRequest $request)
    {
        /*$request->replace([
            'search' => "32",
            'order_by' => "numero_transaction:asc"
        ]);*/
        //dd($request->all());
        return new SearchCollection(
            $this->repository->search($request), BordereauResource::class
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
     * @param  \App\Models\Bordereau  $bordereau
     * @return \Illuminate\Http\Response
     */
    public function show(Bordereau $bordereau)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bordereau  $bordereau
     * @return \Illuminate\Http\Response
     */
    public function edit(Bordereau $bordereau)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bordereau  $bordereau
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bordereau $bordereau)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bordereau  $bordereau
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bordereau $bordereau)
    {
        //
    }
}
