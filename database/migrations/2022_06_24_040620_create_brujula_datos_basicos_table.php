<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrujulaDatosBasicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brujula_datos_basicos', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_user')->nullable();
            $table->integer('renta_jubilacion')->nullable();
            $table->integer('ano_renta_jubilacion')->nullable();
            $table->decimal('porcentaje_renta_jubilacion', 10)->nullable();
            $table->integer('expectativa_vida')->nullable();
            $table->integer('tiene_conyuge')->nullable();
            $table->date('fecha_nacimiento_conyuge')->nullable();
            $table->integer('renta_jubilacion_conyuge')->nullable();
            $table->integer('ano_renta_jubilacion_conyuge')->nullable();
            $table->decimal('porcentaje_renta_jubilacion_conyuge', 10)->nullable();
            $table->integer('estado')->nullable();
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
        Schema::dropIfExists('brujula_datos_basicos');
    }
}
