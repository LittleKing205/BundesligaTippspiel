<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DefaultRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $allPermissions = array(
            // Function Permissions
            'edit_closed_games',

            // Site Permissions
            'show_treasurer_page'
        );

        $defaultRoles = array(
            __('role_names.admin') => [
                'edit_closed_games',
                'show_treasurer_page'
            ],
            __('role_names.treasurer') => [
                'show_treasurer_page'
            ]
        );

        foreach($allPermissions as $newPermission) {
            Permission::create(['name' => $newPermission]);
        }

        foreach($defaultRoles as $name => $permissions) {
            $role = Role::create(['name' => $name]);
            $role->syncPermissions($permissions);
        }
    }
}
