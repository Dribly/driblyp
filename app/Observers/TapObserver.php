<?php

namespace App\Observers;

use App\Library\Services\CloudMQTT;
use App\Traits\MQTTEndpointTrait;
use App\Tap;

class TapObserver {
    use MQTTEndpointTrait;

    public function updated(Tap $tap) {
        $original = $tap->getOriginal();
        // LEt's check to see if the reading has changed. If so then we need ot process
        if ($original['expected_state'] !== $tap->expected_state) {
            $customServiceInstance = $this->getMQTTService();
            $message = $this->makeMessage($tap->uid, ['action' => 'turntap', 'state' => $tap->expected_state]);
            $customServiceInstance->sendMessage($customServiceInstance->makeFeedName(CloudMQTT::FEED_TAP, $tap->uid), $message, 1);
        }
    }
}
