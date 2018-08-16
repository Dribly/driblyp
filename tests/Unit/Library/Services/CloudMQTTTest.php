<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CloudMQTTTest extends TestCase
{
    public function providerMakeFeedName()
    {
        return [
            [\App\Library\Services\CloudMQTT::FEED_WATERSENSOR, 'fakeuid', 'dribly/watersensors/update/fakeuid/'],
            [\App\Library\Services\CloudMQTT::FEED_WATERSENSOR, 'f/a/keui/d', 'dribly/watersensors/fakeuid/update/fakeuid/'],
            [\App\Library\Services\CloudMQTT::FEED_WATERSENSORIDENTIFY, '2akeuid', 'dribly/watersensors/identify/2akeuid/'],
            [\App\Library\Services\CloudMQTT::FEED_TAP, 'fakeuid', 'dribly/taps/update/fakeuid/'],
            [\App\Library\Services\CloudMQTT::FEED_TAPIDENTIFY, 'fakeuid', 'dribly/taps/identify/fakeuid/'],
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
