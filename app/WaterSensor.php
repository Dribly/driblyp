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

    public function isActive(): bool {
        return $this->status == 'active';
    }

    /**
     * check if a sensor can have any new taps asspcoated with it
     * HINT: if it has one then no!
     * @param Tap $tap
     * @return bool
     */
    public function canControlTap(Tap $tap): bool {
        return (0 === count($this->taps)
            && $tap->owner === $this->owner
            && $tap->isActive());
    }

    /**
     * @param WaterSensor $sensor
     * @return bool
     */
    public function controlTap(Tap $tap): bool {
        $success = false;
        if ($this->canControlTap($tap)) {
            $this->taps()->attach($this);

            $success = true;// attach returns void! Thanks!!!
        }
        return $success;
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
        $feedName = CloudMQTT::makeFeedName(CloudMQTT::FEED_WATERSENSOR, $this->uid);
        echo "writing message to " . $feedName;
        $customServiceInstance->sendMessage($feedName, $message);
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
            $sensor->last_signal = $messageType;
            echo 'savig water sensor' . "\n";
            $sensor->save();
        } else {
            var_dump('not a water sensor ' . $uid);
        }
    }
}
