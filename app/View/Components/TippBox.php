<?php

namespace App\View\Components;

use App\Models\Game;
use App\Models\Tipp;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class TippBox extends Component
{
    public $match_id;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($match)
    {
        $this->match_id = $match;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $match = Game::find($this->match_id);
        $locked = (Carbon::now() >= $match->match_start->subHour(2));
        $tipp = Tipp::where('user_id', Auth::id())->where('match_id', $match->id)->get()->first();
        $user_tipp = (!is_null($tipp)) ? $tipp['tipp'] : null;
        $match_result = $match->result;

        return view('components.tipp-box', compact('match', 'user_tipp', 'match_result', 'locked'));
    }
}
