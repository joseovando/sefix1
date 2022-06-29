<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrujulaCoeficienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brujula_coeficiente', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_coeficiente')->nullable();
            $table->integer('orden')->nullable();
            $table->integer('id_valor_calculo')->nullable();
            $table->decimal('valor_sistema', 11)->nullable();
            $table->decimal('valor_usuario', 11)->nullable();
            $table->text('informacion_adicional')->nullable();
            $table->integer('id_usuario')->nullable();
            $table->integer('estado')->nullable();
            $table->integer('version')->nullable();
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
        Schema::dropIfExists('brujula_coeficiente');
    }
}
