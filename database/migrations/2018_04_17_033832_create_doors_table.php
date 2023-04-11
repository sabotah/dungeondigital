<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doors', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('area_id');
            $table->foreign('area_id')->references('id')->on('areas');
            $table->integer('start_row')->nullable();
            $table->integer('start_col')->nullable();
            $table->integer('end_row');
            $table->integer('end_col');
            $table->boolean('locked')->default(false);
            $table->integer('difficulty')->nullable();
            $table->boolean('hidden')->default(false);
            $table->string('placement')->default('right');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doors');
    }
}
