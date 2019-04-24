<?php

namespace App\Http\Controllers;

use App\Exceptions\GardenNotFoundException;
use App\Garden;
//use App\Tap;
//use App\WaterSensor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GardensController extends Controller {
    public function index(Request $request) {
        $sensors = Garden::where('owner', Auth::user()->id)->get();
        return view('gardens.index', ['gardens' => $sensors, 'navHighlight' => 'gardens']);
    }

    public function add(Request $request) {
        if ($request->isMethod('POST')) {
            $garden = new Garden();
            $garden->owner = Auth::user()->id;
            $garden->name = $request->post('name');
            $garden->longitude = $request->post('longitude');
            $garden->latitude = $request->post('latitude');
            $garden->save();
            return redirect(Route('gardens.show', $garden->id), 302);
        } else {
            return view('gardens.add', ['navHighlight' => 'gardens']);
        }
    }

    public function show(Request $request, int $id) {
        try {
            $garden = Garden::getGarden(Auth::user()->id, $id);
        } catch (GardenNotFoundException $ex) {
            return view('404');
        }
//        $taps = $garden->taps;
//        $addedTapsArray = [];
//        foreach ($taps as $tap) {
//            $addedTapsArray[$tap->id] = $tap->name;
//        }
//        $allUnaddedTapsAry = [];
//        $allTaps = Tap::where('owner', Auth::user()->id)->get(); //->list('description','id');
//// Yuck! don't know how to map model to select
//        foreach ($allTaps as $tap) {
//            if (!array_key_exists($tap->id, $addedTapsArray)) {
//                $allUnaddedTapsAry[$tap->id] = $tap->name;
//            }
//        }
        $weather = $garden->getWeather();
//var_dump($weather);die();
        return view('gardens.show', [
            'garden' => $garden,
            'lastvalue' => 0,
            'weather' => $weather,
//            'taps' => $taps,
//            'allTaps' => $allUnaddedTapsAry,
//            'fakeValues' => [0 => 0, 1 => 1, 2 => 2, 5 => 5, 7 => 7, 9 => 9, 10 => 10, 20 => 20, 30 => 30, 40 => 40, 55 => 55, 66 => 66, 77 => 77, 88 => 88, 99 => 99, 100 => 100, 101 => 101],
            'navHighlight' => 'gardens']);
    }    //
}
