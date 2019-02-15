<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use JeroenZwart\CsvSeeder\CsvSeeder;

class EquipesGymnastesTableSeeder extends CsvSeeder
{
    public function __construct()
    {
        $this->file = '/database/seeds/csv/equipe_gymnaste.csv';
        $this->tablename = 'equipe_gymnaste';
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
