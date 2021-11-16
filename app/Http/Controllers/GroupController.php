<?php

namespace App\Http\Controllers;

use App\Models\TippGroup;
use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{

    public function modalFormSwitch(Request $request) {
        $validated = $request->validate([
            "btn" => ["required", "regex:/(add|switch)/isU"]
        ]);
        switch($validated['btn']) {
            case "add":
                return redirect(route("group.new.show"));
                break;
            case "switch":
                return $this->switchGroup($request);
                break;
        }
    }

    public function switchGroup(Request $request) {
        $validated = $request->validate([
            "switched-group" => ["exists:App\Models\TippGroup,id"]
        ]);
        $user = Auth::user();
        if (UserGroup::where("user_id", $user->id)->get()->contains("tipp_group_id", $validated["switched-group"])) {
            $user->current_group_id = $validated["switched-group"];
            $user->save();
            return redirect(route("dashboard"));
        }
        abort(403);
    }

    public function addGroupShow(Request $request) {
        return view('auth.new-group');
    }

    public function createGroup(Request $request) {
        $validated = $request->validate([
            "name" => ["required", "unique:tipp_groups,name"]
        ]);
        $user = Auth::user();

        $group = TippGroup::create([
            "name" => $validated["name"],
            "owner_id" => $user->id
        ]);
        $user_group = UserGroup::create([
            "user_id" => $user->id,
            "tipp_group_id" => $group->id
        ]);
        $user->current_group_id = $group->id;
        $user->save();

        return redirect(route('dashboard'));
    }
}
