<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharacterRoomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('character_room', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('character_id');
            $table->foreign('character_id')->references('id')->on('characters');
            $table->unsignedInteger('room_id');
            $table->foreign('room_id')->references('id')->on('rooms');
            $table->boolean('remembered')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('character_room', function (Blueprint $table) {
            //
        });
    }
}
