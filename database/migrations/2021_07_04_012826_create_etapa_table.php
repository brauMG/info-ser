<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEtapaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etapas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_proyecto');
            $table->bigInteger('id_fase');
            $table->string('descripcion');
            $table->date('fecha_vencimiento');
            $table->time('hora_vencimiento');
            $table->bigInteger('id_compania');
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
        Schema::dropIfExists('etapas');
    }
}
