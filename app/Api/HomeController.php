<?php

namespace App\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//首页控制器
class HomeController extends Controller
{
    public function index()
    {
//#region 柱状图
        //楼盘总数
        $total_build = \App\Models\Build::count();
        //单元总数
        $total_unit = \App\Models\Unit::count();
        //业主数
        $total_owner = \App\Models\Owner::count();
        //用户数
        $total_user = \App\Models\User::count();
        //合同数
        $total_contract = \App\Models\Contract::count();
//#endregion

//#region 饼状图
        //累计合同金额
        $total_agency_fee = \App\Models\Contract::sum('agency_fee');
        //累计一次性费用
        $total_one_time_charges = \App\Models\Contract::sum('one_time_charges');
        //累计剩余费用
        $total_rest_fee = \App\Models\Contract::sum('rest');
//#endregion

        //按合同nature_the_land字段分类汇总

        $nature_the_land = \App\Models\Contract::selectRaw('nature_the_land,count(*) as total')->groupBy('nature_the_land')->get();
//按合同replace_land字段分类汇总
        $replace_land = \App\Models\Contract::selectRaw('replace_land,count(*) as total')->groupBy('replace_land')->get();
        //待办理数，已办理合同，业主数减去合同数
        //找出所有合同中rest字段为0，并求和
        $total_rest = \App\Models\Contract::where('rest',0)->count();

        //合同总数-已交完费用合同数
        $todo = $total_contract - $total_rest;

        return response()->json([
            'total_build' => $total_build,
            'total_unit' => $total_unit,
            'total_owner' => $total_owner,
            'total_user' => $total_user,
            'total_contract' => $total_contract,
            'total_agency_fee' => $total_agency_fee,
            'total_todo' => $todo,
            'total_one_time_charges' => $total_one_time_charges,
            'total_rest_fee' => $total_rest_fee,
            'nature_the_land' => $nature_the_land,
            'replace_land' => $replace_land,
        ]);
    }
}
