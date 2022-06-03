<?php

namespace App\Services\ModifyExcel;

use Illuminate\Support\ServiceProvider;

class ModifyExcelServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('ModifyExcelService', function () {
            return new ModifyExcelService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
