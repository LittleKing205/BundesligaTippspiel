<?php

namespace App\View\Components\Statistics;

use App\Models\Bill;
use Illuminate\View\Component;

class AllPlayerBox extends Component
{
    public $pot_sum = 0;
    public $pot_sum_missing = 0;
    public $most_right_sum = 0;
    public $most_right_name = "";
    public $most_wrong_sum = 0;
    public $most_wrong_name = "";
    public $not_tipped = 0;

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
        $bills = Bill::all();

        $bill_group = $bills->groupBy("user_id");

        foreach($bill_group as $bill) {
            $tmp_right = $bill->sum("right");
            if ($this->most_right_sum < $tmp_right) {
                $this->most_right_sum = $tmp_right;
                $this->most_right_name = $bill[0]->user->name;
            }

            $tmp_wrong = $bill->sum("wrong");
            if ($this->most_wrong_sum < $tmp_wrong) {
                $this->most_wrong_sum = $tmp_wrong;
                $this->most_wrong_name = $bill[0]->user->name;
            }

            $this->not_tipped += $bill->sum("not_tipped");
        }

        foreach($bills as $bill) {
            if($bill->has_payed)
                $this->pot_sum += $bill->to_pay;
            else
                $this->pot_sum_missing += $bill->to_pay;
        }

        return view('components.statistics.all-player-box');
    }
}
