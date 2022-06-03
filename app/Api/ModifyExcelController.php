<?php

namespace App\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use ModifyExcelService;

class ModifyExcelController extends Controller
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function testExcel()
    {
//        $file = public_path('excel/test.xlsx');
//        $reader = \PHPExcel_IOFactory::createReader('Excel2007');
//        $PHPExcel = $reader->load($file);
//        $sheet = $PHPExcel->getSheet(0);
//        $highestRow = $sheet->getHighestRow();
//        $highestColumn = $sheet->getHighestColumn();
//        $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
//        $excelData = [];
//        for ($row = 1; $row <= $highestRow; $row++) {
//            for ($col = 0; $col < $highestColumnIndex; $col++) {
//                $excelData[$row][] = (string)$sheet->getCellByColumnAndRow($col, $row)->getValue();
//            }
//        }
//        dd($excelData);

        ModifyExcelService::modify();
    }
}
