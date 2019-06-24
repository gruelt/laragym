<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHorairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horaires', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('jour_id')->unsigned();
            $table->integer('heure_debut');
            $table->integer('minute_debut');
            $table->integer('heure_fin');
            $table->integer('minute_fin');
            $table->integer('equipe_id')->unsigned();
            $table->timestamps();


            #Fk vers la table equipes
            $table->foreign('equipe_id')->references('id')->on('equipes')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            #Fk vers la table jours
            $table->foreign('jour_id')->references('id')->on('jours')
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
        Schema::dropIfExists('horaires');
    }
}
