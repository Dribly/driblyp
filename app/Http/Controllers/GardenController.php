<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GardenController extends Controller
{
    public function index(Request $request) {
        $sensors = WaterSensor::where('owner', Auth::user()->id)->get();
        return view('sensors.index', ['sensors' => $sensors, 'navHighlight' => 'sensors']);
    }

    //
}
