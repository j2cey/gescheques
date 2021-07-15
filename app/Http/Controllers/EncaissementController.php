<?php

namespace App\Http\Controllers;

use App\Models\Encaissement;
use Illuminate\Http\Request;
use App\Models\FileImportResult;
use App\Models\EncaissementsFile;
use App\Imports\EncaissementsImport;
use Maatwebsite\Excel\Facades\Excel;

class EncaissementController extends Controller
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

        $new_encaissementsfile = EncaissementsFile::create([
            'fichier' => $formInput['fichier'],
        ]);

        $new_encaissementsfile->verifyAndStoreFile( $request, "fichier_encaissements", "fichier", "encaissements_files", $oldfile = ' ' );
        $new_import_result = FileImportResult::create([
            'report' => json_encode([]),
        ]);
        $new_encaissementsfile->fileimportresult()->associate($new_import_result)->save();

        //Excel::import(new EncaissementsImport($new_encaissementsfile->fileimportresult), config('app.encaissements_files') . '/' . $new_encaissementsfile->fichier);
    }
}
