<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateVistaEgresosView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW `vista_egresos` AS select `db_sefix`.`egreso`.`id` AS `id`,`vista_categorias`.`id_padre` AS `id_padre`,`vista_categorias`.`categoria_padre` AS `categoria_padre`,`db_sefix`.`egreso`.`id_categoria` AS `id_categoria`,`vista_categorias`.`categoria` AS `categoria`,`db_sefix`.`egreso`.`detalle` AS `detalle`,`db_sefix`.`egreso`.`monto_programado` AS `monto_programado`,`db_sefix`.`egreso`.`monto_ejecutado` AS `monto_ejecutado`,`db_sefix`.`egreso`.`fecha` AS `fecha`,`db_sefix`.`egreso`.`estado` AS `estado`,`db_sefix`.`egreso`.`id_user` AS `id_user` from (`db_sefix`.`egreso` join `db_sefix`.`vista_categorias` on(`db_sefix`.`egreso`.`id_categoria` = `vista_categorias`.`id`))");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS `vista_egresos`");
    }
}
