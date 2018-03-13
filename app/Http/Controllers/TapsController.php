<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tap;
use Illuminate\Support\Facades\Auth;

class TapsController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request) {
        $taps = Tap::where('owner',Auth::user()->id)->get();
        return view('taps.index', ['taps' => $taps]);
    }

    public function show(Request $request, $id) {
        $tap = Tap::where('id', (int) $id)->where('owner', Auth::user()->id)->first();
        return view('taps.show', ['tap' => $tap]);
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
            return view('taps.add');
        }
    }

    public function remove(Request $request) {
        return view('taps.remove');
    }
}
