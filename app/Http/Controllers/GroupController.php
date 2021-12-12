<?php

namespace App\Http\Controllers;

use App\Models\TippGroup;
use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class GroupController extends Controller
{

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
        $group->changeInviteCode();
        $user->current_group_id = $group->id;
        $user->save();

        $adminGroup = Role::create(["name" => __('role_names.admin'), 'group_id' => $group->id]);
        $adminPermissions = [
            Permission::findOrCreate('admin.settings.show'),
            Permission::findOrCreate('admin.edit-roles'),
            Permission::findOrCreate('treasurer.show'),
            Permission::findOrCreate('treasurer.reject_payment'),
            Permission::findOrCreate('treasurer.validate_payment')
        ];
        $adminGroup->syncPermissions($adminPermissions);

        $treasurerGroup = Role::create(["name" => __('role_names.treasurer'), 'group_id' => $group->id]);
        $treasurerPermissions = [
            Permission::findOrCreate('treasurer.show'),
            Permission::findOrCreate('treasurer.reject_payment'),
            Permission::findOrCreate('treasurer.validate_payment')
        ];
        $treasurerGroup->syncPermissions($treasurerPermissions);

        return redirect(route('dashboard'));
    }

    public function enterGroup(Request $request) {
        $validated = $request->validate([
            'invite_code' => ['string', 'nullable', Rule::exists('tipp_groups')->where(function ($query) {
                    return $query->where('invites_enabled', 1);
                }),
            ],
        ]);
        $user = Auth::user();
        $group = TippGroup::where('invite_code', $validated['invite_code'])->first();
        $user->current_group_id = $group->id;
        UserGroup::create([
            "user_id" => $user->id,
            "tipp_group_id" => $group->id
        ]);
        $user->save();

        return redirect(route('dashboard'));
    }
}
