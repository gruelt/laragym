<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGymnasteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gymnastes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom');
            $table->string('prenom');
            $table->integer('genre_id')->unsigned();
            $table->boolean('competitif')->default('0');
            $table->date('date_naissance');
            $table->String('commentaire')->nullable();
            $table->integer('user_id')->unsigned()->default('0');
            $table->String('photo')->nullable();
            $table->String('certificat_medical')->nullable();
            $table->integer('certificat_medical_check')->default(0);
            $table->date('certificat_medical_date')->nullable();

            $table->timestamps();


            #Fk vers la table genres
            $table->foreign('genre_id')->references('id')->on('genres')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            #Fk vers la table genres
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');


        });





    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gymnastes');
    }
}
