<?php

namespace App\Imports;

use App\Models\Goods;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Auth;
class GoodsImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $user=Auth::user();
        foreach ($rows as $row){
            $user->goods()->create([
                'ARTICLE' => $row[0],
                'IMAGE' => $row[1],
                'BRAND' => $row[2],
                'DIVISION' => $row[3],
                'GENDER'=> $row[4],
                'DESCRIPTIONS'=>$row[5],
                'PRODUCTGROUP'=>$row[6],
                'ProductGroupSort'=>$row[7],
                'SPORTCODE'=>$row[8],
                'INVENTORYQTY'=>$row[9],
                'INVENTORYAMOUNT'=>$row[10],
                'SELECTIONQTY'=>$row[11],
                'SELECTIONAMOUNT'=>$row[12],
                'PRICE'=>$row[13],
                'RRP'=>$row[14],
                'SIZEAVAILABLE'=>$row[15],
            ]);
        }
    }

}
