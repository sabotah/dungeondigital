<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreatureRoomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('creature_room', function (Blueprint $table) {
             $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('creature_id');
            $table->foreign('creature_id')->references('id')->on('creatures');
            $table->unsignedInteger('room_id');
            $table->foreign('room_id')->references('id')->on('rooms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('creature_room', function (Blueprint $table) {
            //
        });
    }
}
