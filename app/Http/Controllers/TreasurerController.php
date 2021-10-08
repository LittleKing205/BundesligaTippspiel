<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TreasurerController extends Controller
{

    public function show(Request $request) {
        return view('treasurer');
    }
}
