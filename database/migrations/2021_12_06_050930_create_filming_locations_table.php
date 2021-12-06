<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilmingLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filming_locations', function (Blueprint $table) {
            $table->id();
            $table->string('annee_tournage');
            $table->double('coord_y');
            $table->double('coord_x');
            $table->string('type_tournage');
            $table->string('nom_producteur');
            $table->string('nom_tournage');
            $table->string('nom_realisateur');
            $table->string('adresse_lieu');
            $table->string('id_lieu');
            $table->string('ardt_lieu');
            $table->string('date_fin');
            $table->string('date_debut');

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
        Schema::dropIfExists('filming_locations');
    }
}
