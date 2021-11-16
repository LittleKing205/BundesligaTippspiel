<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $allPermissions = array(
            // Dev Functions
            'dev.edit_closed_games',
            'dev.login_as_user',

            // Treasurer Permissions
            'treasurer.show',
            'treasurer.reject_payment'
        );

        $defaultRoles = array(
            __('role_names.admin') => [
                'treasurer.show',
                'treasurer.reject_payment'
            ],
            __('role_names.dev') => [
                'dev.login_as_user',
                'dev.edit_closed_games',
            ],
            __('role_names.treasurer') => [
                'treasurer.show',
                'treasurer.reject_payment'
            ]
        );

        foreach($allPermissions as $newPermission) {
            Permission::create(['name' => $newPermission]);
        }

        foreach($defaultRoles as $name => $permissions) {
            $role = Role::create(['name' => $name, 'group_id' => 1]);
            $role->syncPermissions($permissions);
        }
    }
}
