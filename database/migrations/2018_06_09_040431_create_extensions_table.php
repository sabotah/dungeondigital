<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extensions', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('room_id')->nullable();
            $table->foreign('room_id')->references('id')->on('rooms');
            $table->unsignedInteger('environment_id')->nullable();
            $table->foreign('environment_id')->references('id')->on('environments');
            $table->integer('start_row');
            $table->integer('start_col');
            $table->integer('end_row');
            $table->integer('end_col');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('extensions');
    }
}
