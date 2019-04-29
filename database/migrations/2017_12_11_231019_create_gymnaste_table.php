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
            $table->integer('genre_id');
            $table->boolean('competitif')->default('0');
            $table->date('date_naissance');
            $table->String('commentaire');
            $table->integer('user_id')->default('0');
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
