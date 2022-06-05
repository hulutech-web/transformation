<?php

namespace App\Services\Convert;

use Illuminate\Support\Facades\Facade;

class ConvertFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ConvertService';
    }
}
