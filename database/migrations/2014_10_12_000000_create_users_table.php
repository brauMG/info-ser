<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_compania');
            $table->string('iniciales', 10);
            $table->string('nombres', 150);
            $table->bigInteger('id_area')->nullable();
            $table->bigInteger('id_puesto')->nullable();
            $table->bigInteger('id_rol');
            $table->dateTime('ultima_sesion')->nullable();
            $table->dateTime('fecha_creacion');
            $table->tinyInteger('activo');
            $table->string('password', 250);
            $table->string('email', 250)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('envio_de_correo');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
