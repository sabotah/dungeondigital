<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharactersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedInteger('campaign_id')->nullable();
            $table->foreign('campaign_id')->references('id')->on('campaigns');
            $table->unsignedInteger('room_id')->nullable();
            $table->foreign('room_id')->references('id')->on('rooms');
            $table->unsignedInteger('environment_id')->nullable();
            $table->foreign('environment_id')->references('id')->on('environments');
            $table->string('name');
            $table->string('maxhp')->nullable();
            $table->string('currenthp')->nullable();
            $table->integer('location_col')->nullable();
            $table->integer('location_row')->nullable();
            $table->integer('requested_col')->nullable();
            $table->integer('requested_row')->nullable();
            $table->string('race')->nullable();
            $table->string('class')->nullable();
            $table->string('avatar')->nullable();
            $table->string('charsheet')->nullable();
            $table->timestamp('lastchecked')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('characters');
    }
}
