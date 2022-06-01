<?php

namespace App\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContractRequest;
use App\Http\Requests\UpdateContractRequest;
use App\Models\Contract;
use App\Models\ContractRecord;
use App\Models\Owner;
use App\Models\User;
use Auth;
use BarCodeService;
use Illuminate\Http\Request;
use ModifyDocService;

class ContractController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }


    public function store(StoreContractRequest $request)
    {
        $contract = Contract::create($request->input() + ['user_id' => Auth::id()]);
        return $this->message('创建成功');
    }

    public function show(Contract $contract)
    {
        return $contract;
    }


    public function update(UpdateContractRequest $request, Contract $contract)
    {
        $contract->update($request->input());
        return $this->message('修改成功');
    }

    public function destroy(Contract $contract)
    {
        $isAdmin = Auth::user()->isAdmin();
        if ($isAdmin) {
            $contract->delete();
            return $this->message('删除成功');
        } else {
            return $this->error('没有权限');
        }
    }

    public function getCode(Request $request)
    {

        $uuid = \UUID::generate(4);

        $img = BarCodeService::generateCode($uuid);
//        返回数据
        return $img;
    }

//生成预览合同
    public function getPreviewContract(Request $request, Contract $contract)
    {
        $uuid = $contract->uuid;
        ModifyDocService::init($contract->id, $uuid);
    }

    public function getUuid(Request $request)
    {
        return \UUID::generate(4);
    }

    public function getUserContract(Request $request, User $user)
    {
        $isAdmin = Auth::user()->isAdmin();
        //如果用户是财务时，可以看到所有的合同
        $isFinancial = $user->hasRole('Financial');
        if ($isAdmin || $isFinancial) {
            return Contract::paginate(10);
        } else {
            return $user->contracts()->paginate(10);
        }
    }

    //按照房屋户主、当前用户管理的合同
    public function getOwnerContract(Request $request, User $user)
    {
        $isAdmin = Auth::user()->isAdmin();
        //关键字搜索
        //合同中有户主，当前管理的用户，超级管理员，关键字搜索
        $owners = Owner::where('householder_name', 'like', '%'.$request->keyword.'%')->get();
        if ($isAdmin) {
            return Contract::whereIn('owner_id', $owners->pluck('id'))->paginate(10);
        } else {
            return Contract::where('user_id', $user->id)
                ->whereIn('owner_id', $owners->pluck('id'))->paginate(10);
        }

    }

    //财务查询所有合同
    public function getFinancialContract(Request $request)
    {
        $isAdmin = Auth::user()->isAdmin();
        $isFinance = Auth::user()->hasRole('Financial');
        if ($isAdmin || $isFinance) {
            return Contract::paginate(10);
        } else {
            return $this->error('没有权限');
        }
    }

    //财务缴纳费用
    public function putFinancialPayment(Request $request, Contract $contract)
    {
        $isAdmin = Auth::user()->isAdmin();
        $isFinance = Auth::user()->hasRole('Financial');
        if ($isAdmin || $isFinance) {
            //添加缴费记录
            ContractRecord::create([
                'owner_id' => $contract->owner_id,
                'contract_id' => $contract->id,
                'user_id' => Auth::id(),
                'payment' => $request->payment,
                'before_pay' => $contract->rest,
                'after_pay' => $contract->rest-$request->payment
            ]);
            //rest剩余费用，difference_cost下差费用
            $contract->rest = $contract->rest - $request->payment;
            $contract->difference_cost = $contract->difference_cost - $request->payment;
            $contract->save();
            return $this->message('缴纳成功');
        } else {
            return $this->error('没有权限');
        }
    }
    //rest:剩余费用\difference_cost：下差费用
}
