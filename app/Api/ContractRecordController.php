<?php

namespace App\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContractRecordResource;
use App\Models\ContractRecord;
use Illuminate\Http\Request;

class ContractRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ContractRecord::paginate(10);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\ContractRecord $contractRecord
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContractRecord $contractRecord)
    {
        //
    }

    public function queryHistory(Request $request)
    {
        if (is_null($request->owner_id)) {
            $records = ContractRecord::whereBetween('created_at', [$request->start_time, $request->end_time]);
            $result = ContractRecordResource::collection($records->paginate(10));
        } else {
            $records = ContractRecord::where('owner_id', $request->owner_id)->whereBetween('created_at', [$request->start_time, $request->end_time]);
            $result = ContractRecordResource::collection($records->paginate(10));
        }
        return $result;
    }

//某个合同的所有缴费记录
    public function allhistory(Request $request)
    {
        return ContractRecord::where('contract_id', $request->contract_id)->get();
    }
}
