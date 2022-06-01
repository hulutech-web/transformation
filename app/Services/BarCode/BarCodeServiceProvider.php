<?php

namespace App\Services\BarCode;

use Illuminate\Support\ServiceProvider;

class BarCodeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('BarCodeService', function () {
            return new BarCodeService();
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
