<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RulesController extends Controller
{

    public function show(Request $request) {
        $colors = config("tippspiel.colors");
        if (!is_null(Auth::user()->button_colors))
            $colors = array_merge($colors, Auth::user()->button_colors);

        $match = Game::inRandomOrder()->first();
        return view('rules', compact('match', 'colors'));
    }
}
