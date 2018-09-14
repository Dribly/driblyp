<?php
namespace App\Library\Services;

use Bluerhinos\phpMQTT;
Use App\MessageLog;

class CloudMQTT_Rhino {

    const SERVER = 'm21.cloudmqtt.com';
    const USERNAME = 'powellblyth';
    const PASSWORD = 'moomoomoo';
    const PORT = 16317;
    const KEY = '8c3a186e-97ee-4fd2-99bd-a6d158d55999';
    const FEED_WATERSENSOR = 10;
    const FEED_WATERSENSORIDENTIFY = 11;
    const FEED_TAP = 20;
    const FEED_TAPIDENTIFY = 21;
    const FEED_TYPES = [
        self::FEED_WATERSENSOR => "powellblyth/feeds/watersensors",
        self::FEED_WATERSENSORIDENTIFY => "powellblyth/feeds/watersensoridentifies",
        self::FEED_TAP => "powellblyth/feeds/taps",
        self::FEED_TAPIDENTIFY => "powellblyth/feeds/tapidentifies"
    ];

    /*
     * @var phpMQTT $mqtt 
     */

    static $mqtt;

    public static function makeFeedName(int $type) {
        return self::FEED_TYPES[$type];
    }

    public function sendMessage(string $feed, $message) {

        if (!is_object($message)) {
            $object = new \stdClass();
            $object->message = $message;
        } else {
            $object = $message;
        }


        $this->initMqtt();
        sleep(1);
        echo "PUBLIC -" . $feed . "=<Br />";
        static::$mqtt->publish($feed, json_encode($object), 0);
    }

    /**
     * timeout in seconds
     * @param string $feed
     * @param int $timeout
     */
    public function readMessage(string $feed) {
        $this->initMqtt();

        $topics[$feed] = array(
            "qos" => 0,
            "function" => "procmsg"
        );
        static::$mqtt->subscribe($topics, 0);
        while (static::$mqtt->proc()) {
            
        }
        static::$mqtt->close();


//        static::$mqtt->listen(true);
//        static::$mqtt->close();
//        if (static::$mqtt->connect(true, NULL, self::USERNAME, self::KEY)) {
//            $topics[self::FEED_TYPES[$feed]] = array("qos" => 0, "function" => "procmsg");
//            static::$mqtt->subscribe($topics, 0);
////            var_dump(static::$mqtt->message(self::FEED_TYPES[$feed]));
////            
//$x = 0;
//            while (static::$mqtt->proc(false)) {
//                sleep(1);
//                echo "HI<br />\n";
//                if ($x++ > 2){break;}
////                $mqtt = new phpMQTT();
////                static::$mqtt->proc(true);
//            }
//            static::$mqtt->close();
//        } else {
//            echo "Time out, could not read message!\n";
//        }
    }

    function procmsg($topic, $msg) {
        echo "Msg Received: " . date("r") . "\n";
        echo "Topic: {$topic}\n\n";
        echo "\t$msg\n\n";
        exit;
    }

    /**
     * Simply initiates the MQTT if it is not already done
     */
    private function initMqtt() {
        if (!static::$mqtt) {
            try {
//$mqtt = new Bluerhinos\phpMQTT($url['host'], $url['port'], $client_id);
//if ($mqtt->connect(true, NULL, $url['user'], $url['pass'])) {
//    $mqtt->publish($topic, $message, 0);
//    echo "Published message: " . $message;
//    static::$mqtt->close();
//}else{
//    echo "Fail or time out<br />";
//}                
                static::$mqtt = new phpMQTT(self::SERVER, self::PORT, 'powellblythconnection' . md5(uniqid()));
                if (static::$mqtt->connect(true, NULL, self::USERNAME, self::PASSWORD)) {
                    echo "Connected";
                } else {
                    unset(static::$mqtt);
                }
//                    self::SERVER, self::PORT, 'powellblythconnection' . md5(uniqid()), self::USERNAME, self::PASSWORD);
//                        new Client(, self::USERNAME,"HeresJohnny");
            } catch (Exception $e) {
                var_dump($e);
                exit;
            }
            static::$mqtt->debug = true;
        }
    }

    public function doSubscriptions() {
        echo "<pre>";
        echo "<pre>";
        echo "<h1>Begin monitor</h1>";
        $this->readMessage(self::FEED_WATERSENSOR);
        echo "</pre>";
        return 'Output from DemoOne';
    }

    public function writeTestMessage() {
        echo "<pre>";
        echo "<h1>Begin writign</h1>";
        echo "<a href=\"/mqttsendmessage\">Reload</a><br />";
        echo '<pre>';

        $message = date('s.U') . "s ALSOHello World! at " . date("r");
        echo "Wrigting to " . self::makeFeedName(self::FEED_WATERSENSOR);
        $this->sendMessage(self::makeFeedName(self::FEED_WATERSENSOR), $message);
        return 'done writing ' . $message . "\n";
    }

    public function messageBoard() {
//        flush();
        echo "<pre>";
        echo "<h1>Begin monitor</h1>";
        flush();
//        echo "slept";
//            $messageLog = new \App\MessageLog();
//            $messageLog->message =  'message';
//            $messageLog->topic =  'topic';
//            $messageLog->route =  'route';
//            $messageLog->received =  'received';
//            $messageLog->attributes =  'attributes';
//            $messageLog->save();
//        echo "exiting";exit();
//        $this->sendMessage(self::FEED_WATERSENSOR, date('s') . "s Hello World! at " . date("r"));
        echo "reading from " . self::makeFeedName(self::FEED_WATERSENSOR);
        $this->readMessage(self::makeFeedName(self::FEED_WATERSENSOR));
//        $this->sendMessage(self::FEED_WATERSENSOR, date('s') . "s Bananas are great! at " . date("r"));
        echo "</pre>";
        return 'Output from DemoOne';
    }

    public function __destruct() {
        if (static::$mqtt instanceof phpMQTT) {
            static::$mqtt->close();
        }
    }
}

function progMsg($topic, $msg) {
    $messageLog = new MessageLog();
    $messageLog->message = $msg;
    $messageLog->route = '';
    $messageLog->topic = $topic;
    $messageLog->received = date('Y-m-d H:i:s');
    $messageLog->attributes = '';
//            if ($response->uid) {
//                $messageLog->uid = $response->uid;
//            }
    $messageLog->save();
    $message = $msg;
    echo "got to " . $msg;
    var_dump($msg);
    die();
    flush();
}
