<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CloudMQTTTest extends TestCase
{
//        public static function makeFeedName(int $type, string $uid) {
//        $cleanUID = replace('/','',$uid);
//        return replace('/uid/','/'.$cleanUID.'/', self::FEED_TYPES[$type]);
//    }

    public function providerMakeFeedName()
    {
        
//        self::FEED_WATERSENSOR => "dribly/watersensors/uid/update",
//        self::FEED_WATERSENSORIDENTIFY => "dribly/watersensors/uid/identify",
//        self::FEED_TAP => "dribly/taps/uid/update",
//        self::FEED_TAPIDENTIFY => "dribly/taps/uid/identify"
        
        return [
            [\App\Library\Services\CloudMQTT::FEED_WATERSENSOR, 'fakeuid', 'dribly/watersensors/fakeuid/update'],
            [\App\Library\Services\CloudMQTT::FEED_WATERSENSORIDENTIFY, '2akeuid', 'dribly/watersensors/2akeuid/identify'],
            [\App\Library\Services\CloudMQTT::FEED_TAP, 'fakeuid', 'dribly/taps/fakeuid/update'],
            [\App\Library\Services\CloudMQTT::FEED_TAPIDENTIFY, 'fakeuid', 'dribly/taps/fakeuid/identify'],
//    const FEED_WATERSENSORIDENTIFY = 11;
//    const FEED_TAP = 20;
//    const FEED_TAPIDENTIFY = 21;

        ];
    }
    /**
     * A basic test example.
     *
     * @return void
     * @dataProvider providerMakeFeedName
     */
    public function testmakeFeedName($feedType, $uid, $expected)
    {
        $this->assertSame($expected, \App\Library\Services\CloudMQTT::makeFeedName($feedType, $uid));
    }
}
