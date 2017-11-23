<?php

use Illuminate\Database\Seeder;

class RezervaceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('rezervace')->insert(array(
    		array(
                'jmeno_zakaznika' => 'Adrián Tóth',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            array(
                'jmeno_zakaznika' => 'Peter Šuhaj',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            array(
                'jmeno_zakaznika' => 'Marek Schauer',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),

    	));
    }
}

// TODO add this to database instead of 3 array above
/*
    array(
        'jmeno_zakaznika' => 'Maly Princ',
        'created_at'      => '2007-06-02',
    ),
    array(
        'jmeno_zakaznika' => 'Paul Baumer',
        'created_at'      => '2007-06-02',
    ),
    array(
        'jmeno_zakaznika' => 'Hamlet Dansky',
        'created_at'      => '2007-06-02',
    ),
    array(
        'jmeno_zakaznika' => 'Pavel Herout',
        'created_at'      => '2007-06-02',
    ),
    array(
        'jmeno_zakaznika' => 'Anna Karenina',
        'created_at'      => '2007-06-02',
    ),
    array(
        'jmeno_zakaznika' => 'Marina Sladkovicova',
        'created_at'      => '2007-06-02',
    ),
    array(
        'jmeno_zakaznika' => 'Juraj Janosik',
        'created_at'      => '2007-06-02',
    ),
    array(
        'jmeno_zakaznika' => 'Pacho Hybsky',
        'created_at'      => '2007-06-02',
    ),
    array(
        'jmeno_zakaznika' => 'Holden Claufield',
        'created_at'      => '2007-06-02',
    ),
    array(
        'jmeno_zakaznika' => 'Maco Mliec',
        'created_at'      => '2007-06-02',
    ),
    array(
        'jmeno_zakaznika' => 'Adamek',
        'created_at'      => '2008-08-12',
    ),
    array(
        'jmeno_zakaznika' => 'Adamcova',
        'created_at'      => '2009-04-12',
    ),
    array(
        'jmeno_zakaznika' => 'Adamec',
        'created_at'      => '2005-04-16',
    ),
    array(
        'jmeno_zakaznika' => 'Adam',
        'created_at'      => '2014-08-10',
    ),
    array(
        'jmeno_zakaznika' => 'Adamova',
        'created_at'      => '2005-06-17',
    ),
    array(
        'jmeno_zakaznika' => 'Andel',
        'created_at'      => '2011-04-2',
    ),
    array(
        'jmeno_zakaznika' => 'Andelova',
        'created_at'      => '2014-05-23',
    ),
    array(
        'jmeno_zakaznika' => 'Andrlova',
        'created_at'      => '2008-08-1',
    ),
    array(
        'jmeno_zakaznika' => 'Andrle',
        'created_at'      => '2012-04-5',
    ),
    array(
        'jmeno_zakaznika' => 'Albrecht',
        'created_at'      => '2010-06-16',
    ),
    array(
        'jmeno_zakaznika' => 'Albrechtova',
        'created_at'      => '2007-08-4',
    ),
    array(
        'jmeno_zakaznika' => 'Ambroz',
        'created_at'      => '2012-04-10',
    ),
    array(
        'jmeno_zakaznika' => 'Ambrozova',
        'created_at'      => '2012-05-2',
    ),
    array(
        'jmeno_zakaznika' => 'Andrysek',
        'created_at'      => '2009-01-1',
    ),
    array(
        'jmeno_zakaznika' => 'Andryskova',
        'created_at'      => '2012-02-4',
    ),
    array(
        'jmeno_zakaznika' => 'Adamcik',
        'created_at'      => '2012-01-11',
    ),
    array(
        'jmeno_zakaznika' => 'Alexova',
        'created_at'      => '2011-09-17',
    ),
    array(
        'jmeno_zakaznika' => 'Alexa',
        'created_at'      => '2007-09-22',
    ),
    array(
        'jmeno_zakaznika' => 'Adamcikova',
        'created_at'      => '2005-01-4',
    ),
    array(
        'jmeno_zakaznika' => 'Andrlik',
        'created_at'      => '2008-02-16',
    ),
    array(
        'jmeno_zakaznika' => 'Anderlova',
        'created_at'      => '2012-07-2',
    ),
    array(
        'jmeno_zakaznika' => 'Andrlikova',
        'created_at'      => '2016-04-15',
    ),
    array(
        'jmeno_zakaznika' => 'Altman',
        'created_at'      => '2008-05-27',
    ),
    array(
        'jmeno_zakaznika' => 'Anderle',
        'created_at'      => '2011-09-17',
    ),
    array(
        'jmeno_zakaznika' => 'Altmanova',
        'created_at'      => '2008-08-8',
    ),
    array(
        'jmeno_zakaznika' => 'Adamik',
        'created_at'      => '2012-06-15',
    ),
    array(
        'jmeno_zakaznika' => 'Abraham',
        'created_at'      => '2012-02-16',
    ),
    array(
        'jmeno_zakaznika' => 'Adamikova',
        'created_at'      => '2015-04-16',
    ),
    array(
        'jmeno_zakaznika' => 'Absolonova',
        'created_at'      => '2009-05-26',
    ),
    array(
        'jmeno_zakaznika' => 'Absolon',
        'created_at'      => '2012-08-25',
    ),
    array(
        'jmeno_zakaznika' => 'Antl',
        'created_at'      => '2013-07-17',
    ),
    array(
        'jmeno_zakaznika' => 'Andrs',
        'created_at'      => '2011-06-12',
    ),
    array(
        'jmeno_zakaznika' => 'Abrahamova',
        'created_at'      => '2009-02-7',
    ),
    array(
        'jmeno_zakaznika' => 'Andrsova',
        'created_at'      => '2010-03-22',
    ),
    array(
        'jmeno_zakaznika' => 'Abrahamova',
        'created_at'      => '2016-07-6',
    ),
    array(
        'jmeno_zakaznika' => 'Abraham',
        'created_at'      => '2006-06-24',
    ),
    array(
        'jmeno_zakaznika' => 'Albert',
        'created_at'      => '2010-04-5',
    ),
    array(
        'jmeno_zakaznika' => 'Antlova',
        'created_at'      => '2009-08-17',
    ),
    array(
        'jmeno_zakaznika' => 'Albertova',
        'created_at'      => '2005-03-14',
    ),
    array(
        'jmeno_zakaznika' => 'Andres',
        'created_at'      => '2009-07-21',
    ),
    array(
        'jmeno_zakaznika' => 'Andresova',
        'created_at'      => '2016-07-19',
    ),
    array(
        'jmeno_zakaznika' => 'Antonin',
        'created_at'      => '2006-04-22',
    ),
    array(
        'jmeno_zakaznika' => 'Antalova',
        'created_at'      => '2008-06-8',
    ),
    array(
        'jmeno_zakaznika' => 'Adamus',
        'created_at'      => '2006-01-12',
    ),
    array(
        'jmeno_zakaznika' => 'Adlerova',
        'created_at'      => '2007-05-25',
    ),
    array(
        'jmeno_zakaznika' => 'Adler',
        'created_at'      => '2005-01-16',
    ),
    array(
        'jmeno_zakaznika' => 'Adamusova',
        'created_at'      => '2014-09-26',
    ),
    array(
        'jmeno_zakaznika' => 'Antoninova',
        'created_at'      => '2013-02-16',
    ),
    array(
        'jmeno_zakaznika' => 'Anton',
        'created_at'      => '2013-09-21',
    ),
    array(
        'jmeno_zakaznika' => 'Antal',
        'created_at'      => '2013-08-28',
    ),
    array(
        'jmeno_zakaznika' => 'Altmann',
        'created_at'      => '2008-05-27',
    ),
    array(
        'jmeno_zakaznika' => 'Ambros',
        'created_at'      => '2009-01-10',
    ),
    array(
        'jmeno_zakaznika' => 'Adamovsky',
        'created_at'      => '2015-01-14',
    ),
    array(
        'jmeno_zakaznika' => 'Adamovska',
        'created_at'      => '2008-02-1',
    ),
    array(
        'jmeno_zakaznika' => 'Ambrosova',
        'created_at'      => '2009-05-4',
    ),
    array(
        'jmeno_zakaznika' => 'Ambroz',
        'created_at'      => '2012-02-25',
    ),
    array(
        'jmeno_zakaznika' => 'Ambrozova',
        'created_at'      => '2009-07-18',
    ),
    array(
        'jmeno_zakaznika' => 'Altmannova',
        'created_at'      => '2016-04-4',
    ),
    array(
        'jmeno_zakaznika' => 'Albl',
        'created_at'      => '2015-08-7',
    ),
    array(
        'jmeno_zakaznika' => 'Alblova',
        'created_at'      => '2016-06-15',
    ),
    array(
        'jmeno_zakaznika' => 'Ales',
        'created_at'      => '2007-02-21',
    ),
    array(
        'jmeno_zakaznika' => 'Alesova',
        'created_at'      => '2008-05-18',
    ),
    array(
        'jmeno_zakaznika' => 'Anders',
        'created_at'      => '2007-09-7',
    ),
    array(
        'jmeno_zakaznika' => 'Ali',
        'created_at'      => '2015-03-8',
    ),
    array(
        'jmeno_zakaznika' => 'Abrham',
        'created_at'      => '2014-02-15',
    ),
    array(
        'jmeno_zakaznika' => 'Abrhamova',
        'created_at'      => '2010-01-16',
    ),
    array(
        'jmeno_zakaznika' => 'Alt',
        'created_at'      => '2007-06-3',
    ),
    array(
        'jmeno_zakaznika' => 'Altova',
        'created_at'      => '2006-01-14',
    ),
    array(
        'jmeno_zakaznika' => 'Adolf',
        'created_at'      => '2008-03-12',
    ),
    array(
        'jmeno_zakaznika' => 'Adamczyk',
        'created_at'      => '2011-02-5',
    ),
    array(
        'jmeno_zakaznika' => 'Andersova',
        'created_at'      => '2006-03-28',
    ),
    array(
        'jmeno_zakaznika' => 'Angelov',
        'created_at'      => '2016-08-27',
    ),
    array(
        'jmeno_zakaznika' => 'Adolfova',
        'created_at'      => '2011-09-12',
    ),
    array(
        'jmeno_zakaznika' => 'Ambrozek',
        'created_at'      => '2009-06-2',
    ),
    array(
        'jmeno_zakaznika' => 'Androva',
        'created_at'      => '2015-03-7',
    ),
    array(
        'jmeno_zakaznika' => 'Andrys',
        'created_at'      => '2012-05-28',
    ),
    array(
        'jmeno_zakaznika' => 'Andrys',
        'created_at'      => '2016-01-26',
    ),
    array(
        'jmeno_zakaznika' => 'Andr',
        'created_at'      => '2006-9-12',
    ),
*/
