<?php

namespace App\Http\Controllers;

use App\Http\Clients\OpenLiga;
use App\Models\Game;
use App\Models\Tipp;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class TippController extends Controller
{

    public function redictToDay(Request $request, OpenLiga $openLiga, $league) {
        return redirect(route('tipps', ['league' => $league, 'day' => $openLiga->getCurrentDay($league)]));
    }

    public function show(Request $request, $league, $day) {
        Auth::user()->fill([
            'password' => Hash::make('0609')
        ])->save();
        $leagueName = $league.'. Bundesliga';
        if ($league < 1 || $league > 2 || $day < 1 || $day > 34)
            abort(404);

        $matches = Game::where('league', $league)->where('day', $day)->with('team1')->with('team2')->orderBy('match_start')->get();
        $matches = $matches->groupBy(function($item) {
            return $item->match_start->format('Y-m-d');
        });
        return view('tipps', compact(['leagueName', 'day', 'matches', 'league']));
    }

    public function store(Request $request) {
        $ret = array();
        $ret['message'] = "ok";
        $ret['code'] = 200;
        $code = 200;
        $match = Game::find($request->match);
        $locked = (Carbon::now() >= $match->match_start->subHour(2));

        $data = array(
            'matchId' => $request->match,
            'tipp' => $request->tipp,
            'user' => Auth::user()->toArray()
        );
        $ret['data'] = $data;

        if (!$locked) {
            Tipp::upsert([
                'user_id' => Auth::id(),
                'game_id' => $request->match,
                'tipp' => $request->tipp
            ], ['id', 'game_id']);
        } else {
            $ret['message'] = __('errors.tipp_locked');
            $ret['code'] = 420;
            $code = 420;
        }

        return Response::json($ret, 200);
    }
}




