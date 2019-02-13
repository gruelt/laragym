<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class PrivilegesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Permet de vider les affectations
        Model::unguard();
        //DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        //DB::table('privileges')->truncate();
        //DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Model::reguard();

        //Ajout des droits de base

        DB::table('privileges')->insert([
            'id' => 1,
            'name' => 'admin',
            'description' => 'Administrateur, peut tout faire.' ,
        ]);

        DB::table('privileges')->insert([
            'id' => 2,
            'name' => 'manager',
            'description' => 'Gestionnaire ' ,
        ]);

        DB::table('privileges')->insert([
            'id' => 3,
            'name' => 'user',
            'description' => 'Utilisateur' ,
        ]);

        DB::table('privileges')->insert([
            'id' => 4,
            'name' => 'guest',
            'description' => 'Invite' ,
        ]);

        DB::table('privileges')->insert([
            'id' => 5,
            'name' => 'coach',
            'description' => 'Entraineur' ,
        ]);

        DB::table('privileges')->insert([
            'id' => 6,
            'name' => 'judge',
            'description' => 'Juge' ,
        ]);


    }
}
