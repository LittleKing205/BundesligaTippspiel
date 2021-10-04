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

        $this->tipp_count = count($tipps);
        $this->game_count = count($games);
        $this->finished_games = count(Game::where("has_finished", true)->get());



        return view('components.statistics.system-box');
    }
}
