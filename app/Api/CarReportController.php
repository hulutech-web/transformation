<?php

namespace App\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCarReportRequest;
use App\Http\Requests\UpdateCarReportRequest;
use App\Models\CarReport;
use Auth;
use ConvertService;
use Illuminate\Http\Request;
use ModifyExcelService;

class CarReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carReports = CarReport::paginate(5);
        return $carReports;
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


    public function store(StoreCarReportRequest $request)
    {
        $carReport = CarReport::create($request->input());
        $carReport->user_id = Auth::id();
        $carReport->save();
        return $this->message('添加成功');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\CarReport $carReport
     * @return \Illuminate\Http\Response
     */
    public function show(CarReport $carReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\CarReport $carReport
     * @return \Illuminate\Http\Response
     */
    public function edit(CarReport $carReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateCarReportRequest $request
     * @param \App\Models\CarReport $carReport
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCarReportRequest $request, CarReport $carReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\CarReport $carReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(CarReport $carreport)
    {
        /**
         * 删除$carreport中的attachment中的图片【根据客户需求确定】
         */
        $attachment = $carreport->attachment;

        foreach ($attachment as $key => $value) {
            unlink(public_path().str_replace(env('APP_URL'), '', $value));
        }

        $carreport->delete();

        return $this->message('删除成功');
    }

    public function export(Request $request, CarReport $carreport)
    {
        return $this->modifyExcel($carreport);
    }

    // 修改EXCEL
    protected function modifyExcel(CarReport $carreport)
    {
        return ModifyExcelService::handleData($carreport);
    }

//    转换pdf
    public function exportpdf(Request $request, CarReport $carreport)
    {
        return ConvertService::doConvert();
    }


}
