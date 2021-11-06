<?php

namespace App\View\Components\Statistics;

use App\Models\Bill;
use App\Models\Tipp;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class PlayerBox extends Component
{
    public $tipps_right = 0;
    public $tipps_wrong = 0;
    public $payed = 0;
    public $not_payed = 0;

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
        $tipps = Tipp::where("user_id", Auth::id())->with('game')->get();
        $bills = Bill::where("user_id", Auth::id())->where("tipp_group_id", Auth::user()->current_group_id)->get();

        foreach($tipps as $tipp) {
            if($tipp->game->has_finished) {
                if ($tipp->tipp == $tipp->game->result)
                    $this->tipps_right += 1;
                else
                    $this->tipps_wrong += 1;
            }
        }

        foreach($bills as $bill) {
            if ($bill->has_payed)
                $this->payed += $bill->to_pay;
            else
                $this->not_payed += $bill->to_pay;
        }

        return view('components.statistics.player-box');
    }
}
