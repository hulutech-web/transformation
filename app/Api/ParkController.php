<?php

namespace App\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreParkRequest;
use App\Http\Requests\UpdateParkRequest;
use App\Imports\ParksImport;
use App\Models\Park;
use Illuminate\Http\Request;
use UploadService;

class ParkController extends Controller
{

    public function index()
    {
        return Park::paginate(5);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreParkRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreParkRequest $request)
    {
        $park = Park::create($request->input());
        return $this->message('新增成功', $park);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Park $park
     * @return \Illuminate\Http\Response
     */
    public function show(Park $park)
    {
        return $park;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateParkRequest $request
     * @param \App\Models\Park $park
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateParkRequest $request, Park $park)
    {
        $park->update($request->input());
        return $this->message('更新成功', $park);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Park $park
     * @return \Illuminate\Http\Response
     */
    public function destroy(Park $park)
    {
        $park->delete();
        return $this->message('删除成功');
    }

//提供遠程搜索接口
    public function searchPark(Request $request)
    {
        //最多返回10條,只返回ID與name字段
        $parks = Park::where('name', 'like', '%'.$request->keywords.'%')->limit(10)->get(['id', 'name']);
        return $parks;
    }

//    批量導入
    public function import(Request $request)
    {
        $attachment = UploadService::local($request->file);
        $filePath = public_path('/files/'.date('Ym').'/').basename($attachment->path);
        $parkImport = new ParksImport();

        try {
            $parkImport->import($filePath);
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
}
