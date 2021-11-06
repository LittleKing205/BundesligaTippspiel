<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app(\Spatie\Permission\PermissionRegistrar::class)->setPermissionsTeamId(1);
        $admin = User::factory()->make([
            'username' => 'admin',
            'name' => 'admin',
            'current_group_id' => 1
        ]);
        $admin->assignRole(__('role_names.admin'));
        $admin->save();

        $treasurer = User::factory()->make([
            'username' => 'kassenwart',
            'name' => 'kassenwart',
            'current_group_id' => 1
        ]);
        $treasurer->assignRole(__('role_names.treasurer'));
        $treasurer->save();

        $treasurer = User::factory()->make([
            'username' => 'dev',
            'name' => 'dev',
            'current_group_id' => 1
        ]);
        $treasurer->assignRole(__('role_names.dev'));
        $treasurer->save();

        $user = User::factory()->make([
            'username' => 'user',
            'name' => 'user',
            'current_group_id' => 1
        ])->save();

        $user = User::factory()->make([
            'username' => 'user2',
            'name' => 'user2'
        ])->save();
    }
}
