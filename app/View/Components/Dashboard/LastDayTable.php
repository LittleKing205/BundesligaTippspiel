<?php

namespace App\View\Components\Dashboard;

use App\Http\Clients\OpenLiga;
use App\Models\Bill;
use App\Models\Game;
use App\Models\User;
use Illuminate\View\Component;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

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
        $this->rawLeagueResult = Bill::where("league", $this->league)->where("day", $this->lastDay)->where("tipp_group_id", Auth::user()->current_group_id)->with('user')->get();

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
