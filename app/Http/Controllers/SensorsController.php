<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WaterSensor;
use Illuminate\Support\Facades\Auth;

class SensorsController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request) {
        return view('sensors.index');
    }

    public function show(Request $request,$id) {
        $sensor = WaterSensor::where('id', (int) $id)->where('owner',Auth::user()->id)->first();
        return view('sensors.show', ['sensor'=>$sensor]);
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
}
