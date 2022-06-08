<?php

namespace App\Services\Convert;

use App\Models\CarReport;
use App\Models\User;
use Auth;

/**
 * 文档转换服务
 * @package App\Services
 */
class ConvertService
{
    public function handleCarReport(CarReport $carreport)
    {
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
        //通过$carreport->user_id查到用户名
        $user_id = $carreport->user_id;
        $user = User::find($user_id);
        $user_name = $user->name;
//        设置UTF8
        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // 设置文档信息
        $pdf->SetCreator('yh');
        $pdf->SetAuthor('yh');
        $pdf->SetTitle('yh');
        $pdf->SetSubject('yh');
        $pdf->SetKeywords('TCPDF, PDF, PHP');
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        // 设置页眉和页脚信息
        $pdf->SetHeaderData('', 0, env('APP_NAME'), '汽車檢查保養報告', [0, 64, 255], [0, 64, 128]);
        $pdf->setFooterData([0, 64, 0], [0, 64, 128]);

        // 设置页眉和页脚字体
        $pdf->setHeaderFont(['droidsansfallback', '', '10']);
        $pdf->setFooterFont(['droidsansfallback', '', '8']);

        // 设置默认等宽字体
        $pdf->SetDefaultMonospacedFont('droidsansfallback');

        // 设置间距
        $pdf->SetMargins(15, 15, 15);//页面间隔
        $pdf->SetHeaderMargin(5);//页眉top间隔
        $pdf->SetFooterMargin(10);//页脚bottom间隔

        // 设置分页
        $pdf->SetAutoPageBreak(true, 25);

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);


        //设置字体 stsongstdlight支持中文(有些浏览器测试不正常，EDGE乱码，firefox正常)
        $pdf->SetFont('stsongstdlight', '', 12);
//        $pdf->SetFont('droidsansfallback', '', 20);
//        获取维修项目数量
        $repair_project_count = count($repair_project);
        $this->sectionTitle($pdf, $company_name);
        $this->sectionIntro($pdf, $report_date, $car_number, $car_type, $car_brand, $mileage);
        $this->sectionProject($pdf, $repair_project, $total_cost);
        $this->sectionReport($pdf, $content_brief);
//        $pdf->Ln(20);//换行符

        $this->sectionRemark($pdf, $remark, $user_name, $repair_project_count);

        $this->sectionImage($pdf, $attachment, $car_brand);

//        獲取創建時間按照時分秒格式化
        $time = $carreport->created_at;

        $filename = $car_type.'_'.$car_brand.'_'.$car_number.'_'.$time.'.pdf';

        $pdf->Output($filename, 'I');//I输出、D下载
    }


//    标题部分
    protected function sectionTitle($pdf, $company_name)
    {
//第一页
        $pdf->AddPage();
        $html = <<<EOF
<table>
<tbody>
<tr>
<th colspan="4" style="text-align: center;font-weight:bold;">$company_name<br/><span style="font-size:14px;">INSTITUTO PARA OS<br/>
ASSUNTOS MUNICIPAIS</span>
</th>
<th colspan="2"></th>
<th colspan="2" style="text-align: end">
<span style="font-size:12px;text-align: end">
<br/><br/>萬眾汽車維修中心<br/>
     車輛保養檢查報告
     </span>
</th>
</tr>

</tbody>
</table>

EOF;

        $pdf->writeHTML($html, true, false, true, false, '');
    }

//    简介部分
    protected function sectionIntro($pdf, $report_date, $car_number, $car_type, $car_brand, $mileage)
    {
        $html = <<<EOF
<style>
    table {
        font-size: 12pt;
        border: 1px solid black;
        padding: 3px;
    }
    th {
        border: 1px solid black;
        padding: 3px;
    }
    td {
        border: 1px solid black;
        padding: 3px;
    }
</style>
<div style="width:100%;">
<table>
<tbody>
<tr>
<th>日期:</th>
<th>$report_date</th>
<th>車牌號碼:</th>
<th>$car_number</th>
<th> 牌子: </th>
<th>$car_type</th>
</tr>
</tbody>
</table>

<table>
<tbody>
<tr>
<th colspan="2"> 型號: </th>
<th colspan="2">$car_brand</th>
<th colspan="2"> 行車里數:</th>
<th>$mileage</th>
<th>公里</th>
</tr>
</tbody>
</table>

</div>

EOF;
        $pdf->writeHTML($html, true, false, true, false, '');
    }

//    项目概要
    protected function sectionProject($pdf, $repair_project, $total_cost)
    {
        $title = '檢 查 保 養 及 維 修 項 目';
        $html = <<<EOF
<style>
    table {
        font-size: 12pt;
        border: 1px solid black;
        padding: 3px;
    }
    th {
        border: 1px solid black;
        padding: 3px;
    }
    td {
        border: 1px solid black;
        padding: 3px;
    }
</style>
EOF;
        $html .= <<<EOF
<table>
<tbody>
<tr>
<th colspan="8">$title</th>
</tr>
EOF;
//        如果没有项目返回空，如果有项目依次循环
        if (count($repair_project) === 0) {
            return;
        } else {
            for ($i = 1; $i < count($repair_project) + 1; $i++) {
                $html .= <<<EOF
<tr>
<th colspan="1">$i</th>
EOF;
                //将json转换为数组
                $repair_project_item = $repair_project[$i - 1]['value'];
                $html .= <<<EOF
<th colspan="7">$repair_project_item</th>
</tr>

EOF;
            }
        }

        $html .= <<<EOF
<tr>
<th colspan="7" style="text-align: right;">評估費用合計：</th>
<th colspan="1">MOP$total_cost</th>
</tr>
EOF;
        $html .= <<<EOF
</tbody>
</table>
EOF;
        $pdf->writeHTML($html, true, false, true, false, '');
    }

