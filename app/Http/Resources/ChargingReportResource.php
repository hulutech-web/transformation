<?php

namespace App\Http\Resources;

use App\Models\ChargingPile;
use App\Models\Stall;
use Illuminate\Http\Resources\Json\JsonResource;

class ChargingReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //获取ids
        $stall_ids = collect($this->stall_ids)->pluck('id');
        //获取充电桩
        $chargingPiles = ChargingPile::whereIn('stall_id', $stall_ids)->get();
        return parent::toArray($request) + [
                'chargingResults' => $this->chargingResults,
                'park_name' => $this->park()->first()->name,
                'user_name' => $this->user->name,
//                通过stall_ids中的id字段获取stall的name
                'stalls' => Stall::whereIn('id', $stall_ids)->get()->pluck('number'),
                'chargingPiles' => $chargingPiles,
            ];
    }
}
