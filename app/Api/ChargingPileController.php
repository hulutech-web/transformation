<?php

namespace App\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChargingPileRequest;
use App\Http\Requests\UpdateChargingPileRequest;
use App\Imports\ChargingPileImport;
use App\Models\ChargingPile;
use App\Models\Stall;
use Illuminate\Http\Request;
use UploadService;

class ChargingPileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ChargingPile::paginate(5);
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
     * @param \App\Http\Requests\StoreChargingPileRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreChargingPileRequest $request)
    {
        //关联创建
        $stall = Stall::find($request->stall_id);
        $chargingPile = $stall->chargingPile()->create($request->input());
//        $chargingPile = ChargingPile::create($request->input());
        return $this->message('新增成功', $chargingPile);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\ChargingPile $chargingPile
     * @return \Illuminate\Http\Response
     */
    public function show(ChargingPile $chargingPile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\ChargingPile $chargingPile
     * @return \Illuminate\Http\Response
     */
    public function edit(ChargingPile $chargingPile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateChargingPileRequest $request
     * @param \App\Models\ChargingPile $chargingPile
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateChargingPileRequest $request, ChargingPile $chargingPile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\ChargingPile $chargingPile
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChargingPile $chargingpile)
    {
        $chargingpile->delete();
        return $this->message('删除成功');
    }

    //    批量導入
    public function import(Request $request)
    {
        $attachment = UploadService::local($request->file);
        $filePath = public_path('/files/'.date('Ym').'/').basename($attachment->path);
        $stallImport = new ChargingPileImport();

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

    public function getChargingPileByStall(Request $request, Stall $stall)
    {
        return $stall->ChargingPile;
    }
}
