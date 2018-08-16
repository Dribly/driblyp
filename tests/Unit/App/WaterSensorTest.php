<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\WaterSensor;

class WaterSensorTest extends TestCase {

    /**
     *
     * @return void
     */
    public function testGetUrl() {
        $this->sut = new WaterSensor();
        $this->sut->id = 8;
        $this->assertSame($_SERVER['APP_URL'] . '/sensors/8', $this->sut->getUrl());
    }
/*
 * 30 min humidity
    
    current is 28 tap is on (yes) 
    current is 28 tap is off (yes) 
    
    current is 35 tap is on (yes) (45)
    current is 35 tap is off (no)
    
    current is 50 tap is on (no)
    current is 50 tap is off (no)
 */

    public function providerneedsWater() {
        return [
            [30, 40, 'on', true],
            [30, 40, 'off', false],
            [30, 50, 'on', false],
            [30, 50, 'off', false],
            [30, 20, 'on', true],
            [30, 20, 'off', true],
        ];
    }

    /**
     * A basic test example.
     *
     * @return void
     * @dataProvider providerneedsWater
     */
    public function testneedsWater($threshold, $lastReading, $expectedState, $expectedResult) {
        $this->sut = new WaterSensor();
        $this->sut->last_reading = $lastReading;
        $this->sut->threshold = $threshold;
        $this->sut->expected_state = $expectedState;
        $this->assertSame($expectedResult, $this->sut->needsWater());
    }
}
