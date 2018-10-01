<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function dashboard(Request $request) {
        return view('user.dashboard');
    }

    public function profile(Request $request) {
        if ('POST' == $request->method()) {
            $user = User::find(Auth::User())->first();
            if ($user instanceof User && $user->id == (int)$request->post('id')) {
                $user->firstname = $request->post('firstname');
                $user->lastname = $request->post('lastname');
                $user->email = $request->post('email');
                if ($user->save()) {
                    $request->session()->flash('success', 'Your data have been saved');
                } else {
                    $request->session()->flash('error', 'Something went wrong saving the user');
                }
                return redirect(Route('users.profile'), 302);
            } else {
                $request->session()->flash('error', 'Incorrect User ID. You can only change your own details');
            }
//            $request->session()->flash('warning', 'Could not set fake value of ' . $value . ' to tap ' . $id . ' because the number given was <1 or > 100');


            return redirect(Route('taps.show', (int)$id), 302);
        } else {
            return view('user.profile', ['user' => Auth()->user()]);

        }
    }
}
