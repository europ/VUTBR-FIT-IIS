<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PredpisyLeky extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('predpisy_leky', function (Blueprint $table){
            $table->integer('id_leku')->unsigned()->nullable();
            $table->integer('id_predpisu')->unsigned()->nullable();
        });

        Schema::table('predpisy_leky', function (Blueprint $table){
            $table->foreign('id_leku')->references('id_leku')->on('leky');
            $table->foreign('id_predpisu')->references('id_predpisu')->on('predpisy');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('predpisy_leky');
    }
}
