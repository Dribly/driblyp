<?php

namespace App\Observers;

use App\WaterSensor;

class WaterSensorObserver {
    public function updated(WaterSensor $sensor) {
        $original = $sensor->getOriginal();
        // LEt's check to see if the reading has changed. If so then we need ot process
        if ($original['last_reading'] !== $sensor->last_reading) {
            // should only be one
            $taps = $sensor->taps;
            foreach ($taps as $tap) {
                $needsWater = false;
                foreach ($tap->waterSensors as $sensor) {
                    if ($sensor->isActive()) {
                        // If ANY sensor needs water then we need water.
                        $needsWater |= $sensor->needsWater();
                    }
                }
                // Note how we use the PLEASE version of this
                // because the sensors are not gods, that's for the owner
                // so if there is some good reason to ignore the sensor, this function does exactly that
                if ($needsWater) {
                    $tap->pleaseTurnTap('on');
                } else {
                    $tap->pleaseTurnTap('off');
                }

            }
        }
    }
    //
}
