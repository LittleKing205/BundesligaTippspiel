<?php

namespace App\View\Components;

use App\Models\Match;
use App\Models\Tipp;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class TippButton extends Component
{
    public $val;
    public $matchId;
    public $matchResult;
    public $userTipp;
    public $locked;

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
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        // Standart farben
        $state = (!$this->locked) ? 'primary' : 'secondary';

        // Tipp
        if (!is_null($this->userTipp) && $this->userTipp == $this->val)
            $state = 'success';

        // Ergebnis
        if (!is_null($this->matchResult) && $this->matchResult == $this->val)
            $state = 'success';

        // Ergebnis != Tipp
        if (!is_null($this->userTipp) && !is_null($this->matchResult) && $this->matchResult != $this->userTipp && $this->userTipp == $this->val)
            $state = 'danger';

        // Ergebnis && Tipp nicht gegebn
        if (!is_null($this->matchResult) && $this->matchResult == $this->val && is_null($this->userTipp))
            $state = 'info';

        return view('components.tipp-button', compact('state'));
    }
}
