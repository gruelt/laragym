<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use JeroenZwart\CsvSeeder\CsvSeeder;

class JoursTableSeeder extends  CsvSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

        public function __construct()
            {
                $this->file = '/database/seeds/csv/jours.csv';
                $this->tablename = 'jours';
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
