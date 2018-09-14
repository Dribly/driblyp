<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\SensorNotFoundException;
use App\Exceptions\TapNotFoundException;
use App\Traits\MQTTEndpointTrait;
use App\Library\Services\CloudMQTT;


class Tap extends Model{
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

    public function turnTap(string $onOrOff = 'off') {

        $customServiceInstance = $this->getMQTTService();

        // Belt and braces. You have to REALLY mean 'on' here
        if (trim(strToLower($onOrOff)) !== 'on') {
            $onOrOff = 'off';
        }
        $message = $this->makeMessage($this->uid, ['action'=>'turntap', 'value' => $onOrOff]);
        $customServiceInstance->sendMessage(CloudMQTT::makeFeedName(CloudMQTT::FEED_TAP, $this->uid), $message, 1);
        $this->requested_state = $onOrOff;
        $this->save();
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

        if (($tap instanceof Tap)) {
            $tap->last_signal = $messageType;
            $tap->last_signal_date = date('Y-m-d H:i:s');
            if (!empty($messageObj->battery_level)) {
                $tap->last_battery_level = $messageObj->last_battery_level;
            }
            switch ($messageType) {
                case 'identify':
                    throw new \Exception('Cannot use ' . $messageType . ' in ' . $routeParts[1]);
                    break;
                case 'update':
                    $tap->reported_state = $messageObj->state;
                    switch ($tap->reported_state) {
                        case 'on':
                            $tap->last_on = date('Y-m-d H:i:s');
                            break;
                        case 'off':
                            $tap->last_off = date('Y-m-d H:i:s');
                            break;
                        default:
                            ;
                            break;
                    }
                    throw new \Exception('Cannot use ' . $messageType . ' in ' . $routeParts[1]);

                    break;
            }
            $tap->save();
        }
    }
}
