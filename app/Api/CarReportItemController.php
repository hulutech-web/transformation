<?php

namespace App\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCarReportItemRequest;
use App\Http\Requests\UpdateCarReportItemRequest;
use App\Models\CarReportItem;
use Illuminate\Http\Request;

class CarReportItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CarReportItem::get(['name', 'title', 'options']);
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
     * @param \App\Http\Requests\StoreCarReportItemRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCarReportItemRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\CarReportItem $carReportItem
     * @return \Illuminate\Http\Response
     */
    public function show(CarReportItem $carReportItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\CarReportItem $carReportItem
     * @return \Illuminate\Http\Response
     */
    public function edit(CarReportItem $carReportItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateCarReportItemRequest $request
     * @param \App\Models\CarReportItem $carReportItem
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCarReportItemRequest $request, CarReportItem $carReportItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\CarReportItem $carReportItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(CarReportItem $carReportItem)
    {
        //
    }

    public function init(Request $request)
    {
        $count = CarReportItem::all()->count();
        if ($count > 0) {
            return $this->error('已经初始化过了');
        }
        $data = $request->fields;
        //循环遍历$data的值，创建carReportItem
        array_map(function ($item) {
            $carReportItem = new CarReportItem();
            $carReportItem->fill($item);
            $carReportItem->save();
        }, $data);
        return $this->message('初始化成功');
    }
}
