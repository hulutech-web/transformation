<?php

namespace App\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChargingReportRequest;
use App\Http\Requests\UpdateChargingReportRequest;
use App\Http\Resources\ChargingReportResource;
use App\Models\ChargingReport;
use App\Models\ChargingReportField;
use App\Models\Stall;
use Auth;
use ConvertChargingService;
use Illuminate\Http\Request;

class ChargingReportController extends Controller
{

    public function index()
    {
//        獲取停車場名稱並一同返回

        return ChargingReport::with('park')->with('user')->orderBy('created_at', 'desc')->paginate(5);
        //資源分頁返回,默認分頁
        return ChargingReportResource::collection(ChargingReport::paginate(5));
    }

    public function store(StoreChargingReportRequest $request)
    {
        $chargingReport = ChargingReport::create([
            'report_date' => $request->input('report_date'),
            'park_id' => $request->input('park_id'),
            'stall_ids' => $request->input('stall_ids'),
            'remark' => $request->input('remark'),
            'user_id' => Auth::id()
        ]);
//        关联用户
        $chargingReport->user()->associate(Auth::user());
//        关联停车场
        $chargingReport->park()->associate($chargingReport->park);
        $chargingReport->save();
        //獲取充電樁ID
        try {
            foreach ($request->stall_ids as $stall_id) {
                $stall = Stall::where('id', (int)$stall_id['id'])->first();
                //获取stall关联的充电桩
                $chargingpileId = $stall->chargingPile->id;
                //從request里的results中匹配device_id等於$chargingpileId的id
                array_filter($request->results, function ($result) use ($chargingpileId, $chargingReport) {
                    if ($result['device_id'] == $chargingpileId) {
                        $chargingReport->chargingResults()->create([
                            'charging_pile_id' => $chargingpileId,
                            'charging_report_id' => $chargingReport->id,
                            'result' => $result
                        ]);
                    };
                });
            }

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return $this->message('添加成功');
    }


    public function show(ChargingReport $chargingreport)
    {
        return new ChargingReportResource($chargingreport);
    }

    public function update(UpdateChargingReportRequest $request, ChargingReport $chargingReport)
    {
        //
    }


    public function destroy(ChargingReport $chargingReport)
    {
        //
    }


    public function test(Request $request, ChargingReport $chargingreport)
    {

//        return $this->makeArray(12, 5);
        $chargingResource = new ChargingReportResource($chargingreport);
        $chargingResults = collect($chargingResource)->get('chargingResults');

        $chargingPiles = collect($chargingResource)->get('chargingPiles');

        $pileLength = count($chargingPiles);
        $resData = [];
        for ($i = 0; $i < $pileLength; $i++) {
            collect($chargingResults)->each(function ($chargingResult) use ($chargingPiles, $i, &$resData) {
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

        return $this->formatDisplayData($resData, 5);
    }

    protected function makeArray($length, $chunk)
    {
        $array = array();
        for ($i = 0; $i < $length; $i++) {
            array_push($array, $i);
        }
        $array = array_chunk($array, $chunk);
        return $array;
    }


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
