<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\Services\CloudMqtt;

class MQTTController extends Controller {

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendmessage(CloudMQTT $customServiceInstance)
    {
        echo $customServiceInstance->writeTestMessage();
    }
    public function monitor(CloudMQTT $customServiceInstance)
    {
        echo $customServiceInstance->messageBoard();
    }
    public function iframe()
    {
        return view('mqtt.iframe');
    }
}
