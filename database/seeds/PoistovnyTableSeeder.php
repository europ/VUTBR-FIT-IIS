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
        DB::table('pojistovny')->insert(array(
            array('nazev_pojistovny' => 'Vseobecna zdravotni pojistovna CR'),
            array('nazev_pojistovny' => 'Vojenska zdravotni pojistovna CR'),
            array('nazev_pojistovny' => 'Ceska prumyslova zdravotni pojistovna'),
            array('nazev_pojistovny' => 'Oborova zdravotni poj. zam. bank, poj. a stav.'),
            array('nazev_pojistovny' => 'Zamestnanecka pojistovna Skoda'),
            array('nazev_pojistovny' => 'Zdravotni pojistovna ministerstva vnitra CR'),
            array('nazev_pojistovny' => 'Revirni bratrska pokladna, zdrav. pojistovna'),
            ));
    }
}
