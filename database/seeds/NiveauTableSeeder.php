<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use JeroenZwart\CsvSeeder\CsvSeeder;

class NiveauTableSeeder extends CsvSeeder
{
    public function __construct()
    {
        $this->file = '/database/seeds/csv/niveaux.csv';
        $this->tablename = 'niveaux';
        $this->delimiter = ',';
    }


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::disableQueryLog();
        parent::run();
    }
}
