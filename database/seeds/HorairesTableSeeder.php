<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use JeroenZwart\CsvSeeder\CsvSeeder;
use App\Horaire;

class HorairesTableSeeder extends  CsvSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

        public function __construct()
            {
                $this->file = '/database/seeds/csv/horaires.csv';
                $this->tablename = 'horaires';
                $this->delimiter = ',';
            }


                /**
                 * Run the database seeds.
                 *
                 * @return void
                 */
                public function run()
            {
                Horaire::truncate();
                DB::disableQueryLog();
                parent::run();
            }

}
