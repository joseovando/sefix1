<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnviosGroupBarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('envios_group_bar', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('mes')->nullable();
            $table->decimal('programado', 10, 0)->nullable();
            $table->decimal('ejecutado', 10, 0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('envios_group_bar');
    }
}
