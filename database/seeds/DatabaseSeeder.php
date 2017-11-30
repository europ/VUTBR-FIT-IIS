<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('LekyTableSeeder');
        // $this->call('DodavateleTableSeeder');
        // $this->call('PobockyTableSeeder');
        // $this->call('PobockyLekyTableSeeder');
        // $this->call('PoistovnyTableSeeder');
        // $this->call('RezervaceTableSeeder');
        // $this->call('PredpisyTableSeeder');
        // $this->call('CenyDodavateluSeeder');
        // $this->call('PredpisyLekySeeder');
        $this->call('ProdaneLekySeeder');
    }
}
