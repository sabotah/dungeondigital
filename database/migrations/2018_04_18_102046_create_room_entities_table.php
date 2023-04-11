<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomEntitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_entities', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('entity_id');
            $table->foreign('entity_id')->references('id')->on('entities');
            $table->unsignedInteger('room_id');
            $table->foreign('room_id')->references('id')->on('rooms');
            $table->string('customname')->nullable();
            $table->string('customcolour')->nullable();
            $table->integer('offset_row');
            $table->integer('offset_col');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_entities');
    }
}
