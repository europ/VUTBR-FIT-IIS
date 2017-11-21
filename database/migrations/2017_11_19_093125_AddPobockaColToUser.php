<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPobockaColToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('id_pobocky')->unsigned()->nullable();
            $table->foreign('id_pobocky')->references('id_pobocky')->on('pobocky');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        $table->dropForeign('id_pobocky_foreign');
        $table->dropColumn('id_pobocky');
    }
}
