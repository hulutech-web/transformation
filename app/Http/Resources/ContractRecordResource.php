<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContractRecordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request) + [
                //业主名称
                'owner_name' => $this->owner->householder_name,
                //合同的home_address
                'home_address' => $this->contract->home_address,
                //合同总金额
                'agency_fee' => $this->contract->agency_fee,
            ];
    }
}
