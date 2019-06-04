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


        //User par défaut
        DB::table('users')->insert([
            'id' => 1 ,
            'name' => 'gruel',
            'email' => 'gruelt@gmail.com',
            'password' => '$2y$10$14TsjoIX9WnHpjhzAQMYfeaN532g0gfe3oMJzCV1QQc6te26UYJtW',
            'nom' => 'GRUEL',
            'prenom' => 'Thomas',
            'adresse' => '1 rue du mont',
            'cp' => '42160',
            'ville' => 'Bonson',
            'complete' => 1,
            'email_verified_at' => '2019-04-29 09:35:39',
            'telephone1' => '0661468315',
            'telephone2' => '0675870751'
            
            
        ]);

        //User par défaut
        DB::table('users')->insert([
            'id' => 0 ,
            'name' => 'FJEP',
            'email' => 'gruelt+fjep@gmail.com',
            'password' => '$2y$10$14TsjoIX9WnHpjhzAQMYfeaN532g0gfe3oMJzCV1QQc6te26UYJtW',
            'nom' => 'FJEP',
            'prenom' => 'Gymnastique',
            'adresse' => '1 rue du mont',
            'cp' => '42160',
            'ville' => 'St Just St Rambert',
            'complete' => 1,
            'email_verified_at' => '2019-04-29 09:35:39',
            'telephone1' => '0661468315',
            'telephone2' => '0675870751'


        ]);

        //User par défaut
        DB::table('users')->insert([
            'id' => 3 ,
            'name' => 'Pradier',
            'email' => 'luc.pradier@club-internet.fr',
            'password' => '$2y$10$oYSK/.R/hXycoSVgskXSA.IMf2S/zkzkhAVe/Zn/V.H4SZPNRCL2S',
            'nom' => 'Pradier',
            'prenom' => 'Luc',
            'adresse' => '97 impasse des lagunes',
            'cp' => '42380',
            'ville' => 'Luriecq',
            'complete' => 1,
            'email_verified_at' => '2019-06-03 09:35:39',
            'telephone1' => '683313821',
            'telephone2' => '688545203'


        ]);

        DB::table('privileges_user')->insert([
            'id' => 5,
            'user_id' => 3,
            'privileges_id' => 1
        ]);


        DB::table('privileges_user')->insert([
            'id' => 1,
            'user_id' => 1,
            'privileges_id' => 1
        ]);

        DB::table('privileges_user')->insert([
            'id' => 2,
            'user_id' => 1,
            'privileges_id' => 2
        ]);

        DB::table('privileges_user')->insert([
            'id' => 3,
            'user_id' => 1,
            'privileges_id' => 5
        ]);

        DB::table('privileges_user')->insert([
            'id' => 4,
            'user_id' => 1,
            'privileges_id' => 6
        ]);


    }
}
