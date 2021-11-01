<?php

namespace App\Http\Controllers;

use App\Http\Clients\OpenLiga;
use App\Models\Game;
use App\Models\Tipp;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;
use PhpParser\Node\Expr\Match_;

class TippController extends Controller
{

    public function show(Request $request, OpenLiga $openLiga, $league, $day = null) {
        $leagueName = $league.'. Bundesliga';
        if (is_null($day))
            $day = $openLiga->getCurrentDay($league);
        if ($league < 1 || $league > 2 || $day < 1 || $day > 34)
            abort(404);

        $colors = config("tippspiel.colors");
        if (!is_null(Auth::user()->button_colors))
            $colors = array_merge($colors, Auth::user()->button_colors);
        $matches = Game::where('league', $league)->where('day', $day)->with('team1')->with('team2')->orderBy('match_start')->get();
        $matches = $matches->groupBy(function($item) {
            return $item->match_start->format('Y-m-d');
        });
        return view('tipps', compact(['leagueName', 'day', 'matches', 'league', 'colors']));
    }

    public function store(Request $request, OpenLiga $openLiga) {
        $ret = array();
        $ret['message'] = "ok";
        $ret['code'] = 200;
        $code = 200;
        $match = Game::find($request->match);
        $locked = (Carbon::now() >= $match->match_start->subHour(2));
        if (session('devTippMode', false) && Gate::allows('dev.edit_closed_games'))
            $locked = false;

        $data = array(
            'matchId' => $request->match,
            'tipp' => $request->tipp
        );
        $ret['data'] = $data;

        if (!$locked) {
            Tipp::upsert([
                'user_id' => Auth::id(),
                'game_id' => $request->match,
                'tipp' => $request->tipp
            ], ['id', 'game_id']);
            if (session('devTippMode', false) && Gate::allows('dev.edit_closed_games')) {
                $game = Game::find($request->match);
                if ($openLiga->getCurrentDay($game->league) < $game->day) {
                    Artisan::call("make:bill", [
                        "user" => Auth::user()->id,
                        "league" => $game->league,
                        "day" => $game->day
                    ]);
                }
            }
        } else {
            $ret['message'] = __('errors.tipp_locked');
            $ret['code'] = 420;
            $code = 420;
        }

        return Response::json($ret, 200);
    }
}




