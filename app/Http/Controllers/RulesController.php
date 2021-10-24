<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class RulesController extends Controller
{

    public function show() {
        $match = Game::inRandomOrder()->first();
        return view('rules', compact('match'));
    }
}
