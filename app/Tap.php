<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\TapNotFoundException;
use App\Traits\MQTTEndpointTrait;
use App\Library\Services\CloudMQTT;

class Tap extends Model {
    use MQTTEndpointTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description', 'owner', 'uid', 'last_signal', 'last_signal_date',
        'remember_token', 'battery_level', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'owner'
    ];

    /**
     * @param string $onOrOff
     * @TODO move this to observer
     */
    public function turnTap(string $onOrOff = 'off') {

        // Belt and braces. You have to REALLY mean 'on' here
        if (trim(strToLower($onOrOff)) !== 'on') {
            $this->last_off_request = date('Y-m-d H:i:s');

        } else {
            $this->last_off_request = date('Y-m-d H:i:s');
        }
        $this->expected_state = $onOrOff;
        $this->save();
    }

    /**
     * We want to pretend we are a tap, so we scrub the previous message then start the next
     * @param $value
     */
    public function sendFakeResponse($value) {
        $customServiceInstance = $this->getMQTTService();

        // First, we clear the topic
        $feedName = CloudMQTT::makeFeedName(CloudMQTT::FEED_TAP, $this->uid);
        $customServiceInstance->clearTopic($feedName);

        $feedName = CloudMQTT::makeFeedName(CloudMQTT::FEED_TAPREPLY, $this->uid);
        $message = $this->makeMessage($this->uid, ['state' => $value]);
        echo "writing message to " . $feedName;
        $customServiceInstance->sendMessage($feedName, $message);
    }

    public static function getTap(int $ownerId, int $tapID, string $uid = null): Tap {
// find by UID if presented
        if (!is_null($uid)) {
            $tap = Tap::where(['uid' => $uid, 'owner' => $ownerId])->first();
        } else {
            $tap = Tap::where(['id' => (int)$tapID, 'owner' => $ownerId])->first();
        }
        if (!$tap instanceof Tap) {
            throw new TapNotFoundException();
        }

        return $tap;
    }

    public function waterSensors() {
        return $this->belongsToMany('App\WaterSensor');
    }

    public function getUrl() {
        return route('taps.show', ['id' => $this->id]);
    }

    public static function handleMessage($uid, $messageType, \stdClass $messageObj) {
        $tap = Tap::where(['uid' => $uid])->first();
        echo "got a message\n";
        var_dump($messageObj);
        echo "\nend of a message\n";
        if (($tap instanceof Tap)) {
            switch ($messageType) {
                case 'identify':
                    throw new \Exception('Cannot use ' . $messageType . ' in taps ');
                    break;
                case 'update':
                    if (isset($messageObj->state)) {
                        switch ($messageObj->state) {
                            case 'on':
                                $tap->last_on_request = date('Y-m-d H:i:s');
                                break;
                            case 'off':
                                $tap->last_off_request = date('Y-m-d H:i:s');
                                break;
                            default:
                                throw new \Exception('Cannot use ' . $messageObj->state . ' as last state fpr ' . $messageType);
                                break;
                        }
                    }
                    if (isset($messageObj->state)) {
                        $tap->reported_state = $messageObj->state;
                    }

                    break;
                case 'response':
                    if (isset($messageObj->state)) {
                        switch ($messageObj->state) {
                            case 'on':
                                $tap->last_on = date('Y-m-d H:i:s');
                                break;
                            case 'off':
                                $tap->last_off = date('Y-m-d H:i:s');
                                break;
                            default:
                                throw new \Exception('Cannot use ' . $messageObj->state . ' as last state fpr ' . $messageType);
                                break;
                        }
                    }
                    if (isset($messageObj->state)) {
                        $tap->reported_state = $messageObj->state;
                    }

                    break;
            }
            $tap->last_signal = $messageType;
            $tap->last_signal_date = date('Y-m-d H:i:s');
            if (!empty($messageObj->battery_level)) {
                $tap->last_battery_level = $messageObj->last_battery_level;
            }
            $tap->save();
        }
    }
}
