<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class TreasurerController extends Controller
{

    public function show(Request $request) {
        $users = User::all();
        $showWithMissing = false;
        $filter = $request;
        $bills = Bill::with('user');

        if(!is_null($request->input("user"))) {
            $user = User::where("name", $request->input("user"))->first();
            if (!is_null($user))
                $bills = $bills->where("user_id", $user->id);
        }

        $bills = $bills->get();

        return view('treasurer', compact('users', 'showWithMissing', 'bills'));
    }
}
