<?php

namespace App\Services\ConvertCharging;

use App\Models\ChargingReportField;
use App\Models\Stall;
use Auth;

/**
 * 充電樁PDF生成服务
 * @package App\Services
 */
class ConvertChargingService
{
    public function handleChargingReport($chargingResource)
    {
        //            $pdf->Ln(2);//换行符
        //從$chargingResource中獲取data
        $report_date = collect($chargingResource)->get('report_date');;
        $park_name = collect($chargingResource)->get('park_name');
        $stall_ids = collect($chargingResource)->get('stall_ids');
        $remark = collect($chargingResource)->get('remark');
        $user_id = collect($chargingResource)->get('user_id');
        $park_id = collect($chargingResource)->get('park_id');
        $chargingResults = collect($chargingResource)->get('chargingResults');
        $user_name = collect($chargingResource)->get('user_name');
        $stalls = collect($chargingResource)->get('stalls');
        $chargingPiles = collect($chargingResource)->get('chargingPiles');
        $pdf = $this->preparePdf();
        //第一阶段：设置头部信息

        $this->setHeaderSection($pdf, $park_name, $report_date);

//第二階段：设置充電樁信息
        $this->setContentSection($pdf, $chargingResults, $chargingPiles, $remark, $user_name, $report_date);
        $time = $chargingResource->created_at;

        $filename = $time.'.pdf';

        $pdf->Output($filename, 'I');//I输出、D下载
    }


    /**
     * 准备PDF
     * @return \TCPDF
     */
    public function preparePdf()
    {
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
//        $pdf->SetHeaderData('', 0, env('APP_NAME'), '充电桩檢查保養報告', [0, 64, 255], [0, 64, 128]);
        $pdf->setFooterData([0, 64, 0], [0, 64, 128]);

        // 设置页眉和页脚字体
        $pdf->setHeaderFont(['droidsansfallback', '', '8']);
        $pdf->setFooterFont(['droidsansfallback', '', '8']);

        // 设置默认等宽字体
        $pdf->SetDefaultMonospacedFont('droidsansfallback');

        // 设置间距
        $pdf->SetMargins(15, 15, 15);//页面间隔
        $pdf->SetHeaderMargin(5);//页眉top间隔
        $pdf->SetFooterMargin(5);//页脚bottom间隔

        // 设置分页
        $pdf->SetAutoPageBreak(true, 0);

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);
        $pdf->Ln(3);

        //设置字体 stsongstdlight支持中文(有些浏览器测试不正常，EDGE乱码，firefox正常)
        $pdf->SetFont('stsongstdlight', '', 12);
        return $pdf;
    }

    /**
     * 设置头部信息
     */
    public function setHeaderSection($pdf, $park_name, $report_date)
    {
        $narmalName = "澳門電力設備有限公司";
        $narmalEng = "Combpanihia de  Eletricidade de Macau-CEM，S.A.";
        $title = "電動車充電設施季度檢查報告";
        //添加新页面
        $pdf->AddPage();
        $html = <<<EOF
<style>
    table {
        font-size: 12pt;
        border: 1px solid black;
        padding: 2px;
    }
    th {
        border: 1px solid black;
        padding: 2px;
    }
    td {
        border: 1px solid black;
        padding: 2px;
    }
</style>

EOF;
        $html .= <<<EOF
<table>
<tbody>
<tr>
<th colspan="7" style="text-align: left;font-size: 0.6em;">$narmalName<br/>$narmalEng</th>
<th colspan="3"><img src="images/elelogo.jpeg" width="80" height="60" alt=""></th>
</tr>
</tbody>
</table>

EOF;

        $html .= <<<EOF
<table>
<tbody>
<tr>
<th colspan="7" style="text-align: center;font-size: 1.2em;text-decoration: underline;">
<span>$title</span>
</th>
</tr>

</tbody>
</table>
EOF;
        $html .= <<<EOF
<table>
<tbody>
<tr>
<th colspan="7" style="text-align: left;font-size: 0.6em;">地點：$park_name</th>
<th colspan="7" style="text-align: left;font-size: 0.6em;">檢查日期：$report_date</th>
</tr>
</tbody>
</table>

EOF;
        $pdf->writeHTML($html, true, false, true, false, '');
    }

    /**
     * 設置內容區域
     */
