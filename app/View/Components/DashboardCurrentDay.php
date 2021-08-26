<?php

namespace App\View\Components;

use App\Http\Clients\OpenLiga;
use App\Models\Match;
use Illuminate\View\Component;

class DashboardCurrentDay extends Component
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
        $this->currentDay = $this->openLiga->getCurrentDay($this->league);


        return view('components.dashboard-current-day');
    }
}
