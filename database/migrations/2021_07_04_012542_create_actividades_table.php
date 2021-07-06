<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActividadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actividades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_compania');
            $table->bigInteger('id_proyecto');
            $table->string('descricion', 500);
            $table->bigInteger('id_usuario');
            $table->bigInteger('id_fase');
            $table->bigInteger('id_etapa');
            $table->date('fecha_vencimiento');
            $table->time('hora_vencimiento');
            $table->integer('estado');
            $table->date('fecha_revision')->nullable();
            $table->time('hora_revision')->nullable();
            $table->date('fecha_creacion')->nullable();
            $table->string('decision', 500);
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
        Schema::dropIfExists('actividades');
    }
}
