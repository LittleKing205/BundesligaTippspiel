<?php

namespace App\View\Components\Statistics;

use App\Models\Game;
use App\Models\Tipp;
use Illuminate\View\Component;

class SystemBox extends Component
{
    public $tipp_count = 0;
    public $game_count = 0;
    public $finished_games = 0;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $tipps = Tipp::all();
        $games = Game::all();

        $this->tipp_count = $tipps->count();
        $this->game_count = $games->count();
        $this->finished_games = Game::where("has_finished", true)->get()->count();

        return view('components.statistics.system-box');
    }
}
