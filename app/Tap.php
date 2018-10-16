<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\TapNotFoundException;
use App\Traits\MQTTEndpointTrait;
use App\Library\Services\CloudMQTT;
use App\TimeSlotManager;

class Tap extends Model {
    const OFF = 'off';
    const ON = 'on';
    public static $validEvents = [self::ON, self::OFF];
    protected $timeSlotManager;
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
     * This function is for sensors to politeley request more or no more water
     * It differs from turnTap in that the tap is able to deny the request
     * due to having had a manual override
     * @param string $onOrOff
     * @return bool
     */
    public function pleaseTurnTap(string $onOrOff = Tap::OFF): bool {
        if (is_null($this->ignore_sensor_input_until)
            || strtotime($this->ignore_sensor_input_until) < time()) {
            return $this->turnTap($onOrOff);
        } else {
            return false;
        }
    }

    /**
     * Check if this event has a schedule
     * @return bool
     */
    public function hasSchedule(): bool {
        $hasSchedule = false;
        if (!is_null($this->next_event_scheduled)) {
            $nextEventDate = strToTime($this->next_event_scheduled);
            $hasSchedule = ($nextEventDate > time());

        }
        return $hasSchedule;
    }

    /**
     * work out some text to show the exturn off or on event
     * @return string
     */
    public function getTurnOffDate(): string {
        $string = '';
        if (!is_null($this->next_event) && $this->hasSchedule()) {
            $nextEventDate = strToTime($this->next_event_scheduled);
            $next_event = $this->next_event;
            $date = date('d M Y \a\t H:i', $nextEventDate);
            $string = 'The tap will turn ' . $next_event . ' at ' . $date;
        }
        return $string;
    }

    /**
     * @param $event
     * @param string $date
     * @return bool
     */
    public function setEvent($event, string $date): bool {
        $result = false;
        if (in_array($event, static::$validEvents)) {
            $this->next_event = $event;
            $this->next_event_scheduled = $date;
            $result = true;
        }
        return $result;
    }

    /**
     * @return bool
     */
    public function clearEvent(): bool {
        $this->next_event = null;
        $this->next_event_scheduled = null;
        return true;
    }

    /**
     * @param string $onOrOff
     * @param int $timePeriodMinutes
     * @TODO move this to observer
     */
    public function turnTap(string $onOrOff = Tap::OFF, int $timePeriodMinutes = 0) {
        // Belt and braces. You have to REALLY mean Tap::ON here
        if (trim(strToLower($onOrOff)) !== Tap::ON) {
            $this->last_off_request = gmdate('Y-m-d H:i:s');
            $this->clearEvent();

        } else {
            // If we turn the tap on, make sure we set an event to turn it off
            if (0 < $timePeriodMinutes) {
                $this->setEvent(Tap::OFF, gmdate('Y-m-d H:i:s', time() + (abs($timePeriodMinutes) * 60)));
            }
            $this->last_on_request = gmdate('Y-m-d H:i:s');
        }
        $this->expected_state = $onOrOff;
        $this->ignore_sensor_input_until = gmdate('Y-m-d H:i:s', time() + (abs($timePeriodMinutes) * 60));
        return $this->save();
    }

    /**
     * We want to pretend we are a tap, so we scrub the previous message then start the next
     * @param $value
     */
    public function sendFakeResponse($value) {
        $customServiceInstance = $this->getMQTTService();

        // First, we clear the topic
        $feedName = $customServiceInstance->makeFeedName(CloudMQTT::FEED_TAP, $this->uid);
        $customServiceInstance->clearTopic($feedName);

        $feedName = $customServiceInstance->makeFeedName(CloudMQTT::FEED_TAPREPLY, $this->uid);
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

    public function isActive() {
        return $this->status == 'active';
    }

    /**
     * @param bool $loadFromDb choose whether to reset from DB or to load the current / blank one
     * @return \App\TimeSlotManagerget the relevant timeslot manager for this tap.
     */
    public function getTimeSlotManager($loadFromDb=true): TimeSlotManager {

        if (!isset($this->timeSlotManager)){
           $this->timeSlotManager = new TimeSlotManager(($this->id));
       }
       if ($loadFromDb){
           $this->timeSlotManager->load();
       }
       return $this->timeSlotManager;
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
                        switch (trim(strToLower($messageObj->state))) {
                            case Tap::ON:
                                $tap->last_on_request = gmdate('Y-m-d H:i:s');
                                break;
                            case Tap::OFF:
                                $tap->last_off_request = gmdate('Y-m-d H:i:s');
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
                        switch (trim(strToLower($messageObj->state))) {
                            case Tap::ON:
                                $tap->last_on = gmdate('Y-m-d H:i:s');
                                break;
                            case Tap::OFF:
                                $tap->last_off = gmdate('Y-m-d H:i:s');
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
            $tap->last_signal_date = gmdate('Y-m-d H:i:s');
            if (!empty($messageObj->battery_level)) {
                $tap->last_battery_level = $messageObj->last_battery_level;
            }
            $tap->save();
        }
    }
}