//    简报部分
    protected function sectionReport($pdf, $content_report)
    {
        $title = '本 次 車 輛 保 養 項 目 內 容 簡 報';
        $status1 = '正常';
        $status2 = '更換';
        $status3 = '建議更換';

        $html = <<<EOF
<style>
    table {
        font-size: 12pt;
        border: 1px solid black;
        padding: 3px;
    }
    th {
        border: 1px solid black;
        padding: 3px;
    }
    td {
        border: 1px solid black;
        padding: 3px;
    }
</style>

EOF;
        $html .= <<<EOF
<table>
<tbody style="width:100%;">
<tr>
<th width="400" colspan="2">$title</th>
<th width="80">$status1</th>
<th width="80">$status2</th>
<th width="80">$status3</th>
</tr>
EOF;
//        #region
        for ($i = 0; $i < count($content_report); $i++) {
            $content_report_item = $content_report[$i];
            $content_report_item_title = $content_report_item['title'];
            $order = $i + 1;
            if ($content_report_item['value'] === "正常") {
                $html .= <<<EOF
<tr>
<th width="70">$order</th>
<th width="330">$content_report_item_title</th>
<th width="80">☑</th>
<th width="80">□</th>
<th width="80">□</th>
</tr>
EOF;
            } elseif ($content_report_item['value'] === "更換") {
                $html .= <<<EOF
<tr>
<th width="70">$order</th>
<th width="330">$content_report_item_title</th>
<th width="80">□</th>
<th width="80">☑</th>
<th width="80">□</th>
</tr>
EOF;
            } elseif ($content_report_item['value'] === "建議更換") {

                $html .= <<<EOF
<tr>
<th width="70">$order</th>
<th width="330">$content_report_item_title</th>
<th width="80">□</th>
<th width="80">□</th>
<th width="80">☑</th>
</tr>
EOF;
            } else {
                return;
            }
        }

        $html .= <<<EOF
</tbody>
</table>
EOF;
        $pdf->writeHTML($html, true, false, true, false, '');


    }

//    备注部分
    protected function sectionRemark($pdf, $remark, $user_name, $repair_project_count)
    {
        if ($repair_project_count > 7) {
            //添加新页面
            $pdf->AddPage();
        }

        $title = '備 註';
        $html = <<<EOF
<style>
    table {
        font-size: 12pt;
        border: 1px solid black;
        padding: 3px;
    }
    th {
        border: 1px solid black;
        padding: 3px;
    }
    td {
        border: 1px solid black;
        padding: 3px;
    }
</style>
EOF;
        $html .= <<<EOF
<table>
<tbody>
<tr>
<th colspan="8">$title</th>
</tr>
<tr>
<th colspan="8">$remark</th>
</tr>
<tr>
<td colspan="7" style="text-align: right">維修人員:$user_name</td>
<td colspan="1"><img src="images/logo.png" width="25" height="25" alt=""></td>
</tr>

</tbody>
</table>
EOF;

        $pdf->writeHTML($html, true, false, true, false, '');
    }

//    图片部分
    protected function sectionImage($pdf, $attachment, $car_brand)
    {
        $title = $car_brand.'驗車數據圖';
        $html = <<<EOF
<style>
    table {
        font-size: 12pt;
        border: 1px solid black;
        padding: 3px;
    }
    th {
        border: 1px solid black;
        padding: 3px;
    }
    td {
        border: 1px solid black;
        padding: 3px;
    }
</style>
EOF;
        $html .= <<<EOF
<table>
<tbody style="width:100%;">
<tr>
<th colspan="2">$title</th>
</tr>
EOF;
        //每张图片显示高度
        $imageHeight = 120;

        for ($i = 0; $i < count($attachment); $i++) {
            $imgUrl = str_replace(env('APP_URL'), '', $attachment[$i]);
//            /attachments/202206/wPqKnkbJ1j2q3vNHNHZBGS282PKJZXfyQ1EQ9QC6.jpg
//            显示图片，每行显示2张图片，每页最多显示10张图片
            if ($i % 2 == 0) {
                if ($i == count($attachment) - 1) {
                    $html .= <<<EOF
<tr>
<th colspan="1"><img src="$imgUrl"   height="$imageHeight"></th>
</tr>
EOF;
                } else {
                    $html .= <<<EOF
<tr>
<th colspan="1"><img src="$imgUrl"   height="$imageHeight"></th>
EOF;
                }

            } else {
                $html .= <<<EOF
<th colspan="1"><img src="$imgUrl"   height="$imageHeight"></th>
</tr>
EOF;
            }

        }
        $html .= <<<EOF
</tbody>
</table>

EOF;
        $pdf->writeHTML($html, true, false, true, false, '');
    }
    

}
