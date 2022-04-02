<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEgresoProgramadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('egreso_programado', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_categoria')->nullable();
            $table->string('detalle')->nullable();
            $table->decimal('monto_programado', 10)->nullable();
            $table->integer('id_frecuencia')->nullable();
            $table->integer('sin_caducidad')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->date('fecha_promedio')->nullable();
            $table->integer('estado')->nullable();
            $table->integer('id_user')->nullable();
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
        Schema::dropIfExists('egreso_programado');
    }
}
