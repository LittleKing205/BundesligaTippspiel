<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InstallSeeder extends Seeder
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
            'email' => 'admin@example.com',
            'password' => Hash::make('tipp')
        ]);
    }
}
