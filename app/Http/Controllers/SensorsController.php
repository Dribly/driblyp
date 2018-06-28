<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WaterSensor;
use App\Tap;
use App\TapControlledBySensor;
use App\Library\Services\CloudMqtt; //NOTE not clear whhy netbeans doesnt think this is used
use Illuminate\Support\Facades\Auth;
use App\Exceptions\TapNotFoundException;
use App\Exceptions\SensorNotFoundException;
use App\Exceptions\SensorIncompatibleWithTapException;
use App\Http\Controllers\TapsController;
use App\Exceptions\WaterSensorAlreadyRegisteredException;

class SensorsController extends Controller {

    private $sensorStatuses = ['active' => 'Active', 'inactive' => 'Inactive', 'deleted' => 'Deleted'];

    public function index(Request $request) {
        $sensors = WaterSensor::where('owner', Auth::user()->id)->get();
        return view('sensors.index', ['sensors' => $sensors]);
    }

    public function show(Request $request, int $id) {
        try {
            $sensor = self::getSensor($id);
        } catch (SensorNotFoundException $ex) {
            return view('404');
        }
        $sensorID = $sensor->id;
        $sensorMap = TapControlledBySensor::where('sensor_id', $sensorID)->get();
        $taps = [];
        foreach ($sensorMap as $sensorMapItem) {
            $taps[$sensorMapItem->tap_id] = Tap::where('id', $sensorMapItem->tap_id)->first();
        }
        $allUnaddedTapsAry = [];
        $allTaps = Tap::where('owner', Auth::user()->id)->get(); //->list('description','id');
// Yuck! don't know how to map model to select
        foreach ($allTaps as $tap) {
            if (!array_key_exists($tap->id, $taps)) {
                $allUnaddedTapsAry[$tap->id] = $tap->description;
            }
        }

        return view('sensors.show', [
            'statuses' => $this->sensorStatuses,
            'sensor' => $sensor,
            'lastvalue' => 0,
            'sensorMap' => $sensorMap,
            'taps' => $taps,
            'allTaps' => $allUnaddedTapsAry,
            'fakeValues' => [0 => 0, 1 => 1, 2 => 2, 5 => 5, 7 => 7, 9 => 9, 10 => 10, 20 => 20, 30 => 30, 40 => 40, 55 => 55, 66 => 66, 77 => 77, 88 => 88, 99 => 99, 100 => 100, 101 => 101]]);
    }

    /**
     * Get all taps controlled by this sensor
     * NOTE a sensor can only control a single tap
     * @param int $sensorID
     * @return array
     */
    public static function getTapsControlledBySensor(int $sensorID) {
        return TapControlledBySensor::where('sensor_id', $sensorID)->get();
    }

