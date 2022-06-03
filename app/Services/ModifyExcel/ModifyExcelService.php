<?php

namespace App\Services\ModifyExcel;

use app\Models\CarReport;
use Auth;

/**
 * 修改Excel服务
 * @package App\Services
 */
class ModifyExcelService
{
    public function handleData(CarReport $carreport)
    {
        //設置語言

        $company_name = $carreport->company_name;
        $report_date = $carreport->report_date;
        $car_number = $carreport->car_number;
        $car_type = $carreport->car_type;
        $car_brand = $carreport->car_brand;
        $mileage = $carreport->mileage;
        $repair_project = $carreport->repair_project;
        $total_cost = $carreport->total_cost;
        $content_brief = $carreport->content_brief;
        $remark = $carreport->remark;
        $attachment = $carreport->attachment;

        // 讀取public目錄下的pdf目錄下的carReport.xls文件
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(public_path('pdf/carReport.xlsx'));
        // 讀取第一個工作表
        $sheet = $spreadsheet->getActiveSheet();
        // 將讀取的數據放入到指定的位置並保存
        /**
         * 1、第一部分（固定部分）
         */
        $sheet->setCellValue('A1', $company_name);
        $sheet->setCellValue('B3', $report_date);
        $sheet->setCellValue('E3', $car_number);
        $sheet->setCellValue('H3', $car_brand);

        $sheet->setCellValue('B4', $car_type);
        $sheet->setCellValue('H4', $mileage);
        /**
         * END第一部分（固定部分）
         */


        /**
         * 2、第二部分（可變部分）
         */
        $i = 6;
        //獲取$repair_project的長度
        $repair_project_length = count($repair_project);
        //插入$repair_project_length行
        for ($j = 0; $j < $repair_project_length; $j++) {
            $sheet->insertNewRowBefore($i, 1);
            $sheet->setCellValue('A'.$i, $i - 5);
            $sheet->setCellValue('B'.$i, $repair_project[$j]['value']);
            $i++;
        }
        //設置合計金額
        $sheet->setCellValue('I'.$i, $total_cost);
        /**
         * END第二部分（可變部分）
         */


        $k = $i + 3;
        foreach ($content_brief as $content) {
            //設置序號從1開始，減去2
            $sheet->setCellValue('A'.$k, $k - $i - 2);
            $sheet->setCellValue('B'.$k, '檢查 : '.$content['title']);
            //            如果$value的值為正常，更換，建議更換
            switch ($content['value']) {
                case '正常':
                    $sheet->setCellValue('F'.$k, '☑');
                    break;
                case '更換':
                    $sheet->setCellValue('G'.$k, '☑');
                    break;
                case '建議更換':
                    $sheet->setCellValue('H'.$k, '☑');
                    break;
            }
            $k++;
        }


        //備註部分
        $sheet->setCellValue('A'.$k + 1, '此次維修保養內容為：'.$remark);
        //寫入維修人員

        $sheet->setCellValue('A'.$k + 2, '維修人員：'.Auth::user()->name);
        //


        $k = $k + 5;
        $sheet->setCellValue('A'.$k, $car_number.'驗車數據圖');


        $m = $k + 1;
        // 放置圖片
        $imgs = $carreport->attachment;
        //        $imgResource = file_get_contents(public_path($imgUrl));
        $sheet->insertNewRowBefore($m, 1);
        $letters = ['A', 'B', 'C', 'D', 'E', 'F'];
        for ($y = 0; $y < count($imgs); $y++) {
            $imgUrl = str_replace(env('APP_URL'), '', $imgs[$y]);
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setPath(public_path($imgUrl));
            $spreadsheet->getActiveSheet()->getRowDimension($m)->setRowHeight(400, 'pt');
            $drawing->setHeight(400);
            $drawing->setWidth(600);
            $drawing->setCoordinates('A'.$m);
            $drawing->setWorksheet($sheet);
            $m++;
        }

        $date = date('Y-m-dH:i:s');
        // 將修改的數據寫入到指定的文件
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'carReport'.$date;
        $writer->save(public_path('pdf/outputExcel/'.$filename.'.xlsx'));
        $pdfWriter = new \PhpOffice\PhpSpreadsheet\Writer\Pdf\Dompdf($spreadsheet);
        $pdfWriter->save(public_path('pdf/outputPdf/'.$filename.'.pdf'));

        //删除清空：
//        $spreadsheet->disconnectWorksheets();
    }

}
