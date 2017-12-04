<?php

use Illuminate\Database\Seeder;

class RezervaceLekySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rezervace_leky')->insert(array(
    		array('id_leku' => 1,'id_rezervace' => 1),
    		array('id_leku' => 2,'id_rezervace' => 2),
    		array('id_leku' => 3,'id_rezervace' => 3),
    		array('id_leku' => 4,'id_rezervace' => 4),
    		array('id_leku' => 5,'id_rezervace' => 5),
    		array('id_leku' => 6,'id_rezervace' => 6),
    		array('id_leku' => 7,'id_rezervace' => 7),
    		array('id_leku' => 7,'id_rezervace' => 8),
    		array('id_leku' => 8,'id_rezervace' => 9),
    		array('id_leku' => 9,'id_rezervace' => 10),
    		array('id_leku' => 15,'id_rezervace' => 11),
    		array('id_leku' => 17,'id_rezervace' => 12),
    		array('id_leku' => 20,'id_rezervace' => 13),
    		array('id_leku' => 22,'id_rezervace' => 14),
    		array('id_leku' => 41,'id_rezervace' => 15),
    		array('id_leku' => 32,'id_rezervace' => 16),
    		array('id_leku' => 42,'id_rezervace' => 17),
    		array('id_leku' => 15,'id_rezervace' => 18),
    		array('id_leku' => 3,'id_rezervace' => 19),
    		array('id_leku' => 3,'id_rezervace' => 20),
    		array('id_leku' => 6,'id_rezervace' => 21),
    		array('id_leku' => 5,'id_rezervace' => 22),
    		array('id_leku' => 8,'id_rezervace' => 23),
    		
    	));
    }
}
