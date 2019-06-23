<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if(env('DB_CONNECTION')!='sqlite') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            // Recommended when importing larger CSVs
            DB::disableQueryLog();

        }



        // $this->call(UsersTableSeeder::class);
        $this->call(NiveauTableSeeder::class);
        $this->call(FiliereTableSeeder::class);
        $this->call(CategorieTableSeeder::class);
        $this->call(GenreTableSeeder::class);
        $this->call(PratiquesTableSeeder::class);
        $this->call(PrivilegesTableSeeder::class);
        $this->call(EquipesTableSeeder::class);
        $this->call(GymnastesTableSeeder::class);
        $this->call(SaisonTableSeeder::class);
        $this->call(JoursTableSeeder::class);
        $this->call(HorairesTableSeeder::class);
        //$this->call(EquipesGymnastesTableSeeder::class);

        if(env('DB_CONNECTION')!='sqlite') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }


    }
}
