<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use \App\Library\Services\CloudMQTT;

class CloudMQTTTest extends TestCase {
    public function setup() {
        parent::setup();
    }

    public function providerMakeFeedName(): array {
        parent::setup();
        return [
            [config('cloudmqtt.server.prefix') . '/watersensors/update/fakeuid/', CloudMQTT::FEED_WATERSENSOR, 'fakeuid'],
            [config('cloudmqtt.server.prefix') . '/watersensors/update/fakeuid/', CloudMQTT::FEED_WATERSENSOR, 'f/a/keui/d'],
            [config('cloudmqtt.server.prefix') . '/watersensors/identify/2akeuid/', CloudMQTT::FEED_WATERSENSORIDENTIFY, '2akeuid'],
            [config('cloudmqtt.server.prefix') . '/taps/update/fakeuid/', CloudMQTT::FEED_TAP, 'fakeuid'],
            [config('cloudmqtt.server.prefix') . '/taps/response/fakeuid/', CloudMQTT::FEED_TAPREPLY, 'fakeuid',],
            [config('cloudmqtt.server.prefix') . '/taps/identify/fakeuid/', CloudMQTT::FEED_TAPIDENTIFY, 'fakeuid'],
        ];
    }

    /**
     * A basic test example.
     *
     * @return void
     * @dataProvider providerMakeFeedName
     */
    public function testmakeFeedName(string $expected, int $feedType, string $uid) {
        $sut = $this->getMockBuilder('CloudMQTT')->setMethods([])->disableOriginalDestructor()->disableOriginalConstructor()->getMock();
        $this->assertSame($expected, $sut->makeFeedName($feedType, $uid));
    }
}
