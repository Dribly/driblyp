<?php

namespace App\Observers;
use App\WaterSensor;

class WaterSensorObserver
{
    public function updated(WaterSensor $sensor) {
        $original = $sensor->getOriginal();
        // LEt's check to see if the reading has changed. If so then we need ot process
        if ($original['last_reading'] !== $sensor->last_reading)
        {
            if ($sensor->needsWater())
            {
// get the tapID that is controlled by this sensor
                // should only be one
                $taps = $sensor->taps();
                foreach ($taps as $tap)
                {
                    $needsWater = false;
                    foreach ($tap->waterSensors as $sensor) {
                        // If ANY sensor needs water then we need water.
                        $needsWater |= $sensor->needsWater();
                    }
                    if ($needsWater) {
                        $tap->turnOnTap();
                    } else {
                        $tap->turnOffTap();
                    }
                }
            }
        }
    }
    //
}
