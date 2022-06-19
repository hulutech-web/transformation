<?php

namespace App\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCarinfoRequest;
use App\Http\Requests\UpdateCarinfoRequest;
use App\Models\Carinfo;
use Illuminate\Http\Request;

class CarinfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Carinfo::paginate(10);
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
     * @param \App\Http\Requests\StoreCarinfoRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCarinfoRequest $request)
    {
        Carinfo::create($request->all());
        return $this->message('添加成功');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Carinfo $carinfo
     * @return \Illuminate\Http\Response
     */
    public function show(Carinfo $carinfo)
    {
        return $carinfo;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Carinfo $carinfo
     * @return \Illuminate\Http\Response
     */
    public function edit(Carinfo $carinfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateCarinfoRequest $request
     * @param \App\Models\Carinfo $carinfo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCarinfoRequest $request, Carinfo $carinfo)
    {
        $carinfo->update($request->all());
        return $this->message('更新成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Carinfo $carinfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Carinfo $carinfo)
    {
        $carinfo->delete();
        return $this->message('删除成功');
    }


    public function searchCarInfo(Request $request)
    {
        //按照公司名称或者车牌号搜索
        $carinfo = Carinfo::where('company_name', 'like', '%'.$request->keywords.'%')->get(['company_name', 'car_type', 'car_number', 'car_brand']);
        return $carinfo;
    }
}
