<?php

namespace App\Imports;

use App\Models\ChargingPile;
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
        return new ChargingPile([
            'device_id' => $row[0],
            'brand' => $row[1],
            'model' => ($row[2]),
            'stall_id' => (int)$row[3],
        ]);
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
