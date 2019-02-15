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
        // $this->call(UsersTableSeeder::class);
        $this->call(NiveauTableSeeder::class);
        $this->call(FiliereTableSeeder::class);
        $this->call(CategorieTableSeeder::class);
        $this->call(GenreTableSeeder::class);
        $this->call(PratiquesTableSeeder::class);
        $this->call(PrivilegesTableSeeder::class);
        $this->call(GymnastesTableSeeder::class);
        $this->call(EquipesTableSeeder::class);
    }
}
