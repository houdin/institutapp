<?php

namespace App\Http\Controllers\Projects;

use App\Models\Premium;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PremiumController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $premiums = Premium::where('published', 1)->get();




        return Inertia::render('Tarifs/TarifIndex', ['tarifs' => $premiums]);
    }

    public function premiums()
    {

        $premiums = Premium::where('published', 1)->get();

        return response()->json([
            'premiums' => $premiums,

        ]);
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
     * @param  \App\Models\Premium  $premium
     * @return \Illuminate\Http\Response
     */
    public function show(Premium $premium)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Premium  $premium
     * @return \Illuminate\Http\Response
     */
    public function edit(Premium $premium)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Premium  $premium
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Premium $premium)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Premium  $premium
     * @return \Illuminate\Http\Response
     */
    public function destroy(Premium $premium)
    {
        //
    }
}
