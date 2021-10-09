<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller {

    public function switchTippMode(Request $request) {
        if (Gate::allows('isAdmin')) {
            $newMode = !$request->session()->get('adminTippMode', false);
            $request->session()->put('adminTippMode', $newMode);
        }
        return back();
    }
}