<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDossierAffiligueToGymnasteSaisonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gymnaste_saison', function (Blueprint $table) {
            $table->integer('dossier')->unsigned()->default(0);


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gymnaste_saison', function (Blueprint $table) {
            $table->dropColumn('dossier');

        });
    }
}
