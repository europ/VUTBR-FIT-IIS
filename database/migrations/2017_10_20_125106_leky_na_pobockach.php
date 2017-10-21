<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LekyNaPobockach extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leky_na_pobockach', function (Blueprint $table){
            $table->integer('mnozstvi');
            $table->integer('id_pobocky')->unsigned()->nullable();
            $table->integer('id_leku')->unsigned()->nullable();
        });
        
        Schema::table('leky_na_pobockach', function (Blueprint $table){
            $table->foreign('id_leku')->references('id_leku')->on('leky');
            $table->foreign('id_pobocky')->references('id_pobocky')->on('pobocky');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leky_na_pobockach');
    }
}
