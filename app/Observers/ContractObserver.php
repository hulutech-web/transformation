<?php

namespace App\Observers;

use App\Models\Contract;
use App\Models\ContractRecord;
use Auth;

class ContractObserver
{
    /**
     * Handle the Contract "created" event.
     *
     * @param \App\Models\Contract $contract
     * @return void
     */
    public function created(Contract $contract)
    {


    }

    /**
     * Handle the Contract "updated" event.
     *
     * @param \App\Models\Contract $contract
     * @return void
     */
    public function updated(Contract $contract)
    {
        //rest剩余费用，difference_cost下差费用

        //当合同别修改时触发该事件。
//        ContractRecord::create([
//            'owner_id' => $contract->owner_id,
//            'contract_id' => $contract->id,
//            'user_id' => Auth::id(),
//            'payment' => $contract->payment,
//            'before_pay' => $contract->agency_fee-$contract->difference_cost,
//            'after_pay' => $contract->difference_cost
//        ]);

    }

    /**
     * Handle the Contract "deleted" event.
     *
     * @param \App\Models\Contract $contract
     * @return void
     */
    public function deleted(Contract $contract)
    {
        //
    }

    /**
     * Handle the Contract "restored" event.
     *
     * @param \App\Models\Contract $contract
     * @return void
     */
    public function restored(Contract $contract)
    {
        //
    }

    /**
     * Handle the Contract "force deleted" event.
     *
     * @param \App\Models\Contract $contract
     * @return void
     */
    public function forceDeleted(Contract $contract)
    {
        //
    }
}
