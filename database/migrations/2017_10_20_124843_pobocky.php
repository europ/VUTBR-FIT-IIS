<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Pobocky extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pobocky', function (Blueprint $table){
            $table->increments('id_pobocky');
            $table->string('nazev_pobocky');
            $table->string('adresa_ulice');
            $table->string('adresa_cislo');
            $table->string('adresa_mesto');
            $table->integer('adresa_psc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pobocky');
    }
}
