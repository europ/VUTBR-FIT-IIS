<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;


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
                'jmeno_zakaznika' => 'Maly Princ',
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            array(
                'jmeno_zakaznika' => 'Paul Baumer',
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            array(
                'jmeno_zakaznika' => 'Hamlet Dansky',
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            array(
                'jmeno_zakaznika' => 'Pavel Herout',
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            array(
                'jmeno_zakaznika' => 'Anna Karenina',
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            array(
                'jmeno_zakaznika' => 'Marina Sladkovicova',
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            array(
                'jmeno_zakaznika' => 'Juraj Janosik',
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            array(
                'jmeno_zakaznika' => 'Pacho Hybsky',
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            array(
                'jmeno_zakaznika' => 'Holden Claufield',
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            array(
                'jmeno_zakaznika' => 'Maco Mliec',
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            array(
                'jmeno_zakaznika' => 'Adamek',
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            array(
                'jmeno_zakaznika' => 'Adamcova',
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            array(
                'jmeno_zakaznika' => 'Adamec',
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            array(
                'jmeno_zakaznika' => 'Adam',
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            array(
                'jmeno_zakaznika' => 'Adamova',
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            array(
                'jmeno_zakaznika' => 'Andel',
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            array(
                'jmeno_zakaznika' => 'Andelova',
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            array(
                'jmeno_zakaznika' => 'Andrlova',
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            array(
                'jmeno_zakaznika' => 'Andrle',
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            array(
                'jmeno_zakaznika' => 'Albrecht',
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            array(
                'jmeno_zakaznika' => 'Albrechtova',
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            array(
                'jmeno_zakaznika' => 'Ambroz',
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            array(
                'jmeno_zakaznika' => 'Ambrozova',
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            ),

    	));
    }
}


