<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade as FacadesBlade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Model::shouldBeStrict(!$this->app->isProduction());
        // make blade component
        FacadesBlade::if('admin', function () {
            return auth()->check() && auth()->user()->isAdmin();
        });
    }
}
