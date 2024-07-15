<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatesGameTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('stats', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->integer('games_won')->default(0);
            $table->integer('games_played')->default(0);
            $table->integer('won_as_shark')->default(0);
            $table->integer('won_as_brody')->default(0);
            $table->integer('won_as_hooper')->default(0);
            $table->integer('won_as_quint')->default(0);
            $table->integer('times_picked_shark')->default(0);
            $table->integer('times_picked_brody')->default(0);
            $table->integer('times_picked_hooper')->default(0);
            $table->integer('times_picked_quint')->default(0);
            $table->unsignedBigInteger('user_id')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::create('cards', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('type');
            $table->string('title')->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->string('token')->unique();
            $table->text('action')->nullable();
            $table->timestamps();
        });

        Schema::create('boats', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->integer('tile_1_health')->default(1);
            $table->integer('tile_2_health')->default(1);
            $table->integer('tile_3_health')->default(1);
            $table->integer('tile_4_health')->default(1);
            $table->integer('tile_5_health')->default(1);
            $table->integer('tile_6_health')->default(1);
            $table->integer('tile_7_health')->default(1);
            $table->integer('tile_8_health')->default(1);
            $table->integer('shark_target')->nullable();
            $table->integer('shark_position')->default(0);
            $table->integer('brody_target')->nullable();
            $table->integer('brody_position')->default(0);
            $table->integer('hooper_target')->nullable();
            $table->integer('hooper_position')->default(0);
            $table->integer('quint_target')->nullable();
            $table->integer('quint_position')->default(0);
            $table->timestamps();
        });

        Schema::create('games', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('session_id');
            $table->string('game_id')->nullable();
            $table->unsignedBigInteger('host_id')->references('id')->on('users');
            $table->unsignedBigInteger('boat_id')->nullable()->references('id')->on('boats');
            $table->integer('monitor')->nullable();
            $table->integer('player')->nullable();
            $table->string('status')->default('not started');
            $table->integer('act')->default(1);
            $table->string('winner')->nullable();
            $table->string('number_of_shark_abilities')->default(0);
            $table->string('number_of_crew_gear')->default(0);
            $table->integer('brody_health')->default(6);
            $table->integer('hooper_health')->default(6);
            $table->integer('quint_health')->default(6);
            $table->integer('shark_health')->default(18);
            $table->integer('swimmers_ate')->default(0);
            $table->integer('attached_barrels')->default(0);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('cards');
        Schema::dropIfExists('stats');
        Schema::dropIfExists('boats');
        Schema::dropIfExists('games');

        Schema::enableForeignKeyConstraints();
    }
}
