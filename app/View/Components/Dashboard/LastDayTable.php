<?php

namespace App\View\Components\Dashboard;

use App\Http\Clients\OpenLiga;
use App\Models\Game;
use App\Models\User;
use Illuminate\View\Component;
use Illuminate\Support\Collection;

class LastDayTable extends Component
{
    private OpenLiga $openLiga;
    public int $league;
    public int $lastDay;
    public Collection $leagueResult;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($league, OpenLiga $openLiga)
    {
        $this->openLiga = $openLiga;
        $this->league = $league;
        $this->lastDay = $openLiga->getCurrentDay($league) - 1;
        $this->rawLeagueResult = array();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $users = User::all();

        $matches = Game::where("league", $this->league)->where("day", $this->lastDay)->leftJoin("tipps", "games.id", "tipps.game_id")->leftJoin("users", "tipps.user_id", "users.id")->get();
        foreach ($matches as $match) {
            $this->rawLeagueResult[$match->user_id]["name"] = $match->name;
            $this->rawLeagueResult[$match->user_id]["id"] = $match->user_id;
            if (!isset($this->rawLeagueResult[$match->user_id]["right"]))
                $this->rawLeagueResult[$match->user_id]["right"] = 0;
            if (!isset($this->rawLeagueResult[$match->user_id]["wrong"]))
                $this->rawLeagueResult[$match->user_id]["wrong"] = 0;
            if (!isset($this->rawLeagueResult[$match->user_id]["to_pay"]))
                $this->rawLeagueResult[$match->user_id]["to_pay"] = 0;

            if ($match->tipp == $match->result) {
                $this->rawLeagueResult[$match->user_id]["right"] += 1;
            } else {
                $this->rawLeagueResult[$match->user_id]["wrong"] += 1;
                $this->rawLeagueResult[$match->user_id]["to_pay"] += 0.5;
            }
        }

        foreach ($this->rawLeagueResult as $userResult) {
            $tippCount = $userResult["right"] + $userResult["wrong"];
            $missingTipps = 9 - $tippCount;
            $this->rawLeagueResult[$userResult["id"]]["to_pay"] += $missingTipps;
            $this->rawLeagueResult[$userResult["id"]]["wrong"] += $missingTipps;
        }

        $this->leagueResult = collect($this->rawLeagueResult)->sortBy([
            ["right", "desc"],
            ["to_pay", "asc"]
        ]);

        if ($this->lastDay >= 1)
            return view('components.dashboard.last-day-table');
        else
            return "";
    }
}
