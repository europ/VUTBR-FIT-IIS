<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Rezervace extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rezervace', function (Blueprint $table){
            $table->increments('id_rezervace');
            $table->string('jmeno_zakaznika');
            $table->date('datum_vytvoreni');//date or dateTime?
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rezervace');
    }
}
