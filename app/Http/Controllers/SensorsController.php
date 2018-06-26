<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WaterSensor;
use App\Tap;
use App\TapControlledBySensor;
use App\Library\Services\CloudMqtt; //NOTE not clear whhy netbeans doesnt think this is used
use Illuminate\Support\Facades\Auth;
use App\Exceptions\SensorNotFoundException;

class SensorsController extends Controller {

    private $sensorStatuses = ['active' => 'Active', 'inactive' => 'Inactive', 'deleted' => 'Deleted'];

    public function index(Request $request) {
        $sensors = WaterSensor::where('owner', Auth::user()->id)->get();
        return view('sensors.index', ['sensors' => $sensors]);
    }

    public function show(Request $request, int $id, CloudMQTT $customServiceInstance) {
        try {
            $sensor = $this->getSensor($id);
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
//            $lastValue = $customServiceInstance->readMessage(CloudMQTT::FEED_WATERSENSOR.'/'.(int)$id, 5);

        return view('sensors.show', [
            'statuses' => $this->sensorStatuses,
            'sensor' => $sensor,
            'lastvalue' => 0,
            'sensorMap' => $sensorMap,
            'taps' => $taps,
            'allTaps' => $allUnaddedTapsAry]);
    }

    public function connectToTap(Request $request, int $id) {
        try {
            $sensor = $this->getSensor($id);
        } catch (SensorNotFoundException $ex) {
            return view('404');
        }
        $tapID = (float) $request->post('tap_id');
        $tap = Tap::where(['id' => (int) $tapID, 'owner' => Auth::user()->id])->first();
        if ($tap instanceof Tap) {
            $TapControlledBySensor = TapControlledBySensor::where('tap_id', $tapID)->where('sensor_id', $id)->first();
            // Don't add the same relationship twice
            if (!$TapControlledBySensor instanceof TapControlledBySensor) {
                $TapControlledBySensor = new TapControlledBySensor();
                $TapControlledBySensor->tap_id = $tapID;
                $TapControlledBySensor->sensor_id = $id;
            }
            try {
                $TapControlledBySensor->save();
            } catch (\Exception $e) {
                var_dump($e);
                die();
            }
        }
        return redirect(Route('sensors.show', (int) $id), 302);
    }

    protected function getSensor(int $sensorID, string $uid = null): WaterSensor {
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
            $sensor = $this->getSensor($id);
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
        } catch (\Exception $e) {
            var_dump($e);
            die();
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

    //

    public function apiUpdate(Request $request, int $id) {
        return view('404');
    }

    public function makeMessage(string $deviceUid, array $message): \stdClass {
        $resultObj = new \stdClass();
        $resultObj->uid = $deviceUid;
        foreach ($message as $key => $value) {
            $resultObj->$key = $value;
        }
        return $resultObj;
    }

    /**
     * Sends a false value to mqtt, for testing
     * @param Request $request
     * @param int $id
     * @param \App\Http\Controllers\CloudMQTT $customServiceInstance
     * @return type
     */
    public function sendFakeValue(Request $request, int $id, CloudMQTT $customServiceInstance) {
        $saveLastValue = false;
        try {
            $sensor = $this->getSensor($id);
        } catch (SensorNotFoundException $ex) {
            return view('404');
        }
        $value = (float) $request->post('value');
        if (0.0 < $value && 100.0 >= $value) {
            if ($saveLastValue) {
                $sensor->lastvalue = $value;
            }
            $message = $this->makeMessage($sensor->uid, ['reading' => $value]);
            echo "writing message to " . CloudMQTT::makeFeedName(CloudMQTT::FEED_WATERSENSOR);
            $customServiceInstance->sendMessage(CloudMQTT::makeFeedName(CloudMQTT::FEED_WATERSENSOR), $message);
        } else {
            die(var_dump($value));
        }
        try {
            if ($saveLastValue) {
                $sensor->save();
            }
        } catch (\Exception $e) {
            var_dump($e);
            die();
        }

        return redirect(Route('sensors.show', (int) $id), 302);
    }

    /**
     * This handles whatever comes in from presumably mqtt
     * @param string $uid 
     * @param string $messageType
     * @param \stdClass $messageObj The object we made above with the message in it.
     * @throws SensorNotFoundException
     */
    public function handleMessage(string $uid, string $messageType, \stdClass $messageObj) {
        try {
            $sensor = $this->getSensor(0, $uid);
        } catch (SensorNotFoundException $ex) {
            throw new \App\Exceptions\SensorNotFoundException();
        }
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
