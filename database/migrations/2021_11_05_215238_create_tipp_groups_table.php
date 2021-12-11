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
            $table->boolean('invites_enabled')->default(true);
            $table->string('invite_code')->unique();
            $table->boolean('payment_enabled')->default(true);
            $table->float('wrong_tipp')->default(0.50);
            $table->float('not_tipped')->default(1.00);
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
            $table->unsignedBigInteger('current_group_id')->nullable()->after('password');
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
            $table->dropColumn('current_group_id');
        });
    }
}
