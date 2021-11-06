<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTippGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipp_groups', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->unsignedBigInteger('owner_id');
            $table->string('invite_code')->nullable()->unique();
            $table->json("settings")->nullable();
            $table->timestamps();
        });

        Schema::create('user_groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tipp_group_id');
            $table->unsignedBigInteger('user_id');
        });

        Schema::table('bills', function(Blueprint $table) {
            $table->unsignedBigInteger('tipp_group_id')->after('user_id');
        });

        Schema::table('users', function(Blueprint $table) {
            $table->unsignedBigInteger('current_group')->nullable()->after('password');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipp_groups');
        Schema::dropIfExists('user_groups');
        Schema::table('bills', function(Blueprint $table) {
            $table->dropColumn('tipp_group_id');
        });

        Schema::table('users', function(Blueprint $table) {
            $table->dropColumn('last_group');
        });
    }
}
