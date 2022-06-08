<?php

namespace App\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorestallRequest;
use App\Http\Requests\UpdatestallRequest;
use App\Imports\StallsImport;
use App\Models\Park;
use App\Models\Stall;
use Illuminate\Http\Request;
use UploadService;

class StallController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //返回所有数据，分頁返回，每页5条，按最新排列

        return Stall::with('park')->orderBy('created_at', 'desc')->paginate(5);

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
     * @param \App\Http\Requests\StorestallRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorestallRequest $request, Park $park)
    {
//        return $request;
        $stall = $park->stalls()->create($request->input());
        $stall->park_id = $request->park_id;
        $stall->save();
        return $this->message('添加成功', $park);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\stall $stall
     * @return \Illuminate\Http\Response
     */
    public function show(stall $stall)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\stall $stall
     * @return \Illuminate\Http\Response
     */
    public function edit(stall $stall)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdatestallRequest $request
     * @param \App\Models\stall $stall
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatestallRequest $request, stall $stall)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\stall $stall
     * @return \Illuminate\Http\Response
     */
    public function destroy(stall $stall)
    {
        $stall->delete();
        return $this->message('删除成功');
    }

    /**
     * 批量添加停車場車位
     */

    public function batch(Request $request)
    {
        $arrForm = $request->arrForm;
        collect($arrForm)->each(function ($item) {
            $stall = new Stall();
            $stall->park_id = $item['park_id'];
            $stall->number = $item['number'];
            $stall->location = $item['location'];
            $stall->save();
        });
        return $this->message('批量添加成功');
    }


    //    批量導入
    public function import(Request $request)
    {
        $attachment = UploadService::local($request->file);
        $filePath = public_path('/files/'.date('Ym').'/').basename($attachment->path);
        $stallImport = new StallsImport();

        try {
            $stallImport->import($filePath);
        } catch (\Maatwebsite\Excel\Exceptions\SheetNotFoundException $e) {
            $failures = $e->failures();

            foreach ($failures as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                $failure->values(); // The values of the row that has failed.
            }
            return $this->message('批量导入失败', $failures);
        }

        //删除临时文件
        unlink($filePath);
        return $this->message('导入成功');
    }


//    級聯通過park_id查找

    public function getStallByPark(Request $request, Park $park)
    {
        //只取stall模型的id,number字段
        return $park->stalls()->get();
    }

}
