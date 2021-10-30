<?php

namespace App\View\Components\Developer;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class LoginAsUser extends Component
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
        if(!Gate::allows('dev.login_as_user'))
            return "";
        $users = User::all();
        $users = $users->whereNotIn('id', [Auth::user()->id]);
        return view('components.developer.login-as-user', compact('users'));
    }
}
