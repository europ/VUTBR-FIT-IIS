<?php

use Illuminate\Database\Seeder;

class PredpisyLekySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('predpisy_leky')->insert(array(

    		array("id_leku" => 6, "id_predpisu" => 1),
    		array("id_leku" => 5, "id_predpisu" => 2),
    		array("id_leku" => 6, "id_predpisu" => 3),
    		array("id_leku" => 3, "id_predpisu" => 4),
    		array("id_leku" => 10, "id_predpisu" => 5),
    		array("id_leku" => 8, "id_predpisu" => 6),
    		array("id_leku" => 6, "id_predpisu" => 7),
    		array("id_leku" => 3, "id_predpisu" => 8),
    		array("id_leku" => 1, "id_predpisu" => 9),
    		array("id_leku" => 5, "id_predpisu" => 10),
    		array("id_leku" => 5, "id_predpisu" => 11),
    		array("id_leku" => 5, "id_predpisu" => 12),
    		array("id_leku" => 5, "id_predpisu" => 13),
    		array("id_leku" => 2, "id_predpisu" => 14),
    		array("id_leku" => 3, "id_predpisu" => 15),
    		array("id_leku" => 9, "id_predpisu" => 16),
    		array("id_leku" => 7, "id_predpisu" => 17),
    	));
    }
}
