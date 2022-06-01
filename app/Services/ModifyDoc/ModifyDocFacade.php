<?php

namespace App\Services\ModifyDoc;

use Illuminate\Support\Facades\Facade;

class ModifyDocFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ModifyDocService';
    }
}
