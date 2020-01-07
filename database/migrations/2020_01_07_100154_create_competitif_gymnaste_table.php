<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetitifGymnasteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competitif_gymnaste', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('individuel')->default(0);

            $table->integer('gymnaste_id')->unsigned();
            $table->integer('competitif_id')->unsigned();




            $table->timestamps();

            #Fk vers la table gymnastes
            $table->foreign('gymnaste_id')->references('id')->on('gymnastes')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            #Fk vers la table privileges
            $table->foreign('competitif_id')->references('id')->on('competitifs')
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
        Schema::dropIfExists('competitif_gymnaste');
    }
}
