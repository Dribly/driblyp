<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CloudMQTTTest extends TestCase
{
    public function providerMakeFeedName()
    {
        return [
            [\App\Library\Services\CloudMQTT::FEED_WATERSENSOR, 'fakeuid', 'dribly/watersensors/fakeuid/update'],
            [\App\Library\Services\CloudMQTT::FEED_WATERSENSORIDENTIFY, '2akeuid', 'dribly/watersensors/2akeuid/identify'],
            [\App\Library\Services\CloudMQTT::FEED_TAP, 'fakeuid', 'dribly/taps/fakeuid/update'],
            [\App\Library\Services\CloudMQTT::FEED_TAPIDENTIFY, 'fakeuid', 'dribly/taps/fakeuid/identify'],
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
