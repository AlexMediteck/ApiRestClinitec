<?php

use App\Notas;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Tipo_nota');
            $table->text('Diagnostico');
            $table->integer('Peso');
            $table->integer('Talla');
            $table->string('IMC');
            $table->string('SC');
            $table->string('SVT');
            $table->string('FC');
            $table->string('TR');
            $table->string('Temperatura');
            $table->string('TA');
            $table->string('S02');
            $table->text('Nota');
            $table->text('Pronostico');
            $table->integer('idPaciente')->unsigned();
            $table->integer('idMedico')->unsigned();
            $table->integer('idCentro_medico')->unsigned();
            $table->integer('Estado')->unsigned()->default(Notas::ACTIVO);

            $table->foreign('idPaciente')->references('id')->on('pacientes');
            $table->foreign('idMedico')->references('id')->on('tipo_usuario');
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
        Schema::dropIfExists('notas');
    }
}
