<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesProyectosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles_proyectos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_proyecto');
            $table->bigInteger('id_fase');
            $table->string('id_rol_rasic', 10);
            $table->bigInteger('id_usuario');
            $table->dateTime('fecha_creacion');
            $table->tinyInteger('activo');
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
        Schema::dropIfExists('roles_proyectos');
    }
}
