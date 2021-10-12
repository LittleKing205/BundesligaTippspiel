<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('matches:loadall');

        DB::unprepared(file_get_contents(database_path("sql/tipps.sql")));

        User::create([
            "name" => "Pascal",
            "username" => "Pascal",
            "email" => "pascal.schreiber.94@gmx.de",
            "password" => Hash::make("0609"),
            "join_key" => "f3ccca8e7c4443a9b1d6bd18cd6e61e9"
        ]);
        User::create([
            "name" => "Chilly",
            "username" => "Chilly",
            "email" => "monja.s@pascalschreiber.de",
            "password" => Hash::make("0609")
        ]);
        User::create([
            "name" => "Igor",
            "username" => "Axel",
            "email" => "axel.s@pascalschreiber.de",
            "password" => Hash::make("0609")
        ]);

        Artisan::call('make:oldbills');

        $user = User::where('id', 1)->first();

        $user->assignRole(__('role_names.admin'));
    }
}
