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
        // $this->call('PobockyTableSeeder');
        // $this->call('PobockyLekyTableSeeder');
        // $this->call('PoistovnyTableSeeder');
        $this->call('DodavateleTableSeeder');
    }
}
