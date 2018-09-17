<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tap;
use App\WaterSensor;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\TapNotFoundException;
use Illuminate\Database\QueryException;
use App\Exceptions\TapAlreadyRegisteredException;


class TapsController extends Controller {

    private $tapStatuses = ['active' => 'Active', 'inactive' => 'Inactive', 'deleted' => 'Deleted'];
    private $onOrOff = ['on' => 'On', 'off' => 'Off'];

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
            $tap = Tap::getTap(Auth::user()->id, $id);
        } catch (TapNotFoundException $ex) {
            return view('404');
        }
        $sensors = $tap->waterSensors;

        $allAddedSensorsAry = [];
        foreach ($sensors as $sensor) {
            $allAddedSensorsAry[$sensor->id] = $sensor->description;
        }

        $allUnaddedSensorsAry = [];

        $allSensors = WaterSensor::where('owner', Auth::user()->id)->get(); //->list('description','id');
// Yuck! don't know how to map model to select
        foreach ($allSensors as $sensor) {
            if (!array_key_exists($sensor->id, $allAddedSensorsAry) && SensorsController::canSensorControlNewTap($sensor)) {
                $allUnaddedSensorsAry[$sensor->id] = $sensor->description;
            }
        }

        return view('taps.show', [
            'statuses' => $this->tapStatuses,
            'onOrOffs' => $this->onOrOff,
            'tap' => $tap,
            'lastvalue' => 0,
            'sensors' => $sensors,
            'allSensors' => $allUnaddedSensorsAry]);
//            return view('taps.add', );
    }


    public function add(Request $request) {
        if ($request->isMethod('POST')) {
            try {
                $dupeCheck = Tap::where('uid', $tap->uid)->first();
                if ($dupeCheck instanceof Tap) {
                    throw new TapAlreadyRegisteredException();
                }
                unset($dupeCheck);

                $tap = new Tap();
                $tap->owner = Auth::user()->id;
                $tap->description = $request->post('description');
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
            return view('taps.add', ['statuses' => $this->tapStatuses]);
        }
    }

    public function changestatus(Request $request, $id) {
        try {
            $tap = Tap::getTap(Auth::user()->id, $id);
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

        return redirect(Route('taps.show', (int)$id), 302);
    }

    public function turnOnOrOff(Request $request, $id) {
        try {
            $tap = Tap::getTap(Auth::user()->id, $id);
        } catch (TapNotFoundException $ex) {
            return view('404');
        }
        $state = $request->post('expected_state');
        if (in_array($state, array_keys($this->onOrOff))) {
            $tap->turnTap($state);
            $request->session()->flash('success', 'State saved');
        } else {
            $request->session()->flash('warning', 'Could not change state to ' . $status . ': ' . $e->getMessage());
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
        try {
            SensorsController::controlTapWithSensor((int)$request->post('sensor_id'), $id);
            $request->session()->flash('success', 'Connected the tap to the water sensor');
        } catch (\Exception $ex) {
            $request->session()->flash('warning', 'Could not connect the tap to the water sensor: ' . $e->getMessage());
        }
        return redirect(Route('taps.show', (int)$id), 302);
    }

    public function remove(Request $request) {
        return view('taps.remove');
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

    public function sendFakeStateReport(Request $request, int $id) {
        try {
            $tap = Tap::getTap(Auth::user()->id, $id);
        } catch (TapNotFoundException $ex) {
            return view('404');
        }
        $value = $request->reported_state;

        $tap->sendFakeStateReport($value);

        $request->session()->flash('success', 'Fake value of ' . $value . ' sent');
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
}
