<?php

namespace Database\Seeders;

use App\Models\TippGroup;
use App\Models\UserGroup;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TippGroup::create([
            "name" => "Test 1",
            "owner_id" => 3,
            "invite_code" => "123"
        ]);
        TippGroup::create([
            "name" => "Test 2",
            "owner_id" => 1,
            "invite_code" => "456"
        ]);

        UserGroup::create([
            "user_id" => 1,
            "tipp_group_id" => 1
        ]);
        UserGroup::create([
            "user_id" => 1,
            "tipp_group_id" => 2
        ]);
        UserGroup::create([
            "user_id" => 2,
            "tipp_group_id" => 1
        ]);
        UserGroup::create([
            "user_id" => 2,
            "tipp_group_id" => 2
        ]);
        UserGroup::create([
            "user_id" => 3,
            "tipp_group_id" => 1
        ]);
        UserGroup::create([
            "user_id" => 4,
            "tipp_group_id" => 1
        ]);
    }
}
