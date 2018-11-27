<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->integer('age_min');
            $table->integer('age_max');
            $table->integer('filiere_id')->unsigned();
            $table->timestamps();

            $table->foreign('filiere_id','cat_fil_fk')->references('id')->on('filieres')
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
        Schema::dropIfExists('categories');
    }
}
