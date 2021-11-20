<?php

namespace App\View\Components\GroupAdmin;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Spatie\Permission\Models\Role;

class Roles extends Component
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
        $roles = Role::where('group_id', Auth::user()->current_group_id)->get();
        return view('components.group-admin.roles', compact('roles'));
    }
}
