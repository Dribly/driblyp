<?php
namespace App\Library\Services;

Use App\MessageLog;
use App\Exceptions\InvalidMessageException;
use App\WaterSensor;
use App\Tap;

class MessageReader {

    /**
     * timeout in seconds
     * @param string $message
     * @param $route
     * @param $received
     * @param $attributes
     * @throws InvalidMessageException
     * @throws \App\Exceptions\SensorNotFoundException
     */
    public function readMessage(string $message, $route, $received, $attributes) {
        $messageObj = @json_decode($message);

        // Log the message anyway
        $messageLog = new MessageLog();
        $messageLog->message = $message;
        $messageLog->route = '';
        $messageLog->topic = $route;
        $messageLog->received = $received;
        $messageLog->attributes = implode(', ', $attributes);

        if (!is_object($messageObj)) {
            $messageLog->status = 'error';
            $messageLog->save();
            throw new InvalidMessageException($message, 'Could not decode message');
        }

        // Log any meta data we can find
        if (isset($messageObj->uid)) {

            $messageLog->device_uid = $messageObj->uid;
        }
        $messageLog->status = 'success';
        // Expecting basehome/thing/thong or similar
        $routeParts = explode('/', $route);
echo "Message address is " . $route."\n";
        // Route part 1 is env, route part 2 is approx
        switch ($routeParts[1]) {
            
            case 'watersensors':
                WaterSensor::handleMessage($messageObj->uid, $routeParts[2], $messageObj);
                echo "processed watersensors message ".$routeParts[2]." for ".$messageObj->uid."\n";
                break;
            case 'taps':
                Tap::handleMessage($messageObj->uid, $routeParts[2], $messageObj);
                // EEP this should not happen, we should not be reading tap messages
                echo "processed tap message ".$routeParts[2]." for ".$messageObj->uid."\n";
                break;
            default:
                error_log('could not process message '.$message);
echo "IGNORED ".$routeParts[1] ." message\n";
        }

        $messageLog->save();
    }
}
