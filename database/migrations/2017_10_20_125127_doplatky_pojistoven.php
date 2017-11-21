<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DoplatkyPojistoven extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doplatky_pojistoven', function (Blueprint $table){
            $table->integer('hrazena_cast');
            $table->integer('id_pojistovny')->unsigned()->nullable();
            $table->integer('id_leku')->unsigned()->nullable();
        });

        Schema::table('doplatky_pojistoven', function (Blueprint $table){
            $table->foreign('id_leku')->references('id_leku')->on('leky');
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
        Schema::dropIfExists('doplatky_pojistoven');
    }
}
