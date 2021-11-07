<?php

namespace App\View\Components\Layout;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class SwitchGroupModal extends Component
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
        $groups = Auth::user()->groups;
        return view('components.layout.switch-group-modal', compact("groups"));
    }
}
