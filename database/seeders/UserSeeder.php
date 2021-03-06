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
            'name' => 'admin'
        ]);
        $admin->assignRole(__('role_names.admin'));
        $admin->save();

        $treasurer = User::factory()->make([
            'username' => 'kassenwart',
            'name' => 'kassenwart'
        ]);
        $treasurer->assignRole(__('role_names.treasurer'));
        $treasurer->save();

        $treasurer = User::factory()->make([
            'username' => 'dev',
            'name' => 'dev'
        ]);
        $treasurer->assignRole(__('role_names.dev'));
        $treasurer->save();

        $user = User::factory()->make([
            'username' => 'user',
            'name' => 'user'
        ])->save();

        User::factory()->count(1)->create();
    }
}
