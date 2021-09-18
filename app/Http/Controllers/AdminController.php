<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

class AdminController extends Controller {

    public function switchTippMode(Request $request) {
        $newMode = !$request->session()->get('adminTippMode', false);
        $request->session()->put('adminTippMode', $newMode);
        return back();
    }
}
