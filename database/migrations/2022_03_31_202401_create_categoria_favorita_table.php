<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriaFavoritaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categoria_favorita', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_categoria')->nullable();
            $table->integer('orden')->nullable();
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
        Schema::dropIfExists('categoria_favorita');
    }
}
