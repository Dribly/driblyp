<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Tap;

class TapTest extends TestCase {
    /**
     *
     * @return void
     */
    public function testGetUrl() {
        $this->sut = new Tap();
        $this->sut->id = 4;
        $this->assertSame($_SERVER['APP_URL'] . '/taps/4', $this->sut->getUrl());
    }

    public function providerisActive() {
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
        $this->sut = new Tap();
        $this->sut->status = $status;
        $this->assertSame($expected, $this->sut->isActive());
        $this->sut->status = 'inactive';
        $this->assertSame(false, $this->sut->isActive());
    }

    public function testwaterSensors() {
        $this->sut = new Tap();
        $waterSensors = $this->sut->waterSensors();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\BelongsToMany', $waterSensors);
        $this->assertsame('tap_water_sensor', $waterSensors->getTable());
        $this->assertsame('waterSensors', $waterSensors->getRelationName());
    }

    public function providerturnTap() {
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

        $this->sut = $this->getMockBuilder(Tap::class)->setMethods(['save'])->disableOriginalConstructor()->getMock();
        $this->sut->method('save')->willReturn(true);

        $this->sut->last_off_request = $falseDate;
        $this->sut->last_on_request = $falseDate;

        $this->sut->turnTap($turnonValue);
        $this->assertSame($expected, $this->sut->expected_state);
        if (Tap::ON == $turnonValue) {
            $this->assertSame($falseDate, $this->sut->last_off_request);
            $this->assertNotSame($falseDate, $this->sut->last_on_request);
        } else {
            $this->assertSame($falseDate, $this->sut->last_on_request);
            $this->assertNotSame($falseDate, $this->sut->last_off_request);
        }
    }

    public function providerpleaseTurnTap(): array {
        // Force a adte to 1 year in the futre
        //@TODO this is WAY Too complex for a test
        $someFutureDAte = date((date('Y') + 1) . '-m-d H:i:s');
        $somePastDate = '2017-01-01 15:04:04';
        return [
            [true, Tap::ON, 1, null],
            [true, Tap::OFF, 1, null],
            [true, Tap::ON, 1, $somePastDate],
            [true, Tap::OFF, 1, $somePastDate],
            [false, Tap::ON, 0, $someFutureDAte],
            [false, Tap::OFF, 0, $someFutureDAte],

        ];
    }

    /**
     * @param $expected
     * @param string $onOrOff
     * @param int $expectTurnTap
     * @param $ignore_sensor_input_until
     * @dataProvider providerpleaseTurnTap
     */
    public function testpleaseTurnTap($expected, string $onOrOff, int $expectTurnTap, ?string $ignore_sensor_input_until) {
        $this->sut = $this->getMockBuilder(Tap::class)->setMethods(['turnTap'])->disableOriginalConstructor()->getMock();
        $this->sut->expects($this->exactly($expectTurnTap))->method('turnTap')->willReturn(true);
        $this->sut->ignore_sensor_input_until = $ignore_sensor_input_until;

        $this->assertSame($expected, $this->sut->pleaseTurnTap($onOrOff));

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
        $this->sut = $this->getMockBuilder(Tap::class)->setMethods(['turnTap'])->disableOriginalConstructor()->getMock();
        $this->sut->next_event_scheduled = $nextEventScheduled;
        $this->assertSame($expected, $this->sut->hasSchedule());
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
        $this->sut = $this->getMockBuilder(Tap::class)->setMethods(['save'])->disableOriginalConstructor()->getMock();
        $this->sut->next_event_scheduled = $nextEventScheduled;
        $this->sut->next_event = $nextEvent;
//        $this->sut->expects($this->any())->method('hasSchedule')->willReturn($hasSchedule);

        $this->assertSame($expected, $this->sut->getTurnOffDate());
    }

    /**
     * @covers Tap::hasSchedule
     * @covers Tap::clearEvent
     * @covers Tap::setEvent
     */
    public function testsetEvent() {
        $futureYear = ((int)date('Y')) + 2;
        $this->sut = $this->getMockBuilder(Tap::class)->setMethods(['save'])->disableOriginalConstructor()->getMock();
        $this->assertFalse($this->sut->hasSchedule());
        $this->sut->setEvent('woof', '2015-01-01 11:44:44');
        $this->assertFalse($this->sut->hasSchedule());
        $this->sut->setEvent(Tap::OFF, $futureYear . '-01-01 11:44:44');
        $this->assertTrue($this->sut->hasSchedule());
        $this->sut->clearEvent();
        $this->assertFalse($this->sut->hasSchedule());
    }


}
