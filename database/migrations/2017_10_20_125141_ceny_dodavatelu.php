<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CenyDodavatelu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ceny_dodavatelu', function (Blueprint $table){
            $table->integer('cena');
            $table->integer('id_dodavatele')->unsigned()->nullable();
            $table->integer('id_leku')->unsigned()->nullable();
        });

        Schema::table('ceny_dodavatelu', function (Blueprint $table){
            $table->foreign('id_leku')->references('id_leku')->on('leky');
            $table->foreign('id_dodavatele')->references('id_dodavatele')->on('dodavatele');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ceny_dodavatelu');
    }
}
