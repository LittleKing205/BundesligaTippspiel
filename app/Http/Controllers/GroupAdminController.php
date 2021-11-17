<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class GroupAdminController extends Controller
{
    public function __construct() {
        $this->middleware("permission:admin.settings.show");
        $this->middleware("permission:admin.edit-roles")->only(['saveRoles']);
    }

    public function show(Request $request) {
        return redirect(route('group-admin.roles'));
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

    public function showRoles(Request $request) {
        $roles = Role::where('group_id', Auth::user()->current_group_id)->get();
        return view('group-admin.role-list', compact("roles"));
    }

    public function saveRoles(Request $request) {
        $validated = $request->validate([
            'role' => ['required', 'exists:roles,id'],
            'permissions' => ['present', 'array', 'min:1'],
            'permissions.0' => ['required', 'string', 'in:EMPTY-PERMISSION']
        ]);
        $permissions = array();
        $role = Role::find($validated['role']);

        foreach(collect($validated["permissions"])->skip(1) as $perm) {
            $permissions[] = Permission::findOrCreate($perm);
        }

        $role->syncPermissions($permissions);

        return redirect()->back()->with(['success' => 'Die Rolle wurde erfolgreich gespeichert']);
    }
}
