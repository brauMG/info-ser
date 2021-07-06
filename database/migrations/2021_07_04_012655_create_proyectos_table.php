<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyectos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_compania');
            $table->string('descripcion', 150);
            $table->bigInteger('id_gerencia');
            $table->bigInteger('id_area');
            $table->bigInteger('id_fase');
            $table->bigInteger('id_enfoque');
            $table->bigInteger('id_trabajo');
            $table->bigInteger('id_indicador');
            $table->string('objetivo', 500);
            $table->dateTime('fecha_creacion');
            $table->tinyInteger('activo');
            $table->bigInteger('id_estado');
            $table->string('criterio', 500);
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
        Schema::dropIfExists('proyectos');
    }
}
