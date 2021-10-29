<?php

namespace App\View\Components\Tipps;

use App\Models\Game;
use App\Models\Tipp;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\Component;

class TippButton extends Component
{
    public $val;
    public $matchId;
    public $matchResult;
    public $userTipp;
    public $locked;
    public $colors;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($val, $matchId, $matchResult, $userTipp, $locked)
    {
        $this->val = $val;
        $this->matchId = $matchId;
        $this->matchResult = $matchResult;
        $this->userTipp = $userTipp;
        $this->locked = $locked;
        $this->colors = config("tippspiel.colors");
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if (session('adminTippMode', false) && Gate::allows('isAdmin'))
            $this->locked = false;

        if (!is_null(Auth::user()->button_colors))
            $this->colors = array_merge($this->colors, Auth::user()->button_colors);

        // Standart farben
        $state = (!$this->locked) ? $this->colors["default"] : $this->colors["default_locked"];

        // Tipp
        if (!is_null($this->userTipp) && $this->userTipp == $this->val)
            $state = $this->colors["user_tipp"];

        // Ergebnis
        if (!is_null($this->matchResult) && $this->matchResult == $this->val)
            $state = $this->colors["game_result"];

        // Ergebnis != Tipp
        if (!is_null($this->userTipp) && !is_null($this->matchResult) && $this->matchResult != $this->userTipp && $this->userTipp == $this->val)
            $state = $this->colors["user_wrong_tipp"];

        // Ergebnis && Tipp nicht gegebn
        if (!is_null($this->matchResult) && $this->matchResult == $this->val && is_null($this->userTipp))
            $state = $this->colors["not_tipped"];

        return view('components.tipps.tipp-button', compact('state'));
    }
}
