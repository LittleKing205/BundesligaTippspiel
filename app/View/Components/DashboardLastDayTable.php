<?php

namespace App\View\Components;

use App\Http\Clients\OpenLiga;
use App\Models\Game;
use App\Models\User;
use Illuminate\View\Component;

class DashboardLastDayTable extends Component
{
    private OpenLiga $openLiga;
    public int $league;
    public int $lastDay;
    public array $leagueResult;

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
        $this->leagueResult = array();
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
            $this->leagueResult[$match->user_id]["name"] = $match->name;
            $this->leagueResult[$match->user_id]["id"] = $match->user_id;
            if (!isset($this->leagueResult[$match->user_id]["right"]))
                $this->leagueResult[$match->user_id]["right"] = 0;
            if (!isset($this->leagueResult[$match->user_id]["wrong"]))
                $this->leagueResult[$match->user_id]["wrong"] = 0;
            if (!isset($this->leagueResult[$match->user_id]["to_pay"]))
                $this->leagueResult[$match->user_id]["to_pay"] = 0;

            if ($match->tipp == $match->result) {
                $this->leagueResult[$match->user_id]["right"] += 1;
            } else {
                $this->leagueResult[$match->user_id]["wrong"] += 1;
                $this->leagueResult[$match->user_id]["to_pay"] += 0.5;
            }
        }

        foreach ($this->leagueResult as $userResult) {
            $tippCount = $userResult["right"] + $userResult["wrong"];
            $missingTipps = 9 - $tippCount;
        }

        if ($this->lastDay >= 1)
            return view('components.dashboard-last-day-table');
        else
            return "";
    }
}
