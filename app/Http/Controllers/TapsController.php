<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tap;
use App\WaterSensor;
use App\TapControlledBySensor;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\TapNotFoundException;
use App\Http\Controllers\SensorsController;

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
                $tap->save();
            } catch (\Exception $e) {
                var_dump($e);
                die();
            }
            return redirect(Route('taps.show', $tap->id), 302);
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
        } catch (\Exception $e) {
            var_dump($e);
            die();
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
        try
        {
            SensorsController::controlTapWithSensor( (int) $request->post('sensor_id'), $id);
        } catch (\Exception $ex) {
var_dump($ex);
            die('exception');
        }
        return redirect(Route('taps.show', (int) $id), 302);
    }

    public function remove(Request $request) {
        return view('taps.remove');
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
            echo "writing message to " . CloudMQTT::makeFeedName(CloudMQTT::FEED_TAP);
            $customServiceInstance->sendMessage(CloudMQTT::makeFeedName(CloudMQTT::FEED_TAP), $message);
        } else {
            die(var_dump($value));
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
    
    public function handleMessage($uid, $messageType, stdClass $messageObj) {
        try {
            $tap = self::getTap(0, $uid);
        } catch (TapNotFoundException $ex) {
            throw new \App\Exceptions\TapNotFoundException();
        }
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
