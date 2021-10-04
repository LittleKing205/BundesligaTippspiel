<?php

namespace App\View\Components\Statistics;

use App\Models\Bill;
use Illuminate\View\Component;

class PaymentBox extends Component
{
    public $pot_sum = 0;
    public $pot_sum_missing = 0;
    public $most_payments_payed = 0;
    public $most_payments_user = "";

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
            $tmp_payed = $bill->sum("to_pay");
            if ($this->most_payments_payed < $tmp_payed) {
                $this->most_payments_payed = $tmp_payed;
                $this->most_payments_user = $bill[0]->user->name;
            }
        }

        foreach($bills as $bill) {
            if($bill->has_payed)
                $this->pot_sum += $bill->to_pay;
            else
                $this->pot_sum_missing += $bill->to_pay;
        }

        return view('components.statistics.payment-box');
    }
}
