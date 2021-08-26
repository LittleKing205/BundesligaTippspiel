<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team1_id');
            $table->unsignedBigInteger('team2_id');
            $table->unsignedTinyInteger('league');
            $table->unsignedTinyInteger('day');
            $table->timestamp('match_start')->nullable();
            $table->boolean('has_finished');
            $table->unsignedTinyInteger('result')->nullable();
            $table->unsignedTinyInteger('team1_points')->nullable();
            $table->unsignedTinyInteger('team2_points')->nullable();
            $table->boolean('notified')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matches');
    }
}
