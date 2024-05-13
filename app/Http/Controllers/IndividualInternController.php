<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndividualInternRequest;
use App\Models\IndividualIntern;
use Illuminate\Http\Request;

class IndividualInternController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return IndividualIntern::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IndividualInternRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(IndividualIntern $individualIntern)
    {
        // return
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IndividualInternRequest $request, IndividualIntern $individualIntern)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IndividualIntern $individualIntern)
    {
        //
    }
}
