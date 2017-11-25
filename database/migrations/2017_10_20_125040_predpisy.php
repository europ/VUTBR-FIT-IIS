<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Predpisy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('predpisy', function (Blueprint $table){
            $table->increments('id_predpisu');
            $table->string('rodne_cislo');
            $table->integer('id_pojistovny')->unsigned()->nullable();
        });

        Schema::table('predpisy', function (Blueprint $table){
            $table->foreign('id_pojistovny')->references('id_pojistovny')->on('pojistovny');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('predpisy');
    }
}
