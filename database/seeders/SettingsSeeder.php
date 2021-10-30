<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now('utc')->toDateTimeString();

        $defaultSettings = [
            ["key" => "register_enabled", "value" => true, "created_at" => $now]
        ];

        Settings::insert($defaultSettings);
    }
}