//添加8份有问题，数据有问题(初步判断为前端问题)
    public function setContentSection($pdf, $chargingResults, $chargingPiles, $remark, $user_name, $report_date)
    {
        //构造范围数组，每组5个[【0-4】,【5-9】,【10-14】。。。]
        $range = $this->makeArray(count($chargingResults), 5);
        //表示第几组
        $curGroup = 0;


        $pileLength = count($chargingPiles);

//        获取报告选项
        $resultOptions = include config_path()."/chargeFields.php";
        $html = $this->showStyle(null);
        $resultLength = count($chargingResults);
        if ($pileLength >= 5) {
            for ($i = 0; $i < $pileLength; $i++) {
//#region第一部分：获取参数
                //序号
                $model_id = collect($chargingPiles[$i])->get('id');
                $device_id = collect($chargingPiles[$i])->get('device_id');
                $brand = collect($chargingPiles[$i])->get('brand');
                $model = collect($chargingPiles[$i])->get('model');
                $stall_id = collect($chargingPiles[$i])->get('stall_id');
                $stall_number = Stall::find($stall_id)->number;
                if ($i % 5 == 0) {
                    //充电桩信息，每5个为一组，如果是5的倍数，渲染表头
                    if ($i != 0) {
//                    留出部分空白
                        $html .= '<div style="page-break-after: always;"></div>';
                    }
                    $html .= <<<EOF
<table>
<tbody>
<tr>
<th  style="text-align: left;font-size: 0.6em;background-color:#60A5FA;color:white;">編號ID
</th>
<th style="text-align: left;font-size: 0.6em;background-color:#60A5FA;color:white;">充電站ID
</th>
<th style="text-align: left;font-size: 0.6em;background-color:#60A5FA;color:white;">品牌
</th>
<th style="text-align: left;font-size: 0.6em;background-color:#60A5FA;color:white;">型號
</th>

<th  style="text-align: left;font-size: 0.6em;background-color:#60A5FA;color:white;">車位編號
</th>

</tr>
</table>
</tbody>
EOF;
                }

                //充电桩信息，每5个为一组，如果是5的倍数，表示为内容行，直接渲染
                $html .= <<<EOF
<table>
<tbody>
<tr>
<th  style="text-align: left;font-size: 0.6em;">
$model_id
</th>
<th style="text-align: left;font-size: 0.6em;">$device_id
</th>
<th style="text-align: left;font-size: 0.6em;">$brand
</th>
<th style="text-align: left;font-size: 0.6em;">$model
</th>

<th  style="text-align: left;font-size: 0.6em;">$stall_number
</th>
</tr>
</table>
</tbody>
EOF;
//#endregion end第一部分END：获取参数
//===========================================================


//如果是5的倍数，说明当前组已经渲染完成，接下来渲染充电桩报告内容，因报告数量与充电桩数量一致，排除最后一组为5的倍数，
//而是数据相同时直接渲染，这样可以包含多个5的倍数，最后一组始终会显示

                if (($i + 1) % 5 == 0 || $i == $pileLength - 1) {
                    //获取充电桩长度，当长度是5的倍数时，渲染表头，否则直接渲染内容
                    for ($j = 0; $j < $resultLength; $j++) {
//+++++++++++++++++++++++++++++++

                        if (($j + 1) % 5 == 0) {
//                        第二部分：报告详情标题部分P\F\N
                            $html .= <<<EOF
<table>
<tbody>
<tr>
<th colspan="5" style="font-size: .7em;"></th>
<th colspan="5" style="font-size: .7em;text-align: center;">P=通過        F=失敗       N=不適用</th>
</tr>
</tbody>
</table>
<table>
<tbody>
  <tr>
    <td colspan="1" rowspan="2"  style="font-size: .7em;text-align: center;" ><br/>編號</td>
    <td colspan="5" rowspan="2"  style="font-size: .7em;text-align: center;"><br/>描述</td>
    <td colspan="5" align="center" style="font-size: .7em;">結果</td>
  </tr>
  <tr>
EOF;
//                        结果的列数，是根据当前组的充电桩数量来计算的，当前判断条件已经是5的倍数，则开始循环渲染
//                        要去匹配充电桩的ID号，如果相同，则渲染，如果不同，则跳过

                            for ($t = $range[$curGroup][0]; $t <= $range[$curGroup][count($range[$curGroup]) - 1]; $t++) {
                                $charging_pile_id = collect(collect($chargingResults[$t])->get('result'))->get('device_id');
                                $html .= <<<EOF
    <td colspan="1">
    <span style="font-size: .7em;text-align: center;"> $charging_pile_id</span>
    </td>
EOF;
                            }

                            $html .= <<<EOF
  </tr>
</tbody>
</table>
EOF;
//=========================================
                            $curGroup++;
//                        获取充电桩内容信息，渲染内容信息。（报告的选项固定的）
//从配置文件中读取选项（$resultOptions）避免多次引入，提高效率
//                        读取配置项

                            collect($resultOptions)->each(function ($resultOption, $key) use (&$html, $range, $curGroup, $j, $chargingResults, $chargingPiles, $model_id) {
                                $outer_field_id = $resultOption['field_id'];
                                $outer_field_name = $resultOption['field_name'];
//                            分组分割标题
                                $html .= <<<EOF
<table>
<tbody>
<tr>
<th colspan="1" style="font-size: .7em;background-color:#60A5FA;color:white;">$outer_field_id</th>
<th colspan="5"  style="font-size: .7em;background-color:#60A5FA;color:white;">$outer_field_name</th>
<th colspan="5" style="font-size: .7em;background-color:#60A5FA;color:white;"></th>
</tr>
</tbody>
</table>

EOF;

//$chargingPiles中有一个model_id，对应充电桩的ID号，为保证顺序一致，用model_id来查找充电桩报告结果
                                //因报告结果是横向排列，定义一个数组，用来存储每一个充电桩的报告结果
                                $pileLength = count($chargingPiles);

                                $resData = [];
                                for ($i = 0; $i < $pileLength; $i++) {
                                    collect($chargingResults)->each(function ($chargingResult) use ($chargingPiles, $range, $curGroup, $i, &$resData) {
                                        if ($chargingResult['charging_pile_id'] == $chargingPiles[$i]['id']) {
                                            $charging_result = collect(collect($chargingResult)->get('result'))->get('resultData');
                                            $res = collect($charging_result)->map(function ($item) {
                                                return collect(collect($item)->get('field_options'))->map(function ($f) {
                                                    return [
                                                        'afield_id' => $f['field_id'],
                                                        'afield_name' => $f['field_name'],
                                                        'avalue' => $f['value'],
                                                    ];
                                                });
                                            });
                                            array_push($resData, $res);
                                        }
                                    });
                                }

                                $formatData = $this->formatDisplayData($resData, 5);

                                collect($formatData[$key])->map(function ($showData) use (&$html, $range, $curGroup) {
                                    $showData_id = $showData['field_id'];
                                    $showData_title = $showData['field_name'];
//$showData['value']中的数组合并为字符串

                                    $html .= <<<EOF
<table>
<tbody>
<tr>
<th colspan="1" style="font-size: .7em;">$showData_id</th>
<th colspan="5" style="font-size: .7em;">$showData_title</th>

EOF;

                                    $showData_value_array = $showData['value'];

                                    $Arange = $this->makeArray(count($showData_value_array), 5);
//                                    [0-4][5,10]
                                    $groupLength = 0;
                                    for ($x = $Arange[$curGroup - 1][0]; $x <= $Arange[$curGroup - 1][count($Arange[$curGroup - 1]) - 1]; $x++) {
                                        $groupLength = count($Arange[$curGroup - 1]);
                                        $overValue = $showData_value_array[$x];


                                        $html .= <<<EOF
<th colspan="1"  style="font-size: .7em;text-align: center">$overValue</th>
EOF;


                                        //始终保持有5个单元格，如果有多余的单元格，则填充空白


                                    }
                                    switch ($groupLength) {
                                        case 1:
                                            $html .= <<<EOF
<td colspan="1">
    <span style="font-size: .7em;text-align: center;"></span>
</td>
<td colspan="1">
    <span style="font-size: .7em;text-align: center;"></span>
</td>
<td colspan="1">
    <span style="font-size: .7em;text-align: center;"></span>
</td>
<td colspan="1">
    <span style="font-size: .7em;text-align: center;"></span>
</td>
EOF;
                                            break;
                                        case 2:
                                            $html .= <<<EOF
<td colspan="1">
    <span style="font-size: .7em;text-align: center;"></span>
</td>
<td colspan="1">
    <span style="font-size: .7em;text-align: center;"></span>
</td>
<td colspan="1">
    <span style="font-size: .7em;text-align: center;"></span>
</td>
EOF;
                                            break;
                                        case 3:
                                            $html .= <<<EOF
<td colspan="1">
    <span style="font-size: .7em;text-align: center;"></span>
</td>
<td colspan="1">
    <span style="font-size: .7em;text-align: center;"></span>
</td>
EOF;
                                            break;
                                        case 4:
                                            $html .= <<<EOF
<td colspan="1">
    <span style="font-size: .7em;text-align: center;"></span>
</td>
EOF;
                                            break;
                                    }
//=======================================================

                                    $html .= <<<EOF
</tr>
</tbody>
</table>
EOF;


                                });

                            }
                            );

                        }
                    }
                }


            }

        } else {
            for ($i = 0; $i < $pileLength; $i++) {
//#region第一部分：获取参数
                //序号
                $model_id = collect($chargingPiles[$i])->get('id');
                $device_id = collect($chargingPiles[$i])->get('device_id');
                $brand = collect($chargingPiles[$i])->get('brand');
                $model = collect($chargingPiles[$i])->get('model');
                $stall_id = collect($chargingPiles[$i])->get('stall_id');
                $stall_number = Stall::find($stall_id)->number;
                if ($i == 0) {

                    $html .= <<<EOF
<table>
<tbody>
<tr>
<th  style="text-align: left;font-size: 0.6em;background-color:#60A5FA;color:white;">編號ID
</th>
<th style="text-align: left;font-size: 0.6em;background-color:#60A5FA;color:white;">充電站ID
</th>
<th style="text-align: left;font-size: 0.6em;background-color:#60A5FA;color:white;">品牌
</th>
<th style="text-align: left;font-size: 0.6em;background-color:#60A5FA;color:white;">型號
</th>

<th  style="text-align: left;font-size: 0.6em;background-color:#60A5FA;color:white;">車位編號
</th>

</tr>
</table>
</tbody>
EOF;
                }

                //充电桩信息，每5个为一组，如果是5的倍数，表示为内容行，直接渲染
                $html .= <<<EOF
<table>
<tbody>
<tr>
<th  style="text-align: left;font-size: 0.6em;">
$model_id
</th>
<th style="text-align: left;font-size: 0.6em;">$device_id
</th>
<th style="text-align: left;font-size: 0.6em;">$brand
</th>
<th style="text-align: left;font-size: 0.6em;">$model
</th>

<th  style="text-align: left;font-size: 0.6em;">$stall_number
</th>
</tr>
</table>
</tbody>
EOF;
//#endregion end第一部分END：获取参数
//===========================================================


//如果是5的倍数，说明当前组已经渲染完成，接下来渲染充电桩报告内容，因报告数量与充电桩数量一致，排除最后一组为5的倍数，
//而是数据相同时直接渲染，这样可以包含多个5的倍数，最后一组始终会显示

                if ($i == $pileLength - 1) {
                    //获取充电桩长度，当长度是5的倍数时，渲染表头，否则直接渲染内容
                    for ($j = 0; $j < $resultLength; $j++) {
//+++++++++++++++++++++++++++++++

                        if ($j == 0) {
//                        第二部分：报告详情标题部分P\F\N
                            $html .= <<<EOF
<table>
<tbody>
<tr>
<th colspan="5" style="font-size: .7em;"></th>
<th colspan="5" style="font-size: .7em;text-align: center;">P=通過        F=失敗       N=不適用</th>
</tr>
</tbody>
</table>
<table>
<tbody>
  <tr>
    <td colspan="1" rowspan="2"  style="font-size: .7em;text-align: center;" ><br/>編號</td>
    <td colspan="5" rowspan="2"  style="font-size: .7em;text-align: center;"><br/>描述</td>
    <td colspan="5" align="center" style="font-size: .7em;">結果</td>
  </tr>
  <tr>
EOF;
//                        结果的列数，是根据当前组的充电桩数量来计算的，当前判断条件已经是5的倍数，则开始循环渲染
//                        要去匹配充电桩的ID号，如果相同，则渲染，如果不同，则跳过

                            for ($t = $range[$curGroup][0]; $t <= $range[$curGroup][count($range[$curGroup]) - 1]; $t++) {

                                $charging_pile_id = collect(collect($chargingResults[$t])->get('result'))->get('device_id');
                                $html .= <<<EOF
    <td colspan="1">
    <span style="font-size: .7em;text-align: center;"> $charging_pile_id</span>
    </td>
EOF;
                            }

                            $html .= <<<EOF
  </tr>
</tbody>
</table>
EOF;
//=========================================
                            $curGroup++;
//                        获取充电桩内容信息，渲染内容信息。（报告的选项固定的）
//从配置文件中读取选项（$resultOptions）避免多次引入，提高效率
//                        读取配置项

                            collect($resultOptions)->each(function ($resultOption, $key) use (&$html, $range, $curGroup, $j, $chargingResults, $chargingPiles, $model_id) {
                                $outer_field_id = $resultOption['field_id'];
                                $outer_field_name = $resultOption['field_name'];
//                            分组分割标题
                                $html .= <<<EOF
<table>
<tbody>
<tr>
<th colspan="1" style="font-size: .7em;background-color:#60A5FA;color:white;">$outer_field_id</th>
<th colspan="5"  style="font-size: .7em;background-color:#60A5FA;color:white;">$outer_field_name</th>
<th colspan="5" style="font-size: .7em;background-color:#60A5FA;color:white;"></th>
</tr>
</tbody>
</table>

EOF;

//$chargingPiles中有一个model_id，对应充电桩的ID号，为保证顺序一致，用model_id来查找充电桩报告结果
                                //因报告结果是横向排列，定义一个数组，用来存储每一个充电桩的报告结果
                                $pileLength = count($chargingPiles);

                                $resData = [];
                                for ($i = 0; $i < $pileLength; $i++) {
                                    collect($chargingResults)->each(function ($chargingResult) use ($chargingPiles, $range, $curGroup, $i, &$resData) {
                                        if ($chargingResult['charging_pile_id'] == $chargingPiles[$i]['id']) {
                                            $charging_result = collect(collect($chargingResult)->get('result'))->get('resultData');
                                            $res = collect($charging_result)->map(function ($item) {
                                                return collect(collect($item)->get('field_options'))->map(function ($f) {
                                                    return [
                                                        'afield_id' => $f['field_id'],
                                                        'afield_name' => $f['field_name'],
                                                        'avalue' => $f['value'],
                                                    ];
                                                });
                                            });
                                            array_push($resData, $res);
                                        }
                                    });
                                }

                                $formatData = $this->formatDisplayData($resData, 5);

                                collect($formatData[$key])->map(function ($showData) use (&$html, $range, $curGroup) {
                                    $showData_id = $showData['field_id'];
                                    $showData_title = $showData['field_name'];
//$showData['value']中的数组合并为字符串

                                    $html .= <<<EOF
<table>
<tbody>
<tr>
<th colspan="1" style="font-size: .7em;">$showData_id</th>
<th colspan="5" style="font-size: .7em;">$showData_title</th>

EOF;

                                    $showData_value_array = $showData['value'];

                                    $Arange = $this->makeArray(count($showData_value_array), 5);
//                                    [0-4][5,10]
                                    $groupLength = 0;
                                    for ($x = $Arange[$curGroup - 1][0]; $x <= $Arange[$curGroup - 1][count($Arange[$curGroup - 1]) - 1]; $x++) {
                                        $groupLength = count($Arange[$curGroup - 1]);
                                        $overValue = $showData_value_array[$x];


                                        $html .= <<<EOF
<th colspan="1"  style="font-size: .7em;text-align: center;">$overValue</th>
EOF;
                                        //始终保持有5个单元格，如果有多余的单元格，则填充空白


                                    }
//=======================================================
                                    switch ($groupLength) {
                                        case 1:
                                            $html .= <<<EOF
<td colspan="1">
    <span style="font-size: .7em;text-align: center;"></span>
</td>
<td colspan="1">
    <span style="font-size: .7em;text-align: center;"></span>
</td>
<td colspan="1">
    <span style="font-size: .7em;text-align: center;"></span>
</td>
<td colspan="1">
    <span style="font-size: .7em;text-align: center;"></span>
</td>
EOF;
                                            break;
                                        case 2:
                                            $html .= <<<EOF
<td colspan="1">
    <span style="font-size: .7em;text-align: center;"></span>
</td>
<td colspan="1">
    <span style="font-size: .7em;text-align: center;"></span>
</td>
<td colspan="1">
    <span style="font-size: .7em;text-align: center;"></span>
</td>
EOF;
                                            break;
                                        case 3:
                                            $html .= <<<EOF
<td colspan="1">
    <span style="font-size: .7em;text-align: center;"></span>
</td>
<td colspan="1">
    <span style="font-size: .7em;text-align: center;"></span>
</td>
EOF;
                                            break;
                                        case 4:
                                            $html .= <<<EOF
<td colspan="1">
    <span style="font-size: .7em;text-align: center;"></span>
</td>
EOF;
                                            break;
                                    }

                                    $html .= <<<EOF
</tr>
</tbody>
</table>
EOF;


                                });
                            }
                            );

                        }
                    }
                }


            }

        }

        //獲取LOGO圖片
//        $html .= '<div style="page-break-after: always;"></div>';
//        $pdf->Ln(10);//换行符

//添加備註信息
        $html .= <<<EOF
<table>
<tbody>
<tr>
<th colspan="6" rowspan="3" style="font-size: .7em;">備註:$remark</th>
<th colspan="4" style="font-size: .7em;">簽署：<img src="images/logo1.png" alt="" style="width:28px;"></th>

</tr>
<tr>
<th colspan="4" style="font-size: .7em;">日期：$report_date $user_name</th>
</tr>
</tbody>
</table>
EOF;

        //这一行始终放在最后

        $pdf->writeHTML($html, true, false, true, false, "");
    }

