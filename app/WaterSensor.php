<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\MQTTEndpointTrait;
use App\Library\Services\CloudMQTT;
use App\Exceptions\SensorNotFoundException;

class WaterSensor extends Model {
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

    public function getUrl() {
        return route('sensors.show', ['id' => $this->id]);
    }

    /**
     * Determine if a sensor needs to be watered
     * @return bool
     */
    public function needsWater(): bool {
        // If the tap is expected to be on, then we only decide we don;t need water when
        // we hit a higher threshold
        if ($this->expected_state === 'on') {
            $needsWater = $this->last_reading < ($this->threshold + 15);
        } else {
            $needsWater = $this->last_reading < $this->threshold;
        }
        return $needsWater;
    }

    public static function getSensor(int $ownerId, int $sensorID, string $uid = null): WaterSensor {
// find by UID if presented
        if (!is_null($uid)) {
            $sensor = WaterSensor::where(['uid' => $uid, 'owner' => $ownerId])->first();
        } else {
            $sensor = WaterSensor::where(['id' => (int)$sensorID, 'owner' => $ownerId])->first();
        }
        if (!$sensor instanceof WaterSensor) {
            throw new SensorNotFoundException();
        }
        return $sensor;
    }

    public function sendFakeValue($value) {
        $customServiceInstance = $this->getMQTTService();
        $message = $this->makeMessage($this->uid, ['reading' => $value]);
        echo "writing message to " . CloudMQTT::makeFeedName(CloudMQTT::FEED_WATERSENSOR, $this->uid);
        $customServiceInstance->sendMessage(CloudMQTT::makeFeedName(CloudMQTT::FEED_WATERSENSOR, $this->uid), $message);
    }
    public function taps() {
        return $this->belongsToMany('App\Tap');
    }
    /**
     * This handles whatever comes in from presumably mqtt. Should be in WaterSensorHandler
     * @param string $uid
     * @param string $messageType
     * @param \stdClass $messageObj The object we made above with the message in it.
     * @throws SensorNotFoundException
     */
    public static function handleMessage(string $uid, string $messageType, \stdClass $messageObj) {

        $sensor = WaterSensor::where(['uid' => $uid])->first();

        // Ifgnore if not a valid sensor
        if ($sensor instanceof WaterSensor) {
            switch ($messageType) {
                case 'identify':
                    break;
                case 'update':
                    if (isset($messageObj->reading)) {
                        $sensor->last_reading = $messageObj->reading;
                    }
                    break;
                default:
                    break;
            }
            if (isset($messageObj->battery_level)) {
                $sensor->battery_level = $messageObj->battery_level;
            }
            $sensor->last_signal_date = date('Y-m-d H:i:s');
            $sensor->last_signal = 'identify';
            $sensor->save();
        }
    }
}
