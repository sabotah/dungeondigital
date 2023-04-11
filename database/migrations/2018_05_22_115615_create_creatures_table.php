<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('creatures', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name');
            $table->string('size')->nullable();
            $table->string('type')->nullable();
            $table->string('subtype')->nullable();
            $table->string('alignment')->nullable();
            $table->integer('armor_class')->nullable();
            $table->integer('hit_points')->nullable();
            $table->string('hit_dice')->nullable();
            $table->string('speed')->nullable();
            $table->integer('strength')->nullable();
            $table->integer('dexterity')->nullable();
            $table->integer('constitution')->nullable();
            $table->integer('intelligence')->nullable();
            $table->integer('wisdom')->nullable();
            $table->integer('charisma')->nullable();
            $table->integer('dexterity_save')->nullable();
            $table->integer('constitution_save')->nullable();
            $table->integer('intelligence_save')->nullable();
            $table->integer('wisdom_save')->nullable();
            $table->integer('charisma_save')->nullable();
            $table->integer('perception')->nullable();
            $table->integer('stealth')->nullable();
            $table->string('damage_vulnerabilities')->nullable();
            $table->string('damage_resistances')->nullable();
            $table->string('damage_immunities')->nullable();
            $table->string('condition_immunities')->nullable();
            $table->string('senses')->nullable();
            $table->string('languages')->nullable();
            $table->string('challenge_rating')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('creatures');
    }
}
