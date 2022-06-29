<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categoria', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('categoria')->nullable();
            $table->integer('id_padre')->nullable();
            $table->integer('orden')->nullable();
            $table->string('icono')->nullable();
            $table->string('fondo')->nullable();
            $table->integer('plantilla')->nullable();
            $table->integer('estado')->nullable();
            $table->integer('id_user')->nullable();
            $table->timestamps();
            $table->integer('tipo')->nullable();
            $table->integer('comercial')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categoria');
    }
}
