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
            'can_edit_closed_games',

            // Site Permissions
            'show_treasurer_page'
        );

        $defaultRoles = array(
            'Admin' => [
                'can_edit_closed_games',
                'show_treasurer_page'
            ],
            'Kassenwart' => [
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
