<?php
namespace App\Library\Services;

use Lightning\App as LightningApp;
Use App\MessageLog;

class CloudMQTT {

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
        static::$mqtt->connect();
        sleep(1);
echo "PUBLIC -".$feed."=<Br />";
        static::$mqtt->publish($feed, json_encode($object), 0);
        static::$mqtt->close();
    }

    /**
     * timeout in seconds
     * @param string $feed
     * @param int $timeout
     */
    public function readMessage(string $feed) {
        $this->initMqtt();
        static::$mqtt->connect();
        static::$mqtt->subscribe($feed, 0, function (\Lightning\Response $response) {
            $messageLog = new MessageLog();
            $messageLog->message = $response->getMessage();
            $messageLog->route = '';
            $messageLog->topic = $response->getRoute();
            $messageLog->received = $response->getReceived();
            $messageLog->attributes = implode(', ', $response->getAttributes());
            if ($response->uid) {
                $messageLog->uid = $response->uid;
            }
            $messageLog->save();
            $message = $response->getMessage();
        echo "got to ".$messageLog->message;die();
            var_dump($message);
            flush();
        });
        static::$mqtt->listen(true);
        static::$mqtt->close();
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
                static::$mqtt = new LightningApp(
                    self::SERVER, self::PORT, 'powellblythconnection' . md5(uniqid()), self::USERNAME, self::PASSWORD);
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
}
