<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProdaneLeky extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prodane_leky', function (Blueprint $table){
            $table->increments('id_prodej');
            $table->integer('mnozstvi');
            $table->date('datum');
            $table->integer('id_pobocky')->unsigned()->nullable();
            $table->integer('id_leku')->unsigned()->nullable();;
        });

        Schema::table('prodane_leky', function (Blueprint $table){
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
        Schema::dropIfExists('prodane_leky');
    }
}
