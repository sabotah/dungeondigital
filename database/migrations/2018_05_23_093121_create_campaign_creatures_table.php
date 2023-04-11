<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignCreaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_creatures', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('creature_id');
            $table->foreign('creature_id')->references('id')->on('creatures');
            $table->unsignedInteger('campaign_id');
            $table->foreign('campaign_id')->references('id')->on('campaigns');
            $table->unsignedInteger('area_id')->nullable();
            $table->foreign('area_id')->references('id')->on('areas');             
            $table->unsignedInteger('room_id')->nullable();
            $table->foreign('room_id')->references('id')->on('rooms');
            $table->unsignedInteger('environment_id')->nullable();
            $table->foreign('environment_id')->references('id')->on('environments');
            $table->string('name')->nullable();
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
            $table->integer('current_col')->nullable();
            $table->integer('current_row')->nullable();
            $table->integer('current_hp')->nullable();
            $table->integer('count');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaign_creatures');
    }
}
