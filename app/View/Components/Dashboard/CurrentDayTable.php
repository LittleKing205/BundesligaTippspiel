<?php

namespace App\View\Components\Dashboard;

use App\Http\Clients\OpenLiga;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class CurrentDayTable extends Component
{
    public int $league;
    public int $tippCount;
    public int $gameCount;
    public int $tippsRight;
    public int $gamesPlayed;
    public string $statusColor;
    public OpenLiga $openLiga;
    public int $currentDay;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($league, OpenLiga $openLiga)
    {
        $this->league = $league;
        $this->openLiga = $openLiga;
        $this->currentDay = $openLiga->getCurrentDay($league);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $data = DB::select("SELECT
                (SELECT count(id) FROM games
                    WHERE
                        league = :league1 AND
                        day = :day1) as match_count,
                (SELECT count(games.id) FROM games
                    inner JOIN tipps
                        ON games.id = tipps.game_id AND tipps.user_id = :user2
                    WHERE
                        league = :league2 AND
                        day = :day2) as tipp_count,
                (SELECT count(games.id) FROM games
                    INNER JOIN tipps
                        ON games.id = tipps.game_id AND tipps.user_id = :user3
                    WHERE
                        league = :league3 AND
                        day = :day3 AND
                        games.has_finished = 1 AND
                        games.result = tipps.tipp) as tipp_right,
                (SELECT count(games.id) FROM games
                    WHERE
                        league = :league4 AND
                        day = :day4 AND
                        has_finished = 1) as games_played
            from dual", [
                "league1" => $this->league,
                "day1" => $this->currentDay,
                "league2" => $this->league,
                "day2" => $this->currentDay,
                "user2" => Auth::id(),
                "league3" => $this->league,
                "day3" => $this->currentDay,
                "user3" => Auth::id(),
                "league4" => $this->league,
                "day4" => $this->currentDay
            ]);

        $this->gameCount = $data[0]->match_count;
        $this->tippCount = $data[0]->tipp_count;
        $this->tippsRight = $data[0]->tipp_right;
        $this->gamesPlayed = $data[0]->games_played;

        if ($this->gameCount <= $this->tippCount)
            $this->statusColor = "success";
        else
            $this->statusColor = "primary";

        return view('components.dashboard.current-day-table');
    }
}
