<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetitifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

        public function up()
        {
            Schema::create('competitifs', function (Blueprint $table) {
                $table->increments('id');
                $table->string('nom');

                $table->integer('categorie_id')->unsigned();
                $table->integer('niveau_id')->unsigned();
                $table->integer('genre_id')->unsigned();
                $table->integer('individuel')->default(0);
                $table->integer('saison_id')->default(0);


                $table->foreign('categorie_id', 'cat_com_fk')->references('id')->on('categories')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');

                $table->foreign('niveau_id', 'niv_com_fk')->references('id')->on('niveaux')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');

                $table->foreign('genre_id', 'gen_com_fk')->references('id')->on('genres')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');

                $table->foreign('saison_id', 'sai_com_fk')->references('id')->on('saisons')
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
        Schema::dropIfExists('competitifs');
    }
}
