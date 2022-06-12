<?php

namespace App\Services\ConvertCharging;

use Illuminate\Support\Facades\Facade;

class ConvertChargingFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ConvertChargingService';
    }
}
