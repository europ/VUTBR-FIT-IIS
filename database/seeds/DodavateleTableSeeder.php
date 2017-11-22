<?php

use Illuminate\Database\Seeder;

class DodavateleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('dodavatele')->insert(array(
            array('nazev' => 'Asd', 'typ' => 0, 'datum_dodani' => '2000-01-01', 'platnost_smlouvy_od' => '2010-01-01', 'platnost_smlouvy_do' => '2020-01-01'),
            array('nazev' => 'AAA', 'typ' => 1, 'datum_dodani' => '2000-01-01', 'platnost_smlouvy_od' => '2010-01-01', 'platnost_smlouvy_do' => '2020-01-01'),
            array('nazev' => 'BBB', 'typ' => 0, 'datum_dodani' => '2000-01-01', 'platnost_smlouvy_od' => '2010-01-01', 'platnost_smlouvy_do' => '2020-01-01'),
            array('nazev' => 'CCC', 'typ' => 1, 'datum_dodani' => '2000-01-01', 'platnost_smlouvy_od' => '2010-01-01', 'platnost_smlouvy_do' => '2020-01-01'),
            array('nazev' => 'XXX', 'typ' => 0, 'datum_dodani' => '2000-01-01', 'platnost_smlouvy_od' => '2010-01-01', 'platnost_smlouvy_do' => '2020-01-01'),

        /*
        // FIX THIS please
            array(
                  'nazev'               => 'Barnys',
                  'typ'                 => 1,
                  'datum_dodani'        => '2006-06-15',
                  'platnost_smlouvy_od' => NULL,
                  'platnost_smlouvy_do' => NULL
                 ),
            array(
                  'nazev'               => 'Schwabe Czech Republic, s.r.o.',
                  'typ'                 => 0,
                  'datum_dodani'        => NULL,
                  'platnost_smlouvy_od' => '2016-03-12',
                  'platnost_smlouvy_do' => '2016-03-12',
                 ),
            array(
                  'nazev'               => 'FAVEA, spol. s.r.o.',
                  'typ'                 => 0,
                  'datum_dodani'        => NULL,
                  'platnost_smlouvy_od' => '2008-07-04',
                  'platnost_smlouvy_do' => '2008-07-04',
                 ),
            array(
                  'nazev'               => 'PHOENIX lekarensky velkoobchod, a.s.',
                  'typ'                 => 1,
                  'datum_dodani'        => '2013-03-18',
                  'platnost_smlouvy_od' => NULL,
                  'platnost_smlouvy_do' => NULL,
                 ),
            array(
                  'nazev'               => 'IBI-International spol. s.r.o.',
                  'typ'                 => 1,
                  'datum_dodani'        => '2008-09-28',
                  'platnost_smlouvy_od' => NULL,
                  'platnost_smlouvy_do' => NULL,
                 ),
            array(
                  'nazev'               => 'Interpharma Praha, a.s.',
                  'typ'                 => 1,
                  'datum_dodani'        => '2012-06-18',
                  'platnost_smlouvy_od' => NULL,
                  'platnost_smlouvy_do' => NULL,
                 ),
            array(
                  'nazev'               =>'NOVIKO a.s.',
                  'typ'                 => 1,
                  'datum_dodani'        => '2005-07-29',
                  'platnost_smlouvy_od' => NULL,
                  'platnost_smlouvy_do' => NULL,
                 ),
            array(
                  'nazev'               => 'Alliance Healthcare s.r.o.',
                  'typ'                 => 1,
                  'datum_dodani'        => '2005-04-15',
                  'platnost_smlouvy_od' => NULL,
                  'platnost_smlouvy_do' => NULL,
                 ),
            array(
                  'nazev'               => 'Dr. Peithner Prag s.r.o.',
                  'typ'                 => 0,
                  'datum_dodani'        => NULL,
                  'platnost_smlouvy_od' => '2012-08-03',
                  'platnost_smlouvy_do' => '2012-08-03',
                 ),
            array(
                  'nazev'               => 'Pfizer, spol. s.r.o.',
                  'typ'                 => 0,
                  'datum_dodani'        => NULL,
                  'platnost_smlouvy_od' => '2008-07-05',
                  'platnost_smlouvy_do' => '2008-07-05',
                 ),
            array(
                  'nazev'               => 'Wyeth Whitehall Czech s.r.o.',
                  'typ'                 => 1,
                  'datum_dodani'        => '2006-07-06',
                  'platnost_smlouvy_od' => NULL,
                  'platnost_smlouvy_do' => NULL,
                 ),
            array(
                  'nazev'               => 'Glenmark Pharmaceuticals s.r.o.',
                  'typ'                 => 1,
                  'datum_dodani'        => '2009-09-29',
                  'platnost_smlouvy_od' => NULL,
                  'platnost_smlouvy_do' => NULL,
                 ),
            array(
                  'nazev'               => 'PANEP s.r.o.',
                  'typ'                 => 0,
                  'datum_dodani'        => NULL,
                  'platnost_smlouvy_od' => '2010-02-07',
                  'platnost_smlouvy_do' => '2010-02-07',
                 ),
            array(
                  'nazev'               => 'MERCK spol. s.r.o.',
                  'typ'                 => 0,
                  'datum_dodani'        => NULL,
                  'platnost_smlouvy_od' => '2007-06-02',
                  'platnost_smlouvy_do' => '2007-06-02',
                 ),
            array(
                  'nazev'               => 'EXBIO Praha, a.s.',
                  'typ'                 => 1,
                  'datum_dodani'        => '2015-09-19'
                  'platnost_smlouvy_od' => NULL,
                  'platnost_smlouvy_do' => NULL,
                 ),
            array(
                  'nazev'               => 'Fresenius Kabi s.r.o.',
                  'typ'                 => 1,
                  'datum_dodani'        => '2010-04-21',
                  'platnost_smlouvy_od' => NULL,
                  'platnost_smlouvy_do' => NULL,
                 ),
            array(
                  'nazev'               => 'Medicom International s.r.o.',
                  'typ'                 => 1,
                  'datum_dodani'        => '2016-11-25',
                  'platnost_smlouvy_od' => NULL,
                  'platnost_smlouvy_do' => NULL,
                 ),
            */
        ));
    }
}
