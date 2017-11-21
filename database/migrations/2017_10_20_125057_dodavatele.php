<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Dodavatele extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dodavatele', function (Blueprint $table){
            $table->increments('id_dodavatele');
            $table->string('nazev');
            $table->integer('typ');
            $table->date('datum_dodani');
            $table->date('platnost_smlouvy_od');
            $table->date('platnost_smlouvy_do');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dodavatele');
    }
}
