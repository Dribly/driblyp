<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Tap;
class TapTest extends TestCase
{
    /**
     *
     * @return void
     */
    public function testGetUrl()
    {
        $this->sut = new Tap();
        $this->sut->id = 4;
        $this->assertSame($_SERVER['APP_URL'].'/taps/4', $this->sut->getUrl());
    }

    public function providerisActive()
    {
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
    public function testisActive(bool $expected, string $status)
    {
        $this->sut = new Tap();
        $this->sut->status = $status;
        $this->assertSame ($expected, $this->sut->isActive());
        $this->sut->status = 'inactive';
        $this->assertSame (false, $this->sut->isActive());
    }

    public function testwaterSensors()
    {
        $this->sut = new Tap();
        $waterSensors = $this->sut->waterSensors();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\BelongsToMany',$waterSensors);
        $this->assertsame('tap_water_sensor', $waterSensors->getTable());
        $this->assertsame('waterSensors', $waterSensors->getRelationName());
    }

    public function providerturnTap()
    {
        return [
            ['off','off'],
            ['on','on']
        ];
    }

    /**
     * @param $expected
     * @param $turnonValue
     * @dataProvider providerturnTap
     */
    public function testturnTap(string $expected, string $turnonValue)
    {
        $falseDate = '2017-01-01 11:11:11';

        $this->sut = $this->getMockBuilder(Tap::class)->setMethods(['save'])->disableOriginalConstructor()->getMock();
        $this->sut->method('save')->willReturn(true);

        $this->sut->last_off_request = $falseDate;
        $this->sut->last_on_request = $falseDate;

        $this->sut->turnTap($turnonValue);
        $this->assertSame($expected, $this->sut->expected_state);
        if ('on' == $turnonValue)
        {
            $this->assertSame($falseDate,  $this->sut->last_off_request);
            $this->assertNotSame($falseDate,  $this->sut->last_on_request);
        }
        else
        {
            $this->assertSame($falseDate,  $this->sut->last_on_request);
            $this->assertNotSame($falseDate,  $this->sut->last_off_request);
        }
    }

    public function providerpleaseTurnTap():array
    {
        // Force a adte to 1 year in the futre
        //@TODO this is WAY Too complex for a test
        $someFutureDAte = date((date('Y')+1) . '-m-d H:i:s');
        $somePastDate = '2017-01-01 15:04:04';
        return [
            [true, 'on', 1,null],
            [true, 'off', 1,null],
            [true, 'on', 1, $somePastDate],
            [true, 'off', 1, $somePastDate],
            [false, 'on', 0, $someFutureDAte ],
            [false, 'off', 0, $someFutureDAte],

        ];
    }

    /**
     * @param $expected
     * @param string $onOrOff
     * @param int $expectTurnTap
     * @param $ignore_sensor_input_until
     * @dataProvider providerpleaseTurnTap
     */
    public function testpleaseTurnTap($expected, string $onOrOff, int $expectTurnTap, ?string $ignore_sensor_input_until)
    {
        $this->sut = $this->getMockBuilder(Tap::class)->setMethods(['turnTap'])->disableOriginalConstructor()->getMock();
        $this->sut->expects($this->exactly($expectTurnTap))->method('turnTap')->willReturn(true);
        $this->sut->ignore_sensor_input_until = $ignore_sensor_input_until;

        $this->assertSame($expected, $this->sut->pleaseTurnTap($onOrOff));

    }
}
