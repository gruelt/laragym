<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use JeroenZwart\CsvSeeder\CsvSeeder;

class SaisonTableSeeder extends  CsvSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

        public function __construct()
            {
                $this->file = '/database/seeds/csv/saisons.csv';
                $this->tablename = 'saisons';
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
