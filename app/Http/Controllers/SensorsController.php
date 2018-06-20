<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WaterSensor;
use Illuminate\Support\Facades\Auth;

class SensorsController extends Controller {

    public function index(Request $request) {
        $sensors = WaterSensor::where('owner', Auth::user()->id)->get();
            return view('sensors.index', ['sensors' => $sensors]);
    }

    public function show(Request $request, $id) {
        $sensor = WaterSensor::where(['id'=> (int) $id, 'owner'=>Auth::user()->id])->first();
        if ($sensor instanceof WaterSensor) {
        return view('sensors.show', ['sensor' => $sensor]);
        } else {
            return view('404');
        }
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
    
    public function ApiUpdate(Request $request, $id)
    {
        return view('404');
//        if ()
    }
}
