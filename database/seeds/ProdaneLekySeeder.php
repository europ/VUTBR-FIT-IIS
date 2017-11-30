<?php

use Illuminate\Database\Seeder;

class ProdaneLekySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('prodane_leky')->insert(array(
    		array('mnozstvi' => 4, 'datum' => '2007-02-02', 'id_pobocky' => 1, 'id_leku' => 1),
    		array('mnozstvi' => 5, 'datum' => '2016-03-12', 'id_pobocky' => 1, 'id_leku' => 4),
    		array('mnozstvi' => 4, 'datum' => '2006-05-29', 'id_pobocky' => 3, 'id_leku' => 7),
    		array('mnozstvi' => 5, 'datum' => '2016-01-25', 'id_pobocky' => 5, 'id_leku' => 2),
    		array('mnozstvi' => 10, 'datum' => '2006-05-29', 'id_pobocky' => 4, 'id_leku' => 13),
    		array('mnozstvi' => 7, 'datum' => '2006-05-29', 'id_pobocky' => 2, 'id_leku' => 14),
    		array('mnozstvi' => 7, 'datum' => '2006-05-29', 'id_pobocky' => 3, 'id_leku' => 14),
    		array('mnozstvi' => 3, 'datum' => '2006-05-29', 'id_pobocky' => 2, 'id_leku' => 14),
    		array('mnozstvi' => 2, 'datum' => '2006-05-29', 'id_pobocky' => 5, 'id_leku' => 14),
    		array('mnozstvi' => 1, 'datum' => '2006-05-29', 'id_pobocky' => 4, 'id_leku' => 14),
    	));

    }
}
