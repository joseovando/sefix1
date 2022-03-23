<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriaLogoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categoria_logo', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('icono')->nullable();
            $table->string('label')->nullable();
            $table->integer('orden')->nullable();
            $table->integer('estado')->nullable();
            $table->integer('id_user')->nullable();
            $table->timestamps();
            $table->string('tamano')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categoria_logo');
    }
}
