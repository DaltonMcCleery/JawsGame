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

        Schema::create('shark', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->integer('health')->default(10);
            $table->integer('swimmers_ate')->default(0);
            $table->integer('barrels')->default(0);
            $table->unsignedBigInteger('user_id')->references('id')->on('users');;
            $table->timestamps();
        });

        Schema::create('stats', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->integer('games_won')->default(0);
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
            $table->string('image')->nullable();
            $table->text('description');
            $table->string('token')->unique();
            $table->text('action')->nullable();
            $table->timestamps();
        });

        Schema::create('boat', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->integer('tile_1_health');
            $table->integer('tile_2_health');
            $table->integer('tile_3_health');
            $table->integer('tile_4_health');
            $table->integer('tile_5_health');
            $table->integer('tile_6_health');
            $table->integer('tile_7_health');
            $table->integer('tile_8_health');
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
            $table->integer('max_sessions')->default(4);
            $table->integer('current_sessions')->default(1);
            $table->string('status')->default('not started');
            $table->integer('act')->default(1);
            $table->unsignedBigInteger('winner')->nullable()->references('id')->on('users');
            $table->string('shark_abilities')->default(0);
            $table->string('crew_gear')->default(0);
            $table->unsignedBigInteger('shark_id')->nullable()->references('id')->on('shark');
            $table->unsignedBigInteger('boat_id')->nullable()->references('id')->on('boat');
            $table->unsignedBigInteger('brody')->nullable()->references('id')->on('users');
            $table->integer('brody_health')->default(10);
            $table->unsignedBigInteger('hooper')->nullable()->references('id')->on('users');
            $table->integer('hooper_health')->default(10);
            $table->unsignedBigInteger('quint')->nullable()->references('id')->on('users');
            $table->integer('quint_health')->default(10);
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

        Schema::dropIfExists('shark');
        Schema::dropIfExists('cards');
        Schema::dropIfExists('stats');
        Schema::dropIfExists('boat');
        Schema::dropIfExists('games');

        Schema::enableForeignKeyConstraints();
    }
}
