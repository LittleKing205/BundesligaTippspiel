<?php

namespace App\View\Components\Statistics;

use App\Models\Bill;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class PaymentTable extends Component
{
    public $league;
    public $bills;
    public $sum = 0;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($league)
    {
        $this->league = $league;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $this->bills = Bill::where("user_id", Auth::id())->where("league", $this->league)->orderBy("day")->get();
        foreach($this->bills as $bill) {
            $this->sum += $bill->to_pay;
        }

        return view('components.statistics.payment-table');
    }
}
