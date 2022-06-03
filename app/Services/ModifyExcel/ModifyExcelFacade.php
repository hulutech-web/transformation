<?php

namespace App\Services\ModifyExcel;

use Illuminate\Support\Facades\Facade;

class ModifyExcelFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ModifyExcelService';
    }
}
