<?php

namespace App\Http\Controllers;

use App\Models\BordereauremiseLoc;
use Illuminate\Http\Request;

class BordereauremiseLocController extends Controller
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
        $bordereauremiseLocs = BordereauremiseLoc::orderBy('titre','ASC')->get();

        return $bordereauremiseLocs;
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
     * @param BordereauremiseLoc $bordereauremiseLoc
     * @return \Illuminate\Http\Response
     */
    public function show(BordereauremiseLoc $bordereauremiseloc)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param BordereauremiseLoc $bordereauremiseloc
     * @return \Illuminate\Http\Response
     */
    public function edit(BordereauremiseLoc $bordereauremiseloc)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param BordereauremiseLoc $bordereauremiseloc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BordereauremiseLoc $bordereauremiseloc)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BordereauremiseLoc $bordereauremiseloc
     * @return \Illuminate\Http\Response
     */
    public function destroy(BordereauremiseLoc $bordereauremiseloc)
    {
        //
    }
}
