<?php

namespace App\Services\ConvertCharging;

use Illuminate\Support\ServiceProvider;

class ConvertChargingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('ConvertChargingService', function () {
            return new ConvertChargingService();
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
