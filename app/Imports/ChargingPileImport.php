<?php

namespace App\Imports;

use App\Models\Stall;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;

class ChargingPileImport implements ToModel, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if ($row[0] == '設備編號') {
            return null;
        }
//        注意：需要关联导入，否则关联查询不出来。找出stall模型，并关联上chargingPile模型
        $stall = Stall::where('id', (int)$row[3])->first();
        $chargingPile = $stall->chargingPile()->create([
            'device_id' => $row[0],
            'brand' => $row[1],
            'model' => $row[2],
        ]);

        return $chargingPile;
    }

    public function rules(): array
    {
        return [
            // Can also use callback validation rules
            '0' => function ($attribute, $value, $onFailure) {
                if ($value === null || $value === '') {
                    $onFailure($attribute.'不能為空');
                }
            },
        ];
    }
}
