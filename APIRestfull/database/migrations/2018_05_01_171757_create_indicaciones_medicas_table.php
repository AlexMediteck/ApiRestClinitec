<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndicacionesMedicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indicaciones_medicas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Dieta');
            $table->string('Esquema_soluciones');
            $table->string('Lista_medicamentos');
            $table->integer('Medias_generales');
            $table->string('Hemocomponentes')->nullable();
            $table->integer('idConsulta')->unsigned();
            $table->integer('idCentro_medico')->unsigned();
            $table->integer('Estado')->unsigned();

            //Llaves foraneas
            $table->foreign('idConsulta')->references('id')->on('consultas');
            $table->foreign('idCentro_medico')->references('id')->on('centro_medico');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('indicaciones_medicas');
    }
}