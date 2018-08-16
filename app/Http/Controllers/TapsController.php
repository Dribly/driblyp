<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tap;
use App\WaterSensor;
use App\TapControlledBySensor;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\TapNotFoundException;
use App\Http\Controllers\SensorsController;
use App\Exceptions\TapAlreadyRegisteredException;

class TapsController extends Controller {

    private $tapStatuses = ['active' => 'Active', 'inactive' => 'Inactive', 'deleted' => 'Deleted'];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request) {
        $taps = Tap::where('owner', Auth::user()->id)->get();
        return view('taps.index', ['taps' => $taps]);
    }

    /**
     * gets all sensor IDs for sensors which can control this tap
     * @param type $tapID
     * @return type
     */
    public function getSensorIdsForTapId($tapID) {
        return TapControlledBySensor::where('tap_id', $tapID)->get();
    }

    public function show(Request $request, $id) {
        try {
            $tap = self::getTap($id);
        } catch (TapNotFoundException $ex) {
            return view('404');
        }
        $tapID = $tap->id;
        $sensorMap = TapControlledBySensor::where('tap_id', $tapID)->get();
        $sensors = [];
        foreach ($sensorMap as $sensorMapItem) {
            $sensors[$sensorMapItem->sensor_id] = WaterSensor::where('id', $sensorMapItem->sensor_id)->first();
        }
        $allUnaddedSensorsAry = [];
        $allSensors = WaterSensor::where('owner', Auth::user()->id)->get(); //->list('description','id');
// Yuck! don't know how to map model to select
        foreach ($allSensors as $sensor) {
            if (!array_key_exists($sensor->id, $sensors) && SensorsController::canSensorControlNewTap($sensor->id)) {
                $allUnaddedSensorsAry[$sensor->id] = $sensor->description;
            }
        }
//            $lastValue = $customServiceInstance->readMessage(CloudMQTT::FEED_WATERSENSOR.'/'.(int)$id, 5);

        return view('taps.show', [
            'statuses' => $this->tapStatuses,
            'tap' => $tap,
            'lastvalue' => 0,
            'sensorMap' => $sensorMap,
            'sensors' => $sensors,
            'allSensors' => $allUnaddedSensorsAry]);
//            return view('taps.add', );
    }

    public static function getTap(int $tapID, string $uid = null): Tap {
// find by UID if presented
        if (!is_null($uid)) {
            $tap = Tap::where(['uid' => $uid, 'owner' => Auth::user()->id])->first();
        } else {
            $tap = Tap::where(['id' => (int) $tapID, 'owner' => Auth::user()->id])->first();
        }
        if (!$tap instanceof Tap) {
            throw new TapNotFoundException();
        }

        return $tap;
    }

    public function add(Request $request) {
        if ($request->isMethod('POST')) {
            $tap = new Tap();
            $tap->owner = Auth::user()->id;
            $tap->description = $request->post('description');
            $tap->uid = $request->post('uid');
            try {
                $dupeCheck = Tap::where('uid', $tap->uid)->first();
                if ($dupeCheck instanceof Tap) {
                    throw new TapAlreadyRegisteredException();
                }
                unset($dupeCheck);

                $tap->save();
                $request->session()->flash('success', 'Tap added successfully');
                return redirect(Route('taps.show', $tap->id), 302);
            } catch (TapAlreadyRegisteredException $e) {
                $request->session()->flash('warning', 'This tap has already been registered, please re-enter the UID carefully');
                return view('taps.add', ['statuses' => $this->tapStatuses]);
            } catch (Illuminate\Database\QueryException $e) {
                $request->session()->flash('warning', 'Could not add tap: Internal error');
                return view('taps.add', ['statuses' => $this->tapStatuses]);
            } catch (\Exception $e) {
                $request->session()->flash('warning', 'Could not add tap: ' . $e->getMessage());
                return view('taps.add', ['statuses' => $this->tapStatuses]);
            }
        } else {
            return view('taps.add', ['statuses' => $this->tapStatuses]);
        }
    }

    public function changestatus(Request $request, $id) {
        try {
            $tap = self::getTap($id);
        } catch (TapNotFoundException $ex) {
            return view('404');
        }
        $status = $request->post('status');
        if (in_array($status, array_keys($this->tapStatuses))) {
            $tap->status = $status;
        } else {
            die(var_dump($status));
        }
        try {
            $tap->save();
            $request->session()->flash('success', 'Status saved');
        } catch (\Exception $e) {
            $request->session()->flash('warning', 'Could not change status: ' . $e->getMessage());
        }

        return redirect(Route('taps.show', (int) $id), 302);
    }

    /**
     * Controller function to connect a sensor to a tap. 
     * @param Request $request
     * @param int $id
     * @return type
     */
    public function connectToSensor(Request $request, int $id) {
        try {
            SensorsController::controlTapWithSensor((int) $request->post('sensor_id'), $id);
            $request->session()->flash('success', 'Connected the tap to the water sensor');
        } catch (\Exception $ex) {
            $request->session()->flash('warning', 'Could not connect the tap to the water sensor: ' . $e->getMessage());
        }
        return redirect(Route('taps.show', (int) $id), 302);
    }

    public function remove(Request $request) {
        return view('taps.remove');
    }

    public function changeTapValveRoute(Request $request, int $id) {
        try {
            $tap = self::getTap($id);
        } catch (TapNotFoundException $ex) {
            $request->session()->flash('warning', 'Tap does not exist');
        }
        $success = $this->turnTap($tap, $request->new_value);
        if ($success) {
            $request->session()->flash('success', 'Tap requested to turn on');
        }
        else
        {
            $request->session()->flash('warning', 'Something went wrong turning the tap on');
            
        }
    }

    public function turnTap(Tap $tap, string $onOrOff = 'off', CloudMQTT $customServiceInstance) {
        // Belt and braces. You have to REALLY mean 'on' here
        if (trim(strToLower($onOrOff)) !== 'on') {
            $onOrOff = 'off';
        }
        $message = $this->makeMessage($tap->uid, ['action'=>'turntap', 'value' => $onOrOff]);
        $customServiceInstance->sendMessage(CloudMQTT::makeFeedName(CloudMQTT::FEED_TAP, $tap->uid), $message, 1);
    }

    /**
     * Changes the tap status
     * @param Request $request
     * @param int $id
     * @param \App\Http\Controllers\CloudMQTT $customServiceInstance
     * @return type
     */
    public function changeTapStatus(Request $request, int $id, CloudMQTT $customServiceInstance) {
        $saveLastValue = false;
        try {
            $tap = self::getTap($id);
        } catch (TapNotFoundException $ex) {
            return view('404');
        }
        $value = (bool) $request->post('tap_status');
        if (0.0 < $value && 100.0 >= $value) {
            $message = $this->makeMessage($tap->uid, ['tap_status' => $value]);
            echo "writing message to " . CloudMQTT::makeFeedName(CloudMQTT::FEED_TAP, $tap->uid);
            $customServiceInstance->sendMessage(CloudMQTT::makeFeedName(CloudMQTT::FEED_TAP, $tap->uid), $message);
            $request->session()->flash('success', 'Status message sent to tap');
        } else {
//            $request->session()->flash('warning', 'Invalid );
        }
        try {
            if ($saveLastValue) {
                $tap->is_on = $value;
                $tap->save();
            }
        } catch (\Exception $e) {
            var_dump($e);
            die();
        }

        return redirect(Route('taps.show', (int) $id), 302);
    }

    public function handleMessage($uid, $messageType, \stdClass $messageObj) {
        $tap = Tap::where(['uid' => $uid])->first();

        if (($tap instanceof Tap)) {
            switch ($messageType) {
                case 'identify':
                    throw new \Exception('Cannot use ' . $messageType . ' in ' . $routeParts[1]);
                    break;
                case 'update':
                    throw new \Exception('Cannot use ' . $messageType . ' in ' . $routeParts[1]);
//
//                $sensor->last_reading = $messageObj->last_reading;
//                $sensor->battery_level = $messageObj->battery_level;
//                $sensor->last_signal_date = date('Y-m-d H:i:s');
//                $sensor->last_signal = 'reading';
//                $sensor->save();
                    break;
            }
        }
    }
}
