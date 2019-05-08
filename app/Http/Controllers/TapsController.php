<?php

namespace App\Http\Controllers;

use App\TimeSlotManager;
use Illuminate\Http\Request;
use App\Garden;
use App\Tap;
use App\WaterSensor;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\TapNotFoundException;
use Illuminate\Database\QueryException;
use App\Exceptions\TapAlreadyRegisteredException;

//use App\TimeSlotManager;

class TapsController extends Controller {

    private $tapStatuses = ['active' => 'Active', 'inactive' => 'Inactive', 'deleted' => 'Deleted'];
    private $onOrOff = [Tap::ON => 'On', Tap::OFF => 'Off'];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
//        $this->middleware('auth');
    }

    public function index(Request $request) {
        $taps = Auth::user()->taps()->get();
        return view('taps.index', ['taps' => $taps, 'navHighlight' => 'taps']);
    }

    public function apiIndex(Request $request) {
        $taps = Auth::user()->taps()->get();
        iF (is_null($taps)) {
            return $taps->toJson();
        } else {
            return '[]';
        }

    }

    public function apiGetTimeSlots(int $tapID) {
        return response()->json(['slots' => $this->getTimeSlots($tapID)], 200, [], JSON_OBJECT_AS_ARRAY);
    }

    public function getTimeSlots(int $tapID): TimeSlotManager {
        $tap = Auth::user()->taps()->where('id', $tapID)->first();
        return $tap->getTimeSlotManager();
    }

    public function jsonGetTimeSlots(int $tapID) {
        $data = ['slots' => $this->getTimeSlots($tapID)->dumpDays()];
        return response()->json($data);
    }

    public function show(Request $request, int $id) {
        $tap = Auth::user()->taps()->where('id', $id)->first();
        if (is_null($tap)) {
            return view('404');
        }
        $sensors = $tap->waterSensors;

        $allAddedSensorsAry = [];
        foreach ($sensors as $sensor) {
            $allAddedSensorsAry[$sensor->id] = $sensor->name;
        }

        $allUnAddedSensorsAry = [];

        $allSensors = Auth::user()->water_sensors;
        // Yuck! don't know how to map model to select
        foreach ($allSensors as $sensor) {
            if (!array_key_exists($sensor->id, $allAddedSensorsAry) && $sensor->canControlTap($tap)) {
                $allUnAddedSensorsAry[$sensor->id] = $sensor->name;
            }
        }

        return view('taps.show', [
            'statuses' => $this->tapStatuses,
            'onOrOffs' => $this->onOrOff,
            'timeLengths' => [0 => 'How Long...', 1 => '1 minute', 10 => '10 minutes', 20 => '20 minutes', 30 => 'half an hour', 40 => '40 minutes', 60 => '1 hour', 90 => '1 and a half hours', 120 => '2 hours'],
            'tap' => $tap,
            'garden' => $tap->garden()->first(),
            'lastvalue' => 0,
            'sensors' => $sensors,
            'allSensors' => $allUnAddedSensorsAry,
            'timeSlotsManager' => $tap->getTimeSlotManager(),
            'navHighlight' => 'taps'
        ]);
//            return view('taps.add', );
    }

    public function storeTimeSlots(Request $request, int $id) {
        $tap = Auth::user()->taps()->where('id', $id)->first();
        if (is_null($tap)) {
            return view('404');
        }
        // We don't load from db, as we assume this is a POST request to replace.
        $timeSlotManager = $tap->getTimeSlotManager(false);
        foreach ($request->post('slots') as $dayId => $blocks) {
            echo($dayId);
            echo " = DAY\n";
            foreach ($blocks as $hour => $isBlocked) {
                echo($hour);
                echo " = HOUR\n";
                if ($isBlocked) {
                    echo "IS BLOCKED \n";
                    $timeSlotManager->addBlock($dayId, $hour);
                }
            }
        }
        $timeSlotManager->save();
        return response()->json(['slots' => $this->getTimeSlots($tap->id)], 200, [], JSON_OBJECT_AS_ARRAY);

        // Will override all previosu.
        $timeSlotManager->save();
        return redirect(Route('taps.show', $tap->id), 302);
    }

    public function add(Request $request) {
        if ($request->isMethod('POST')) {
            try {
                $dupeCheck = Tap::where('uid', $request->post('uid'))->first();
                if ($dupeCheck instanceof Tap) {
                    throw new TapAlreadyRegisteredException();
                }
                unset($dupeCheck);

                $tap = new Tap();
                $tap->owner = Auth::user()->id;
                $tap->name = $request->post('name');
                $tap->description = $request->post('description');
                $tap->garden_id = $request->post('garden');
                $tap->uid = $request->post('uid');
                $tap->save();

                $request->session()->flash('success', 'Tap added successfully');
                return redirect(Route('taps.show', $tap->id), 302);
            } catch (TapAlreadyRegisteredException $e) {
                $request->session()->flash('warning', 'This tap has already been registered, please re-enter the UID carefully');
                return view('taps.add', ['statuses' => $this->tapStatuses]);
            } catch (QueryException $e) {
                $request->session()->flash('warning', 'Could not add tap: Internal error');
                return view('taps.add', ['statuses' => $this->tapStatuses]);
            } catch (\Exception $e) {
                $request->session()->flash('warning', 'Could not add tap: ' . $e->getMessage());
                return view('taps.add', ['statuses' => $this->tapStatuses]);
            }
        } else {
            $allGardens = Auth::user()->gardens;
            $gardens = [];
            foreach ($allGardens as $garden) {
                $gardens[$garden->id] = $garden->name;
            }
            return view('taps.add',
                [
                    'statuses' => $this->tapStatuses,
                    'gardens' => $gardens,
                    'navHighlight' => 'taps'
                ]);
        }
    }

    public function changestatus(Request $request, $id) {
        $tap = Auth::user()->taps()->where('id', $id)->first();
        if (is_null($tap)) {
            $request->session()->flash('warning', 'Tap does not exist');
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

        return redirect(Route('taps.show', (int)$id), 302);
    }

    public function manualTurnOnOrOff(Request $request, $id) {
        $tap = Auth::user()->taps()->where('id', $id)->first();
        if (is_null($tap)) {
            $request->session()->flash('warning', 'Tap does not exist');
            return view('404');
        }
        $state = $request->post('expected_state');
        if (in_array($state, array_keys($this->onOrOff))) {
            $tap->turnTap($state, (int)$request->post('off_for_minutes'));
            $request->session()->flash('success', 'State saved');
        } else {
            $request->session()->flash('warning', 'Could not change state to ' . $state . ': ');
        }

        return redirect(Route('taps.show', (int)$id), 302);
    }

    /**
     * Controller function to connect a sensor to a tap.
     * @param Request $request
     * @param int $id
     * @return type
     */
    public function connectToSensor(Request $request, int $id) {
        $tap = Auth::user()->taps()->where('id', $id)->first();
        if (is_null($tap)) {
            $request->session()->flash('warning', 'Tap does not exist');
            return view('404');
        }
        try {
            $sensor = Auth::User()->water_sensors()->where('id', (int)$request->post('sensor_id'));
            if ($sensor->controlTap($tap)) {
                $request->session()->flash('success', 'Connected the tap to the water sensor');
            } else {
                $request->session()->flash('warning', 'Could not connect the tap to the water sensor');
            }

        } catch (\Exception $ex) {
            $request->session()->flash('warning', 'Could not connect the tap to the water sensor: ' . $ex->getMessage());
        }
        return redirect(Route('taps.show', (int)$id), 302);
    }

    public function remove(Request $request) {
        return view('taps.remove', ['navHighlight' => 'taps']);
    }

    public function changeTapValveRoute(Request $request, int $id) {
        try {
            $tap = Tap::getTap(Auth::user()->id, $id);
        } catch (TapNotFoundException $ex) {
            $request->session()->flash('warning', 'Tap does not exist');
        }
        $success = $tap->turnTap($request->new_value);
        if ($success) {
            $request->session()->flash('success', 'Tap requested to turn on');
        } else {
            $request->session()->flash('warning', 'Something went wrong turning the tap on');

        }
    }

    public function sendFakeResponse(Request $request, int $id) {
        try {
            $tap = Tap::getTap(Auth::user()->id, $id);
        } catch (TapNotFoundException $ex) {
            return view('404');
        }
        $value = $request->reported_state;

        $tap->sendFakeResponse($value);

        $request->session()->flash('success', 'Fake value of \'' . $value . '\' sent');
//            $request->session()->flash('warning', 'Could not set fake value of ' . $value . ' to tap ' . $id . ' because the number given was <1 or > 100');


        return redirect(Route('taps.show', (int)$id), 302);
    }

    /**
     * Simply consumes an MQTT report and responds to it
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function fakeConsumeMQTT(Request $request, int $id) {
        try {
            $tap = Tap::getTap(Auth::user()->id, $id);
        } catch (TapNotFoundException $ex) {
            return view('404');
        }
        $value = $request->reported_state;

        $tap->sendFakeStateReport($value);

        $request->session()->flash('success', 'Fake value of ' . $value . ' sent');

        return redirect(Route('taps.show', (int)$id), 302);
    }

    /**
     * Controller function to connect a sensor to a tap.
     * @param Request $request
     * @param int $id
     * @return type
     */
    public function detachFromSensor(Request $request, int $id) {
        try {
            $tap = Tap::getTap(Auth::user()->id, $id);
        } catch (SensorNotFoundException $ex) {
            return view('404');
        }
        try {
            $tap->sensors()->detach($request->post('sensor_id'));
        } catch (\Exception $ex) {
            $request->session()->flash('warning', 'Sensor could not be detached: ' . $ex->getMessage());
        }
        return redirect(Route('taps.show', (int)$id), 302);
    }


}
