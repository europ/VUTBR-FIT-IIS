<?php

use Illuminate\Database\Seeder;

class PoistovnyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('pojistovny')->insert(array(
    		array('nazev_pojistovny' => 'Addaven'),
    		));
    }
}
