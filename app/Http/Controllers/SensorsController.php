<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WaterSensor;
use App\Tap;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\TapNotFoundException;
use App\Exceptions\SensorNotFoundException;
use App\Exceptions\SensorIncompatibleWithTapException;
use App\Exceptions\WaterSensorAlreadyRegisteredException;

class SensorsController extends Controller {

    private $sensorStatuses = ['active' => 'Active', 'inactive' => 'Inactive', 'deleted' => 'Deleted'];

    /**
     * Sends a false value to mqtt, for testing
     * @param Request $request
     * @param int $id
     * @param \App\Http\Controllers\CloudMQTT $customServiceInstance
     * @return type
     */
    public function sendFakeValue(Request $request, int $id) {
        $sensor = Auth::user()->water_sensors()->where('id', $id)->first();
        if (is_null($sensor)){
            return view('404');
        }
        $value = (float)$request->post('last_reading');

        if (0.0 < $value && 100.0 >= $value) {
            $sensor->sendFakeValue($value);

            $request->session()->flash('success', 'Fake value of ' . $value . ' sent');
        } else {
            $request->session()->flash('warning', 'Could not set fake value of ' . $value . ' to sensor ' . $id . ' because the number given was <1 or > 100');
        }

        return redirect(Route('sensors.show', (int)$id), 302);
    }

    public function index(Request $request) {
        $sensors = WaterSensor::where('owner', Auth::user()->id)->get();
        return view('sensors.index', ['sensors' => $sensors, 'navHighlight' => 'sensors']);
    }

    public function show(Request $request, int $id) {
        $sensor = Auth::user()->water_sensors()->where('id', $id)->first();
        if (is_null($sensor)){
            return view('404');
        }
        $taps = $sensor->taps;
        $addedTapsArray = [];
        foreach ($taps as $tap) {
            $addedTapsArray[$tap->id] = $tap->name;
        }
        $allUnaddedTapsAry = [];
        $allTaps = Tap::where('owner', Auth::user()->id)->get(); //->list('description','id');
// Yuck! don't know how to map model to select
        foreach ($allTaps as $tap) {
            if (!array_key_exists($tap->id, $addedTapsArray)) {
                $allUnaddedTapsAry[$tap->id] = $tap->name;
            }
        }

        return view('sensors.show', [
            'statuses' => $this->sensorStatuses,
            'sensor' => $sensor,
            'lastvalue' => 0,
            'taps' => $taps,
            'allTaps' => $allUnaddedTapsAry,
            'fakeValues' => [0 => 0, 1 => 1, 2 => 2, 5 => 5, 7 => 7, 9 => 9, 10 => 10, 20 => 20, 30 => 30, 40 => 40, 55 => 55, 66 => 66, 77 => 77, 88 => 88, 99 => 99, 100 => 100, 101 => 101],
            'navHighlight' => 'sensors']);
    }

    /**
     * Controller function to connect a sensor to a tap.
     * @param Request $request
     * @param int $id
     * @return type
     */
    public function connectToTap(Request $request, int $id) {
        $sensor = Auth::user()->water_sensors()->where('id', $id)->first();
        if (is_null($sensor)){
            return view('404');
        }
        try {
            $tap = Auth::user()->taps->where('id',  (int)$request->post('tap_id'))->first();
            if ($sensor->controlTap($tap)) {
                $request->session()->flash('success', 'Tap connected!');
            } else {
                $request->session()->flash('warning', 'Could not connect the tap to the water sensor');
            }
        } catch (\Exception $ex) {
            $request->session()->flash('warning', 'Tap could not be connected: ' . $ex->getMessage());
        }
        return redirect(Route('sensors.show', (int)$id), 302);
    }

    /**
     * Controller function to connect a sensor to a tap.
     * @param Request $request
     * @param int $id
     * @return type
     */
    public function detachFromTap(Request $request, int $id) {
        $sensor = Auth::user()->water_sensors()->where('id', $id)->first();
        if (is_null($sensor)){
            return view('404');
        }
        try {
            $sensor->taps()->detach($request->post('tap_id'));
        } catch (\Exception $ex) {
            $request->session()->flash('warning', 'Tap could not be detached: ' . $ex->getMessage());
        }
        return redirect(Route('sensors.show', (int)$id), 302);
    }

    public function changestatus(Request $request, $id) {
        $sensor = Auth::user()->water_sensors()->where('id', $id)->first();
        if (is_null($sensor)){
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

        return redirect(Route('sensors.show', (int)$id), 302);
    }

    public function add(Request $request) {
        if ($request->isMethod('POST')) {
            $sensor = new WaterSensor();
            $sensor->owner = Auth::user()->id;
            $sensor->name = $request->post('name');
            $sensor->description = $request->post('description');
            $sensor->uid = $request->post('uid');
            try {
                $dupeCheck = WaterSensor::where('uid', $sensor->uid)->first();
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
            return view('sensors.add', ['navHighlight' => 'sensors']);
        }
    }

    public function remove(Request $request) {
        return view('sensors.remove', ['navHighlight' => 'sensors']);
    }

    public function apiUpdate(Request $request, int $id) {
        return view('404');
    }
}
