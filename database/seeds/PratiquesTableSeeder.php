<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use JeroenZwart\CsvSeeder\CsvSeeder;

class PratiquesTableSeeder extends CsvSeeder
{
    public function __construct()
    {
        $this->file = '/database/seeds/csv/pratiques.csv';
        $this->tablename = 'pratiques';
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
