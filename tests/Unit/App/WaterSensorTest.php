<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\WaterSensor;
use App\Tap;

class WaterSensorTest extends TestCase {

    /**
     *
     * @return void
     */
    public function testGetUrl() {
        $sut = new WaterSensor();
        $sut->id = 8;
        $this->assertSame($_SERVER['APP_URL'] . '/sensors/8', $sut->getUrl());
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
        $sut = new WaterSensor();
        $sut->last_reading = $lastReading;
        $sut->threshold = $threshold;
        $sut->expected_state = $expectedState;
        $this->assertSame($expectedResult, $sut->needsWater());
    }


    public function providercanControlTap(): array {
        return [
            [false, false, 1, 2, ['moo', 'bar']],
            [false, false, 1, 2, []],
            [false, false, 1, 1, []],
            [true, true, 1, 1, []],
            [false, true, 1, 1, ['moo', 'bar']],
            [false, true, 1, 2, []],
        ];
    }

    /**
     * @param bool $expected
     * @param bool $isActive
     * @param int $tapOwner
     * @param int $waterSensorOwner
     * @param array $mockTaps array (i.e. countable)  of things that might look like taps
     * @dataProvider providercanControlTap
     */
    public function testcanControlTap(bool $expected, bool $isActive, int $tapOwner, int $waterSensorOwner, array $mockTaps) {
        $mockTap = $this->getMockBuilder(Tap::class)->setMethods(['save', 'isActive'])->disableOriginalConstructor()->getMock();
        $mockTap->method('isActive')->willReturn($isActive);
        $mockTap->owner = $tapOwner;

        $sut = $this->getMockBuilder(WaterSensor::class)->setMethods(['save'])->disableOriginalConstructor()->getMock();
        $sut->method('save')->willReturn(true);
//        $sut->method('taps')->willReturn($mockTaps);
        $sut->owner = $waterSensorOwner;
        $sut->taps = $mockTaps;

        $this->assertSame($expected, $sut->canControlTap($mockTap));

    }

    public function providercontrolTap(): array {
        return [
            [false, false],
            [true, true],
        ];
    }

    /**
     * @param bool $expected
     * @param bool $canControlTap
     * @dataProvider providercontrolTap
     */
    public function testcontrolTap(bool $expected, bool $canControlTap) {
        $mockTap = $this->getMockBuilder(Tap::class)->setMethods(['save'])->disableOriginalConstructor()->getMock();

        $mockRelationship = $this->getMockBuilder('relationship')->setMethods(['attach'])->disableOriginalConstructor()->getMock();
        $mockRelationship->method('attach')->with($mockTap)->willReturn(null);

        $sut = $this->getMockBuilder(WaterSensor::class)->setMethods(['save', 'taps', 'canControlTap'])->disableOriginalConstructor()->getMock();
        $sut->method('save')->willReturn(true);
        $sut->method('canControlTap')->willReturn($canControlTap);
        $sut->method('taps')->willReturn($mockRelationship);

        $this->assertSame($expected, $sut->controlTap($mockTap));

    }

    public function testtaps() {
        $sut = new WaterSensor();
        $taps = $sut->taps();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\BelongsToMany', $taps);
        $this->assertsame('tap_water_sensor', $taps->getTable());
        $this->assertsame('taps', $taps->getRelationName());
    }


}
