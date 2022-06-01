<?php

namespace App\Services\BarCode;

use Illuminate\Support\Facades\Facade;

class BarCodeFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'BarCodeService';
    }
}
