<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SensorsController extends Controller
{
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

    public function show(Request $request) {
        return view('sensors.show');
    }

    public function add(Request $request) {
        return view('sensors.add');
    }

    public function remove(Request $request) {
        return view('sensors.remove');
    }
    //
}