    /**
     * check if a sensor can have any new taps asspcoated with it
     * HINT: if it has one then no!
     * @param int $sensorID the ID of the sensor
     */
    public static function canSensorControlNewTap(int $sensorID): bool {
        if (0 === count(self::getTapsControlledBySensor($sensorID))) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 
     * @param int $sensorID
     * @param int $tapID
     * @return bool
     * @throws \App\Exceptions\TapNotFoundException
     * @throws SensorIncompatibleWithTapException
     */
    public static function controlTapWithSensor(int $sensorID, int $tapID): bool {
        try {
            $sensor = self::getSensor($sensorID);
        } catch (SensorNotFoundException $ex) {
            return view('404');
        }
        try {
            $tap = TapsController::getTap($tapID);
        } catch (TapNotFoundException $e) {
            return view('404');
        }
        // If the sensor has no taps, and they have the same owner
        // Obvs we checked the owner above, but this protects against
        // future changes
        if (self::canSensorControlNewTap($sensorID) && $sensor->owner === $tap->owner) {

            $TapControlledBySensor = new TapControlledBySensor();
            $TapControlledBySensor->tap_id = $tap->id;
            $TapControlledBySensor->sensor_id = $sensor->id;
            try {
                $TapControlledBySensor->save();
            } catch (\Exception $e) {
                throw $e;
            }
        } else {
            throw new SensorIncompatibleWithTapException('This sensor is not allowed to associate with this tap');
        }
        // If we got here then it must have worked right?
        return true;
    }

    /**
     * Controller function to connect a sensor to a tap. 
     * @param Request $request
     * @param int $id
     * @return type
     */
    public function connectToTap(Request $request, int $id) {
        try {
            self::controlTapWithSensor($id, (int) $request->post('tap_id'));
            $request->session()->flash('success', 'Tap connected!');
        } catch (\Exception $ex) {
            $request->session()->flash('warning', 'Tap could not be connected: ' . $ex->getMessage());
        }
        return redirect(Route('sensors.show', (int) $id), 302);
    }

    public static function getSensor(int $sensorID, string $uid = null): WaterSensor {
// find by UID if presented
        if (!is_null($uid)) {
            $sensor = WaterSensor::where(['uid' => $uid, 'owner' => Auth::user()->id])->first();
        } else {
            $sensor = WaterSensor::where(['id' => (int) $sensorID, 'owner' => Auth::user()->id])->first();
        }
        if (!$sensor instanceof WaterSensor) {
            throw new SensorNotFoundException();
        }
        return $sensor;
    }

    public function changestatus(Request $request, $id) {
        try {
            $sensor = self::getSensor($id);
        } catch (SensorNotFoundException $ex) {
            return view('404');
        }
        $status = $request->post('status');
        if (in_array($status, array_keys($this->sensorStatuses))) {
            $sensor->status = $status;
        } else {
            die(var_dump($status));
        }
        try {
            $sensor->save();
            $request->session()->flash('success', 'Status saved');
        } catch (\Exception $e) {
            $request->session()->flash('warning', 'Could not change status: ' . $e->getMessage());
        }

        return redirect(Route('sensors.show', (int) $id), 302);
    }

    public function add(Request $request) {
        if ($request->isMethod('POST')) {
            $sensor = new WaterSensor();
            $sensor->owner = Auth::user()->id;
            $sensor->description = $request->post('description');
            $sensor->uid = $request->post('uid');
            try {
                $dupeCheck = WaterSensor::where('uid', $tap->uid)->first();
                if ($dupeCheck instanceof WaterSensor) {
                    throw new WaterSensorAlreadyRegisteredException();
                }
                unset($dupeCheck);

                $sensor->save();
            } catch (\Exception $e) {
                var_dump($e);
                die();
            }
            return redirect(Route('sensors.show', $sensor->id), 302);
        } else {
            return view('sensors.add');
        }
    }

    public function remove(Request $request) {
        return view('sensors.remove');
    }

    public function apiUpdate(Request $request, int $id) {
        return view('404');
    }

    /**
     * Sends a false value to mqtt, for testing
     * @param Request $request
     * @param int $id
     * @param \App\Http\Controllers\CloudMQTT $customServiceInstance
     * @return type
     */
    public function sendFakeValue(Request $request, int $id, CloudMQTT $customServiceInstance) {
        try {
            $sensor = self::getSensor($id);
        } catch (SensorNotFoundException $ex) {
            return view('404');
        }
        $value = (float) $request->post('value');
        if (0.0 < $value && 100.0 >= $value) {
            $message = $this->makeMessage($sensor->uid, ['reading' => $value]);
            echo "writing message to " . CloudMQTT::makeFeedName(CloudMQTT::FEED_WATERSENSOR);
            $customServiceInstance->sendMessage(CloudMQTT::makeFeedName(CloudMQTT::FEED_WATERSENSOR), $message);
            $request->session()->flash('success', 'Fake value of ' . $value . ' sent');
        } else {
            $request->session()->flash('warning', 'Could not set fake value of ' . $value . ' to sensor ' . $id . ' because the number given was <1 or > 100');
        }

        return redirect(Route('sensors.show', (int) $id), 302);
    }

    /**
     * This function creates a message object that this controller will read later
     * @param string $deviceUid
     * @param array $message
     * @return \stdClass
     */
    public function makeMessage(string $deviceUid, array $message): \stdClass {
        $resultObj = new \stdClass();
        $resultObj->uid = $deviceUid;
        foreach ($message as $key => $value) {
            $resultObj->$key = $value;
        }
        return $resultObj;
    }

    /**
     * This handles whatever comes in from presumably mqtt
     * @param string $uid 
     * @param string $messageType
     * @param \stdClass $messageObj The object we made above with the message in it.
     * @throws SensorNotFoundException
     */
    public function handleMessage(string $uid, string $messageType, \stdClass $messageObj) {

        $sensor = WaterSensor::where(['uid' => $uid])->first();

        // Ifgnore if not a valid sensor
        if ($sensor instanceof WaterSensor) {
            switch ($messageType) {
                case 'identify':
                    $sensor->last_reading = $messageObj->last_reading;
                    $sensor->battery_level = $messageObj->battery_level;
                    $sensor->last_signal_date = date('Y-m-d H:i:s');
                    $sensor->last_signal = 'identify';
                    $sensor->save();
                    break;
                case 'update':

                    $sensor->last_reading = $messageObj->last_reading;
                    $sensor->battery_level = $messageObj->battery_level;
                    $sensor->last_signal_date = date('Y-m-d H:i:s');
                    $sensor->last_signal = 'reading';
                    $sensor->save();
                    break;
            }
        }
    }
}
