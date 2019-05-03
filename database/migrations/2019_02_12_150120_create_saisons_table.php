<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaisonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saisons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom');
            $table->integer('an1');
            $table->integer('an2');
            $table->integer('actuelle')->comment('saison en cours =1');
            $table->integer('inscription')->comment('inscription ouverte =1 , fermé =0');

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
        Schema::dropIfExists('saisons');
    }
}
