<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Http\Request;

class TippDayPaginate extends Component
{
    private $request;
    private $extraPages = 2;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $currentDay = $this->request->day;
        $league = $this->request->league;
        $links = array();

        for ($i = $currentDay - $this->extraPages; $i <=  $currentDay +  $this->extraPages ; $i++) {
            if ($i >= 1 && $i <= 34)
            $links[] = $i;
        }

        return view('components.tipp-day-paginate', compact('currentDay', 'league', 'links'));
    }
}
