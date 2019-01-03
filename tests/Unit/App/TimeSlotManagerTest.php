<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\TimeSlotManager;

class TimeSlotManagerTest extends TestCase {

    public function providergetNowDayNumber(): array {
        // Lazy, but I really just need to know that it's returning the current dayo f week
        return [[date('w')]
        ];
    }

    /**
     * @param int $expected
     *
     * @dataProvider providergetNowDayNumber
     */
    public function testgetNowDayNumber(int $expected) {
//        echo "expecting ".$expected;
        $sut = $this->getMockBuilder(TimeSlotManager::class)->setMethods()->disableOriginalConstructor()->getMock();
//var_dump(get_class($sut));
        $this->assertSame($expected, $sut->getNowDayNumber());
    }

    public function providergetNowHour(): array {
        // Lazy, but I really just need to know that it's returning the current dayo f week
        return [[date('G')]
        ];
    }

    /**
     * @param int $expected
     * @dataProvider providergetNowHour
     */
    public function testgetNowHour(int $expected) {
        $sut = $this->getMockBuilder(TimeSlotManager::class)->setMethods()->disableOriginalConstructor()->getMock();
        $this->assertSame($expected, $sut->getNowHour());
    }

    /**
     * Tests all the iterators
     * @covers key
     * @covers next
     * @covers rewind
     */
    public function testIterators() {
        $sut = $this->getMockBuilder(TimeSlotManager::class)->setMethods()->disableOriginalConstructor()->getMock();
        $this->assertSame(0, $sut->key());
        $sut->next();
        $this->assertSame(1, $sut->key());
        $sut->rewind();
        $this->assertSame(0, $sut->key());
    }

    public function providergetDayName(): array {
        return [
            ['Mon', 0],
            ['Wed', 2],
            ['Fri', 4],
            ['Sun', 6],
        ];
    }

    /**
     * @param string $expected
     * @param int $dayNum
     * @dataProvider providergetDayName
     */
    public function testgetDayName(string $expected, int $dayNum) {
        $sut = $this->getMockBuilder(TimeSlotManager::class)->setMethods()->disableOriginalConstructor()->getMock();
        $this->assertSame($expected, $sut->getDayName($dayNum));
    }
}
