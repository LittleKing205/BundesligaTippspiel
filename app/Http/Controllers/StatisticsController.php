<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Tipp;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function show(Request $request) {
        return view('statistics');
    }
}
