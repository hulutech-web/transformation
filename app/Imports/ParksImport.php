<?php

namespace App\Imports;

use App\Models\Park;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;

class ParksImport implements ToModel, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        //名稱，地址，電話，負責人
        //name,address,phone,manager
        //判断标题不插入
        //判断标题不插入
        if ($row[0] == '名稱') {
            return null;
        }

        return new Park([
            'name' => $row[0],
            'address' => $row[1],
            'phone' => $row[2],
            'manager' => $row[3],
        ]);
    }

    public function rules(): array
    {
        return [
            // Can also use callback validation rules
            '1' => function ($attribute, $value, $onFailure) {
                if ($value === null || $value === '') {
                    $onFailure($attribute.'不能為空');
                }
            },
        ];
    }

}
