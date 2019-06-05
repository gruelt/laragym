<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGymnasteSaisonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gymnaste_saison', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('gymnaste_id')->unsigned();
            $table->integer('saison_id')->unsigned();

            $table->integer('prix')->default(0);
            $table->integer('paye')->default(0);
            $table->integer('paye_tresorier')->default(0);
            $table->integer('complet')->default(0);
            $table->integer('affiligue')->default(0);


            $table->timestamps();

            #Fk vers la table use
            $table->foreign('gymnaste_id')->references('id')->on('gymnastes')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            #Fk vers la table privileges
            $table->foreign('saison_id')->references('id')->on('saisons')
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
        Schema::dropIfExists('gymnaste_saison');
    }
}
