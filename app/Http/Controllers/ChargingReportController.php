<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChargingReportRequest;
use App\Http\Requests\UpdateChargingReportRequest;
use App\Models\ChargingReport;

class ChargingReportController extends Controller
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
     * @param  \App\Http\Requests\StoreChargingReportRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreChargingReportRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ChargingReport  $chargingReport
     * @return \Illuminate\Http\Response
     */
    public function show(ChargingReport $chargingReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ChargingReport  $chargingReport
     * @return \Illuminate\Http\Response
     */
    public function edit(ChargingReport $chargingReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateChargingReportRequest  $request
     * @param  \App\Models\ChargingReport  $chargingReport
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateChargingReportRequest $request, ChargingReport $chargingReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChargingReport  $chargingReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChargingReport $chargingReport)
    {
        //
    }
}
