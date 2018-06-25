<?php
namespace App\Library\Services;

use Lightning\App as LightningApp;
use Exceptions\InvalidMessageException;

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
        self::FEED_WATERSENSOR => "dribly/watersensors/update",
        self::FEED_WATERSENSORIDENTIFY => "dribly/watersensors/identify",
        self::FEED_TAP => "dribly/taps/update",
        self::FEED_TAPIDENTIFY => "dribly/taps/identify"
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
        static::$mqtt->subscribe($feed, 0, function (\Lightning\Response $response, MessageReader $reader) {
            try {
                $reader->readMessage($response->getMessage(), $response->getRoute(), $response->getReceived(), $response->getAttributes());
            } catch (InvalidMessageException $ex) {
                
            }
        });
        static::$mqtt->listen(true);
        static::$mqtt->close();
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

        echo "reading from " . self::makeFeedName(self::FEED_WATERSENSOR);
        $this->readMessage(self::makeFeedName(self::FEED_WATERSENSOR));
        echo "</pre>";
        return 'Output from DemoOne';
    }
}
