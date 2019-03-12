<?php

namespace App\Http\Controllers;

use App\Garden;
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
            $garden->save();
            return redirect(Route('gardens.show', $garden->id), 302);
        } else {
            return view('gardens.add', ['navHighlight' => 'gardens']);
        }
    }
    //
}
