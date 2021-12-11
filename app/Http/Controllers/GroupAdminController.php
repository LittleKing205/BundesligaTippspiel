<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class GroupAdminController extends Controller
{
    public function __construct() {
        $this->middleware("permission:admin.settings.show");
        $this->middleware("permission:admin.edit-roles")->only(['saveRoles', 'removeRoleFromUser']);
    }

    public function show(Request $request) {
        return view('group-settings');
    }

    public function kickUser(Request $request) {
        $validated = $request->validate([
            'user' => ['required', 'exists:users,username']
        ]);
        $user = User::where('username', $validated['user'])->first();
        $user->syncRoles([]);
        $oldGroup = UserGroup::where('user_id', $user->id)->where('tipp_group_id', Auth::user()->current_group_id)->first();
        $oldGroup->delete();
        $userGroups = $user->groups;
        if($userGroups->count() > 0) {
            $user->current_group_id = $userGroups->first()->id;
        } else {
            $user->current_group_id = null;
        }
        $user->save();
        return back()->with(['success' => 'Der Benutzer wurde erfolgreich aus dieser Gruppe entfernt.']);
    }

    public function removeRoleFromUser(Request $request) {
        $validated = $request->validate([
            'user' => ['required', 'exists:users,username'],
            'role' => ['required', 'string', Rule::exists('roles', 'name')->where(function($query) {
                    return $query->where('group_id', Auth::user()->current_group_id);
                })]
        ]);
        $user = User::where('username', $validated['user'])->first();
        $user->removeRole($validated['role']);

        return back()->with(['success' => 'Die Rolle wurde erfolgreich dem Benutzer entzogen']);
    }

    public function addRoleToUser(Request $request) {
        $validated = $request->validate([
            'user' => ['required', 'exists:users,username'],
            'role' => ['required', 'string', Rule::exists('roles', 'name')->where(function($query) {
                    return $query->where('group_id', Auth::user()->current_group_id);
                })]
        ]);
        $user = User::where('username', $validated['user'])->first();
        $user->assignRole($validated['role']);

        return back()->with(['success' => 'Hinzugefügt']);
    }

    public function createRole(Request $request) {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:4'],
            'permissions' => ['present', 'array', 'min:1']
        ]);
        $permissions = array();
        $role = Role::create(['name' => $validated['name'], 'group_id' => Auth::user()->current_group_id]);
        foreach(collect($validated["permissions"]) as $perm) {
            $permissions[] = Permission::findOrCreate($perm);
        }
        $role->syncPermissions($permissions);
        return redirect()->back()->with(['success' => 'Die Rolle '.$role->name.' wurde erfolgreich erstellt']);
    }

    public function deleteRole(Request $request) {
        $validated = $request->validate([
            'role' => ['required', 'string', Rule::exists('roles', 'name')->where(function($query) {
                return $query->where('group_id', Auth::user()->current_group_id);
            })]
        ]);

        $role = Role::findByName($validated['role']);
        $role->delete();
        return back()->with(['success' => "gelöscht"]);
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
        return redirect()->back()->with(['success' => 'Die Rolle '.$role->name.' wurde erfolgreich gespeichert']);
    }

    public function saveSettings(Request $request) {
        $validated = $request->validate([
            'invites_enabled' => ['required', 'boolean'],
            'pot_enabled' => ['required', 'boolean'],
            'wrong_tipp' => ['regex:/[\d.](,\d\d)?$/'],
            'not_tipped' => ['regex:/[\d.](,\d\d)?$/']
        ]);

        $group = Auth::user()->currentGroup;
        $group->invites_enabled = $validated['invites_enabled'];
        $group->pot_enabled = $validated['pot_enabled'];

        if($group->pot_enabled && isset($validated['wrong_tipp']) && isset($validated['not_tipped'])) {
            $validated['wrong_tipp'] = floatval(str_replace(',', '.', $validated['wrong_tipp']));
            $validated['not_tipped'] = floatval(str_replace(',', '.', $validated['not_tipped']));
            $group->wrong_tipp = $validated['wrong_tipp'];
            $group->not_tipped = $validated['not_tipped'];
        }
        $group->save();

        return redirect()->back()->with(['success' => 'Einstellungen gespeichert']);
    }

    public function changeInviteCode() {

        return redirect()->back()->with(['success' => 'Ein neuer Einladungscode wurde erstellt.']);
    }
}
