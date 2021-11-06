<?php

namespace App\View\Components\Dashboard;

use App\Models\Bill;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class StatisticsBox extends Component
{
    public int $open_bills = 0;
    public string $status_color = "success";
    public $pot = 0;
    public $missing_pot = 0;

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
        $user = Auth::user();
        $bills = $user->currentGroup->bills;

        foreach($bills as $bill) {
            if ($bill->user->id == $user->id && !$bill->has_payed)
                $this->open_bills += 1;

            if ($bill->has_payed)
                $this->pot += $bill->to_pay;
            else
                $this->missing_pot += $bill->to_pay;
        }

        if ($this->open_bills > 0)
            $this->status_color = "danger";;
        return view('components.dashboard.statistics-box');
    }
}
