<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllersController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request) {
        return view('controllers.index');
    }

    public function show(Request $request) {
        return view('controllers.show');
    }

    public function add(Request $request) {
        return view('controllers.add');
    }

    public function remove(Request $request) {
        return view('controllers.remove');
    }
}
