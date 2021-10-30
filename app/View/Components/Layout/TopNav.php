<?php

namespace App\View\Components\Layout;

use App\Models\User;
use Illuminate\View\Component;

class TopNav extends Component
{
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
        $backToUser = null;

        if(session('devIsLoggedInAsDifferentUser', false)) {
            $backToUser = User::find(session('devOriginalUserId'));
        }

        return view('components.layout.top-nav', compact('backToUser'));
    }
}
