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
        $taps = Tap::where('owner', Auth::user()->id)->get();
        return view('taps.index', ['taps' => $taps]);
    }

    public function show(Request $request, $id) {
        $tap = Tap::where(['id' => (int) $id, 'owner' => Auth::user()->id])->first();
        if ($tap instanceof Tap) {
//            return view('taps.add', );
            return view('taps.show', ['statuses'=>['active'=>'Active','inactive'=>'Inactive','deleted'=>'Deleted'], 'tap' => $tap]);
        } else {
            return view('404');
        }
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
            return view('taps.add', ['statuses'=>['active'=>'Active','inactive'=>'Inactive','deleted'=>'Deleted']]);
        }
    }

    public function changestatus(Request $request, $id) {
        $tap = Tap::where(['id' => (int) $id, 'owner' => Auth::user()->id])->first();
        if ($tap instanceof Tap) {
            $status =  $request->post('status');
            if (in_array($status, ['active','inactive','deleted']))
            {
                $tap->status = $status;
            }
            else
            {
                die(var_dump($status));
            }
            try {
                $tap->save();
            } catch (\Exception $e) {
                var_dump($e);
                die();
            }
        }
        return redirect(Route('taps.show', (int) $id), 302);
    }

    public function remove(Request $request) {
        return view('taps.remove');
    }
}
