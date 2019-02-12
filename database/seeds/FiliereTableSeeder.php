<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use JeroenZwart\CsvSeeder\CsvSeeder;

class FiliereTableSeeder extends CsvSeeder
{
    public function __construct()
    {
        $this->file = '/database/seeds/csv/filieres.csv';
        $this->tablename = 'filieres';
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