<?php

namespace App\Listeners;

use App\Events\SensorReportReceived;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SensorReportListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SensorReportReceived  $event
     * @return void
     */
    public function handle(SensorReportReceived $event)
    {
        //
    }
}
