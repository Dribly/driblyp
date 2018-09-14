<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Exceptions\SensorNotFoundException;
use Exceptions\TapNotFoundException;
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

    public function waterSensors() {
        return $this->belongsToMany('App\WaterSensor');
    }

    public function getUrl() {
        return route('taps.show', ['id' => $this->id]);
    }

}
