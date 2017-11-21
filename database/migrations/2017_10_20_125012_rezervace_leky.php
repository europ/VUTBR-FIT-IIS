<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RezervaceLeky extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rezervace_leky', function (Blueprint $table){
            $table->integer('id_leku')->unsigned()->nullable();
            $table->integer('id_rezervace')->unsigned()->nullable();
        });

        Schema::table('rezervace_leky', function (Blueprint $table){
            $table->foreign('id_leku')->references('id_leku')->on('leky');
            $table->foreign('id_rezervace')->references('id_rezervace')->on('rezervace');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rezervace_leky');
    }
}
