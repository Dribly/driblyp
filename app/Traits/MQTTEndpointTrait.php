<?php
/**
 * Created by PhpStorm.
 * User: toby
 * Date: 16/08/2018
 * Time: 18:29
 */

namespace App\Traits;
use App\Library\Services\CloudMQTT;

trait MQTTEndpointTrait {
    /**
     * This function creates a message object that this controller will read later
     * @param string $deviceUid
     * @param array $message
     * @return \stdClass
     */
    public function makeMessage(string $deviceUid, array $message): \stdClass {
        $resultObj = new \stdClass();
        $resultObj->uid = $deviceUid;
        foreach ($message as $key => $value) {
            $resultObj->$key = $value;
        }
        return $resultObj;
    }
    protected function getMQTTService(): CloudMQTT
    {
        return new CloudMQTT();
    }

}