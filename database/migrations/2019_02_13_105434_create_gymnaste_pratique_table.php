<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGymnastePratiqueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gymnaste_pratique', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('gymnaste_id')->unsigned();
            $table->integer('pratique_id')->unsigned();


            $table->timestamps();

            #Fk vers la table users
            $table->foreign('gymnaste_id')->references('id')->on('gymnastes')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            #Fk vers la table privileges
            $table->foreign('pratique_id')->references('id')->on('pratiques')
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
        Schema::dropIfExists('gymnaste_pratique');
    }
}
