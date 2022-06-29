<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateVistaCategoriaFavoritasView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW `vista_categoria_favoritas` AS select `db_sefix`.`categoria`.`id` AS `id`,`db_sefix`.`categoria`.`categoria` AS `categoria`,`db_sefix`.`categoria`.`id_padre` AS `id_padre`,`db_sefix`.`categoria_favorita`.`orden` AS `orden`,`db_sefix`.`categoria`.`icono` AS `icono`,`db_sefix`.`categoria`.`fondo` AS `fondo`,`db_sefix`.`categoria`.`plantilla` AS `plantilla`,`db_sefix`.`categoria`.`tipo` AS `tipo`,`db_sefix`.`categoria`.`comercial` AS `comercial`,`db_sefix`.`categoria_favorita`.`id` AS `id_favorita`,`db_sefix`.`categoria_favorita`.`id_user` AS `id_user`,`db_sefix`.`categoria_favorita`.`estado` AS `estado` from (`db_sefix`.`categoria_favorita` join `db_sefix`.`categoria` on(`db_sefix`.`categoria_favorita`.`id_categoria` = `db_sefix`.`categoria`.`id`))");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS `vista_categoria_favoritas`");
    }
}
