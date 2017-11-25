<?php

use Illuminate\Database\Seeder;

class PredpisyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('predpisy')->insert(array(
            array('rodne_cislo' => '9507236607', 'id_pojistovny' => 2),
            array('rodne_cislo' => '9651279946', 'id_pojistovny' => 3),
            array('rodne_cislo' => '9205137667', 'id_pojistovny' => 5),
            array('rodne_cislo' => '9511163948', 'id_pojistovny' => 1),
            array('rodne_cislo' => '8955147839', 'id_pojistovny' => 2),
            array('rodne_cislo' => '9655053826', 'id_pojistovny' => 2),
            array('rodne_cislo' => '9504210298', 'id_pojistovny' => 2),
            array('rodne_cislo' => '9504071302', 'id_pojistovny' => 2),
            array('rodne_cislo' => '7409011126', 'id_pojistovny' => 4),
            array('rodne_cislo' => '9651279946', 'id_pojistovny' => 5),
            array('rodne_cislo' => '9205137667', 'id_pojistovny' => 5),
            array('rodne_cislo' => '9511163948', 'id_pojistovny' => 6),
            array('rodne_cislo' => '8955147839', 'id_pojistovny' => 2),
            array('rodne_cislo' => '9655053826', 'id_pojistovny' => 2),
            array('rodne_cislo' => '9504210298', 'id_pojistovny' => 5),
            array('rodne_cislo' => '9504071302', 'id_pojistovny' => 5),
            array('rodne_cislo' => '7409011126', 'id_pojistovny' => 2)
    	));
    }
}
