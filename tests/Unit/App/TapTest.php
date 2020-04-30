<?php

namespace Tests\Unit\App;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Tap;

class TapTest extends TestCase {
    /**
     *
     * @return void
     */
    public function testGetUrl() {
        $sut = new Tap();
        $sut->id = 4;
        $this->assertSame($_SERVER['APP_URL'] . '/taps/4', $sut->getUrl());
    }

    public function providerisActive(): array {
        return [
            [true, 'active'],
            [false, 'inactive']
        ];
    }

    /**
     * @param $expected
     * @param $status
     * @dataProvider providerisActive
     */
    public function testisActive(bool $expected, string $status) {
        $sut = new Tap();
        $sut->status = $status;
        $this->assertSame($expected, $sut->isActive());
        $sut->status = 'inactive';
        $this->assertSame(false, $sut->isActive());
    }

    public function testwaterSensors() {
        $sut = new Tap();
        $waterSensors = $sut->waterSensors();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\BelongsToMany', $waterSensors);
        $this->assertsame('tap_water_sensor', $waterSensors->getTable());
        $this->assertsame('waterSensors', $waterSensors->getRelationName());
    }

    public function testGarden() {
        $sut = new Tap();
        $garden = $sut->garden();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\BelongsTo', $garden);
    }

    public function providerturnTap(): array {
        return [
            [Tap::OFF, Tap::OFF],
            [Tap::ON, Tap::ON]
        ];
    }

    /**
     * @param $expected
     * @param $turnonValue
     * @dataProvider providerturnTap
     */
    public function testturnTap(string $expected, string $turnonValue) {
        $falseDate = '2017-01-01 11:11:11';

        $sut = $this->getMockBuilder(Tap::class)->setMethods(['save'])->disableOriginalConstructor()->getMock();
        $sut->method('save')->willReturn(true);

        $sut->last_off_request = $falseDate;
        $sut->last_on_request = $falseDate;

        $sut->turnTap($turnonValue);
        $this->assertSame($expected, $sut->expected_state);
        if (Tap::ON == $turnonValue) {
            $this->assertSame($falseDate, $sut->last_off_request);
            $this->assertNotSame($falseDate, $sut->last_on_request);
        } else {
            $this->assertSame($falseDate, $sut->last_on_request);
            $this->assertNotSame($falseDate, $sut->last_off_request);
        }
    }

    public function providerpleaseTurnTap(): array {
        // Force a adte to 1 year in the futre
        //@TODO this is WAY Too complex for a test
        $someFutureDAte = date((date('Y') + 1) . '-m-d H:i:s');
        $somePastDate = '2017-01-01 15:04:04';
        return [
            [true, Tap::ON, 1, false, null],
            [false, Tap::ON, 0, true, null],
            [true, Tap::OFF, 1, false, null ],
            [false, Tap::OFF, 0, true, null, ],
            [true, Tap::ON, 1, false, $somePastDate],
            [false, Tap::ON, 0, true, $somePastDate],
            [true, Tap::OFF, 1, false, $somePastDate],
            [false, Tap::OFF, 0, true, $somePastDate],
            [false, Tap::ON, 0, false, $someFutureDAte],
            [false, Tap::ON, 0, true, $someFutureDAte],
            [false, Tap::OFF, 0, false, $someFutureDAte],
            [false, Tap::OFF, 0, true, $someFutureDAte],
        ];
    }

    /**
     * @param $expected
     * @param string $onOrOff
     * @param int $expectTurnTap
     * @param $ignore_sensor_input_until
     * @dataProvider providerpleaseTurnTap
     */
    public function testpleaseTurnTap($expected, string $onOrOff, int $expectTurnTap, bool $isTimerBlocked, ?string $ignore_sensor_input_until) {
        $mockTimeSlotManager = $this->getMockBuilder('\\App\\TimeSlotManager')->setMethods(['isTimerBlocked'])->disableOriginalConstructor()->getMock();
        $mockTimeSlotManager->expects($this->any())->method('isTimerBlocked')->willReturn($isTimerBlocked);
        $sut = $this->getMockBuilder(Tap::class)->setMethods(['turnTap', 'getTimeSlotManager'])->disableOriginalConstructor()->getMock();
        $sut->expects($this->exactly($expectTurnTap))->method('turnTap')->willReturn(true);
        $sut->expects($this->any())->method('getTimeSlotManager')->willReturn($mockTimeSlotManager);
        $sut->ignore_sensor_input_until = $ignore_sensor_input_until;

        $this->assertSame($expected, $sut->pleaseTurnTap($onOrOff));

    }

    public function providerhasSchedule(): array {
        $futureYear = ((int)date('Y')) + 1;
        return [
            [false, null],
            [false, ''],
            [false, '2011-08-14 11:00:02'],
            [true, $futureYear . '-08-14 11:00:02'],
        ];
    }

    /**
     * @param bool $expected
     * @param string $nextEventScheduled
     * @dataProvider providerhasSchedule
     */
    public function testhasSchedule(bool $expected, string $nextEventScheduled = null) {
        $sut = $this->getMockBuilder(Tap::class)->setMethods(['turnTap'])->disableOriginalConstructor()->getMock();
        $sut->next_event_scheduled = $nextEventScheduled;
        $this->assertSame($expected, $sut->hasSchedule());
    }

    public function providergetTurnOffData(): array {
        $futureYear = ((int)date('Y')) + 2;
        $pastYear = ((int)date('Y')) - 1;
        return [
            ['', '', ''],
            ['', null, null],
            ['', 'off', $pastYear . '-09-27 16:50:30'],//because the date is in the past, hasSchedule is fales
            ['', 'on', $pastYear . '-09-27 16:50:30'],//because the date is in the past, hasSchedule is fales
            ['The tap will turn off at 27 Sep ' . $futureYear . ' at 16:50', 'off', $futureYear . '-09-27 16:50:30'],
//            ['', true, null],
        ];
    }

    /**
     * @param string $expected
     * @param string $nextEvent
     * @param string $nextEventScheduled
     *
     * @dataProvider providergetTurnOffData
     */
    public function testgetTurnOffDate(string $expected, ?string $nextEvent, ?string $nextEventScheduled) {
        $sut = $this->getMockBuilder(Tap::class)->setMethods(['save'])->disableOriginalConstructor()->getMock();
        $sut->next_event_scheduled = $nextEventScheduled;
        $sut->next_event = $nextEvent;
//        $sut->expects($this->any())->method('hasSchedule')->willReturn($hasSchedule);

        $this->assertSame($expected, $sut->getTurnOffDate());
    }

    /**
     * @covers Tap::hasSchedule
     * @covers Tap::clearEvent
     * @covers Tap::setEvent
     */
    public function testsetEvent() {
        $futureYear = ((int)date('Y')) + 2;
        $sut = $this->getMockBuilder(Tap::class)->setMethods(['save'])->disableOriginalConstructor()->getMock();
        $this->assertFalse($sut->hasSchedule());
        $sut->setEvent('woof', '2015-01-01 11:44:44');
        $this->assertFalse($sut->hasSchedule());
        $sut->setEvent(Tap::OFF, $futureYear . '-01-01 11:44:44');
        $this->assertTrue($sut->hasSchedule());
        $sut->clearEvent();
        $this->assertFalse($sut->hasSchedule());
    }


}
