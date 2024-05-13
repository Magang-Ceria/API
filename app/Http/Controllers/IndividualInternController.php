<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IndividualIntern;
use App\Http\Requests\UpdateIndividualInternRequest;
use App\Http\Requests\StoreIndividualInternRequest;

class IndividualInternController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return IndividualIntern::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIndividualInternRequest $request)
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
    public function update(UpdateIndividualInternRequest $request, IndividualIntern $individualIntern)
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
