<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Observers\WaterSensorObserver;
use App\Observers\TapObserver;
use App\WaterSensor;
use App\Tap;

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
        Tap::observe(TapObserver::class);//
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
