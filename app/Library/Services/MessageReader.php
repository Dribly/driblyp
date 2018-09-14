<?php
namespace App\Library\Services;

Use App\MessageLog;
use App\Exceptions\InvalidMessageException;
class MessageReader {

    /**
     * timeout in seconds
     * @param string $feed
     * @param int $timeout
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
        // Route part 1 is env, route part 2 is approx
        switch ($routeParts[1]) {
            
            case 'watersensors':
                $controller = new \App\Http\Controllers\SensorsController();
                $controller->handleMessage($messageObj->uid, $routeParts[2], $messageObj);
                
            case 'taps':
                $controller = new \App\Http\Controllers\TapsController();
                $controller->handleMessage($messageObj->uid, $routeParts[2], $messageObj);
                // EEP this should not happen, we should not be reading tap messages
                ;
                break;
            default:
                '';
        }

        $messageLog->save();
    }
}