//如果有$html参数时。执行连接。如果没有执行新建

    protected function makeArray($length, $chunk)
    {
        $array = array();
        for ($i = 0; $i < $length; $i++) {
            array_push($array, $i);
        }
        $array = array_chunk($array, $chunk);
        return $array;
    }

//帮助函数，将数组分段成二维数组

    public function showStyle($html)
    {
        if ($html) {
            $html .= <<<EOF
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
            return $html;
        } else {
            $newHtml = <<<EOF
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
            return $newHtml;
        }
    }


    //将数组横向分布排列
//[
//  [
//     aid:1.1,
//     afield_name:'充電線沒有破損',
//     avalue:[P,P,P,P,P,P,P,P]
//  ],
//  [
//     aid:1.2,
//     afield_name:'充電槍沒有破損',
//     avalue:[P,P,P,P,P,P,P,P]
//  ]
//]

//格式化显示数据，使其结果横向分布排列

    protected function formatDisplayData($data, $chuckNumber)
    {

//        获取ChargingReportField中的field_options列
        $dataTemplate = ChargingReportField::all()->pluck('field_options')->toArray();
        $modelArray = collect($dataTemplate)->flatMap(function ($item) {
            return $item;
        })->toArray();
//将modelArray中的每一项中的value值改为空数组
        $modelArray = collect($modelArray)->map(function ($item) {
            $item['value'] = [];
            return $item;
        });
        $modelArray = $modelArray->toArray();
//得到摊平的数组,一维数组21项

        $flatArray = collect($data)->map(function ($item) {
            return collect($item)->flatMap(function ($item) {
                return $item;
            });
        })->toArray();
        $tempArray = [];
        //改变$modelItem的值

        array_map(function ($modelItem) use ($flatArray, &$tempArray) {
            array_map(function ($flatItem) use (&$modelItem, &$tempArray) {
                array_map(function ($flatItem) use (&$modelItem, &$tempArray) {
                    if ($flatItem['afield_id'] == $modelItem['field_id']) {
                        array_push($modelItem['value'], $flatItem['avalue']);
                    }
                }, $flatItem);
            }, $flatArray);
            array_push($tempArray, $modelItem);
        }, $modelArray);
        $tempArray = array_chunk($tempArray, 5);
        //将最后2个数组合并为一个
        $popArray = array_pop($tempArray);//返回值為4.6：狀態指示燈顯示正常
        $tLength = count($tempArray);

        $resArr = array_push($tempArray[$tLength - 1], $popArray[0]);

        return $tempArray;
    }
}
