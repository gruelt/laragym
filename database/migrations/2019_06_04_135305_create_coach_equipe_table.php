<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoachEquipeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coach_equipe', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('equipe_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->timestamps();

            #Fk vers la table use
            $table->foreign('equipe_id')->references('id')->on('equipes')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            #Fk vers la table privileges
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
        Schema::dropIfExists('coach_equipe');
    }
}
