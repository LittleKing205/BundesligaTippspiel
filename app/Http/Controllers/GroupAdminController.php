<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupAdminController extends Controller
{
    public function __construct() {
        $this->middleware("can:group-admin");
    }

    public function show(Request $request) {
        return redirect(route('group-admin.users'));
        //return view('group-admin.home');
    }

    public function showUsers(Request $request) {
        $users = Auth::user()->currentGroup->users;
        return view('group-admin.user-list', compact('users'));
    }

    public function showUser(Request $request, User $user) {
        if (!UserGroup::where("user_id", $user->id)->get()->contains("tipp_group_id", Auth::user()->current_group_id))
            abort(404);
        return view('group-admin.user', compact('user'));
    }
}
