<?php

use Illuminate\Database\Seeder;

class PobockyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('pobocky')->insert(array(
    		array('nazev_pobocky' => 'Afrodite','adresa_ulice' => 'Porici','adresa_cislo' => '5','adresa_mesto' => 'Brno', 'adresa_psc' => 63900),
    		array('nazev_pobocky' => 'Nemesis','adresa_ulice' => 'Technicka','adresa_cislo' => '3058/10','adresa_mesto' => 'Brno', 'adresa_psc' => 61600),
    		array('nazev_pobocky' => 'Peitho','adresa_ulice' => 'Purkynova','adresa_cislo' => '464/118','adresa_mesto' => 'Brno', 'adresa_psc' => 61200),
    		array('nazev_pobocky' => 'Pothos','adresa_ulice' => 'Bozetechova','adresa_cislo' => '2', 'adresa_mesto' => 'Brno', 'adresa_psc' => 61266),
    		array('nazev_pobocky' => 'Themis','adresa_ulice' => 'Kolejni','adresa_cislo' => '2906/4','adresa_mesto' => 'Brno', 'adresa_psc' => 61200),
    		array('nazev_pobocky' => 'Tyche','adresa_ulice' => 'Veveru','adresa_cislo' => '331/95','adresa_mesto' => 'Brno', 'adresa_psc' => 60200),
    		array('nazev_pobocky' => 'Asklepios','adresa_ulice' => 'Technicka','adresa_cislo' => '2896/2','adresa_mesto' => 'Brno', 'adresa_psc' => 61669),
    		array('nazev_pobocky' => 'Dionysos','adresa_ulice' => 'Udolni','adresa_cislo' => '244/53','adresa_mesto' => 'Brno', 'adresa_psc' => 60200),
    		array('nazev_pobocky' => 'Eros','adresa_ulice' => 'Purkynova','adresa_cislo' => '464/118','adresa_mesto' => 'Brno', 'adresa_psc' => 61200),
    	));
    }
}
