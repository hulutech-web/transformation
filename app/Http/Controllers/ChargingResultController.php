<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChargingResultRequest;
use App\Http\Requests\UpdateChargingResultRequest;
use App\Models\ChargingResult;

class ChargingResultController extends Controller
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
     * @param  \App\Http\Requests\StoreChargingResultRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreChargingResultRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ChargingResult  $chargingResult
     * @return \Illuminate\Http\Response
     */
    public function show(ChargingResult $chargingResult)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ChargingResult  $chargingResult
     * @return \Illuminate\Http\Response
     */
    public function edit(ChargingResult $chargingResult)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateChargingResultRequest  $request
     * @param  \App\Models\ChargingResult  $chargingResult
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateChargingResultRequest $request, ChargingResult $chargingResult)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChargingResult  $chargingResult
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChargingResult $chargingResult)
    {
        //
    }
}
