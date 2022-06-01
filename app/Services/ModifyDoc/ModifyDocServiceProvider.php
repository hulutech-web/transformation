<?php

namespace App\Services\ModifyDoc;

use Illuminate\Support\ServiceProvider;

class ModifyDocServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('ModifyDocService', function () {
            return new ModifyDocService();
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
