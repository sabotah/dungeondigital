<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbilityCreatureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ability_creature', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('creature_id');
            $table->foreign('creature_id')->references('id')->on('creatures');
            $table->unsignedInteger('ability_id');
            $table->foreign('ability_id')->references('id')->on('abilities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ability_creature', function (Blueprint $table) {
            //
        });
    }
}
