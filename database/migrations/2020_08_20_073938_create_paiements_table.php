<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaiementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->integer('montant');
            $table->integer('responsable_id')->unsigned();
            $table->integer('operateur_id')->unsigned();
            $table->integer('saison_id')->unsigned();
            $table->string('commentaire');
            $table->boolean('valide_tresorier')->default(false);
            $table->timestamps();

            #Fk vers la table users (responsable)
            $table->foreign('responsable_id')->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            #Fk vers la table users (operateur ayant enregistré)
            $table->foreign('operateur_id')->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            #Fk vers la table saison
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
        Schema::dropIfExists('paiements');
    }
}
