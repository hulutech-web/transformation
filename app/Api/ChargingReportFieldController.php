<?php

namespace App\Api;

use App\Http\Controllers\Controller;
use App\Models\ChargingReportField;

class ChargingReportFieldController extends Controller
{

    public function init()
    {
        if (count(ChargingReportField::all()) > 0) {
            return $this->error('您已初始化過了，無需再初始化');
        }
        $fields = config('chargeFields');
        //循环$fields，批量添加
        foreach ($fields as $field) {
            ChargingReportField::create([
                'field_id' => $field['field_id'],
                'field_name' => $field['field_name'],
                'field_options' => $field['field_options'],
            ]);
        }
        return $this->message('初始化成功');
    }


    public function reset()
    {
        ChargingReportField::truncate();
        return $this->message('重置成功');
    }

    public function getAllFields()
    {
        return ChargingReportField::all();
    }
}
