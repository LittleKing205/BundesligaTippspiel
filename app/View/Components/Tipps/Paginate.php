<?php

namespace App\View\Components\Tipps;

use App\Http\Clients\OpenLiga;
use Illuminate\View\Component;
use Illuminate\Http\Request;

class Paginate extends Component
{
    private $request;
    private $extraPages = 2;
    private OpenLiga $openLiga;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Request $request, OpenLiga $openLiga)
    {
        $this->request = $request;
        $this->openLiga = $openLiga;
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

        if(is_null($currentDay))
            $currentDay = $this->openLiga->getCurrentDay($league);

        for ($i = $currentDay - $this->extraPages; $i <=  $currentDay +  $this->extraPages ; $i++) {
            if ($i >= 1 && $i <= 34)
            $links[] = $i;
        }

        return view('components.tipps.paginate', compact('currentDay', 'league', 'links'));
    }
}
