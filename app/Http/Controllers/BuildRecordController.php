<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBuildRecordRequest;
use App\Http\Requests\UpdateBuildRecordRequest;
use App\Models\BuildRecord;

class BuildRecordController extends Controller
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
     * @param  \App\Http\Requests\StoreBuildRecordRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBuildRecordRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BuildRecord  $buildRecord
     * @return \Illuminate\Http\Response
     */
    public function show(BuildRecord $buildRecord)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BuildRecord  $buildRecord
     * @return \Illuminate\Http\Response
     */
    public function edit(BuildRecord $buildRecord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBuildRecordRequest  $request
     * @param  \App\Models\BuildRecord  $buildRecord
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBuildRecordRequest $request, BuildRecord $buildRecord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BuildRecord  $buildRecord
     * @return \Illuminate\Http\Response
     */
    public function destroy(BuildRecord $buildRecord)
    {
        //
    }
}
