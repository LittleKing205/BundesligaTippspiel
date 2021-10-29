<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DevController extends Controller {

    public function switchTippMode(Request $request) {
        $newMode = !$request->session()->get('devTippMode', false);
        $request->session()->put('devTippMode', $newMode);
        return back();
    }
}
