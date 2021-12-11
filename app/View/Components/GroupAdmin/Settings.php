<?php

namespace App\View\Components\GroupAdmin;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class Settings extends Component
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
        $group = Auth::user()->currentGroup;
        return view('components.group-admin.settings', compact('group'));
    }
}
