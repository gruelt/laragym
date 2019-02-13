<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Nom');

            $table->integer('categorie_id')->unsigned();
            $table->integer('niveau_id')->unsigned();
            $table->integer('genre_id')->unsigned();
            $table->integer('individuel')->default(0);


            $table->foreign('categorie_id','cat_equ_fk')->references('id')->on('categories')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('niveau_id','niv_equ_fk')->references('id')->on('niveaux')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('genre_id','gen_equ_fk')->references('id')->on('genres')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->timestamps();



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipes');
    }
}
