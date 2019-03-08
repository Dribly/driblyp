<?php

namespace App\Library\Services;

use Lightning\App as LightningApp;
use App\Exceptions\InvalidMessageException;

class CloudMQTT {

    private $SERVER;
    private $USERNAME;
    private $PASSWORD;
    private $PORT;
    private $KEY;
    private $PREFIX;

    const FEED_WATERSENSOR = 10;
    const FEED_WATERSENSORIDENTIFY = 11;
    const FEED_TAP = 20;
    const FEED_TAPIDENTIFY = 21;
    const FEED_TAPREPLY = 22;
    const FEED_TYPES = [
        self::FEED_WATERSENSOR => "watersensors/update/uid/",
        self::FEED_WATERSENSORIDENTIFY => "watersensors/identify/uid/",
        self::FEED_TAP => "taps/update/uid/",
        self::FEED_TAPIDENTIFY => "taps/identify/uid/",
        self::FEED_TAPREPLY => "taps/response/uid/",
    ];

    public function __construct() {
        $this->SERVER = config('cloudmqtt.server.server_name');
        $this->USERNAME = config('cloudmqtt.server.username');
        $this->PASSWORD = config('cloudmqtt.server.password');
        $this->PORT = config('cloudmqtt.server.port');
        $this->KEY = config('cloudmqtt.server.key');
        $this->PREFIX = config('cloudmqtt.server.prefix');
    }

    /*
     * @var phpMQTT $mqtt 
     */

    private $mqtt;

    /**
     * Create a feed name from a feed and a UID
     * @param int $type
     * @param string $uid
     * @return type
     */
    public function makeFeedName(int $type, string $uid): string {
        $cleanUID = str_replace('/', '', $uid);
        return rtrim($this->PREFIX, '/') . '/' . str_replace('/uid/', '/' . $cleanUID . '/', self::FEED_TYPES[$type]);
    }

    /**
     *
     * @param string $feed which feed the message goes to
     * @param type $message
     * @param int $retain
     */
    public function sendMessage(string $feed, $message, int $retain = 0) {

        if (!is_object($message)) {
            $object = new \stdClass();
            $object->message = $message;
        } else {
            $object = $message;
        }

        $this->initMqtt();
        $this->mqtt->publish($feed, json_encode($object), 0, $retain);
    }

    /**
     * Function to clear a messaeg that is stuck
     * @param string $feed
     */
    public function clearTopic(string $feed) {
        echo "clearing with " . $feed . "\n";
        $this->initMqtt();
        $this->mqtt->publish($feed, null, 0, 1);
    }

    /**
     * timeout in seconds
     * @param arraay $feeds
     */
    public function readMessage(array $feeds) {
        $this->initMqtt();
        foreach ($feeds as $feed) {
            $this->mqtt->subscribe($feed, 0, function (\Lightning\Response $response) {
                try {
                    $reader = new MessageReader();
                    $reader->readMessage($response->getMessage(), $response->getRoute(), $response->getReceived(), $response->getAttributes());
                } catch (InvalidMessageException $ex) {

                }
            });
        }
        $this->mqtt->listen(true);
    }

    /**
     * Simply initiates the MQTT if it is not already done
     */
    private function initMqtt() {
        if (!$this->mqtt) {
            try {
                var_dump([ $this->SERVER, $this->PORT, 'powellblythconnection' . md5(uniqid()), $this->USERNAME, $this->PASSWORD]);
                $this->mqtt = new LightningApp(
                    $this->SERVER, $this->PORT, 'powellblythconnection' . md5(uniqid()), $this->USERNAME, $this->PASSWORD);
//                        new Client(, self::USERNAME,"HeresJohnny");
                $this->mqtt->connect();
            } catch (Exception $e) {
                var_dump($e);
                exit;
            }
            $this->mqtt->debug = false;
        }
    }

    public function __destruct() {
        // TODO: Implement __destruct() method.
        echo "\nCLOSING MQTT\n";
        if ($this->mqtt) {
            $this->mqtt->close();
        }
    }

}
