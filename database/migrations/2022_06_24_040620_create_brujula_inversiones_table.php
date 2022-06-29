<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrujulaInversionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brujula_inversiones', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('tipo')->nullable();
            $table->string('cuenta')->nullable();
            $table->integer('ano_inicio')->nullable();
            $table->integer('ano_culminacion')->nullable();
            $table->integer('id_tipo_capital')->nullable();
            $table->decimal('capital', 11)->nullable();
            $table->decimal('porcentaje_interes_anual', 11)->nullable();
            $table->integer('tiene_devolucion_capital')->nullable();
            $table->decimal('coeficiente_crecimiento', 11)->nullable();
            $table->integer('id_user')->nullable();
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
        Schema::dropIfExists('brujula_inversiones');
    }
}
