<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSponsorsCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patrocinadores_companias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_patrocinador');
            $table->foreign('id_patrocinador')->references('id')->on('patrocinadores');
            $table->unsignedBigInteger('id_compania');
            $table->foreign('id_compania')->references('id')->on('companias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patrocinadores_companias');
    }
}
