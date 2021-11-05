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
        $admin = User::factory()->make([
            'username' => 'admin',
            'name' => 'admin',
            'last_group' => 1
        ]);
        $admin->assignRole(__('role_names.admin'));
        $admin->save();

        $treasurer = User::factory()->make([
            'username' => 'kassenwart',
            'name' => 'kassenwart',
            'last_group' => 1
        ]);
        $treasurer->assignRole(__('role_names.treasurer'));
        $treasurer->save();

        $treasurer = User::factory()->make([
            'username' => 'dev',
            'name' => 'dev',
            'last_group' => 1
        ]);
        $treasurer->assignRole(__('role_names.dev'));
        $treasurer->save();

        $user = User::factory()->make([
            'username' => 'user',
            'name' => 'user',
            'last_group' => 1
        ])->save();
    }
}
