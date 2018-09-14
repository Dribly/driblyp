<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Observers\WaterSensorObserver;
use App\WaterSensor;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        WaterSensor::observe(WaterSensorObserver::class);//
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
