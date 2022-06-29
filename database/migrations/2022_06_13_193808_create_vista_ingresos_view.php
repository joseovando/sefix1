<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateVistaIngresosView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW `vista_ingresos` AS select `db_sefix`.`ingreso`.`id` AS `id`,`vista_categorias`.`id_padre` AS `id_padre`,`vista_categorias`.`categoria_padre` AS `categoria_padre`,`db_sefix`.`ingreso`.`id_categoria` AS `id_categoria`,`vista_categorias`.`categoria` AS `categoria`,`db_sefix`.`ingreso`.`detalle` AS `detalle`,`db_sefix`.`ingreso`.`monto_programado` AS `monto_programado`,`db_sefix`.`ingreso`.`monto_ejecutado` AS `monto_ejecutado`,`db_sefix`.`ingreso`.`fecha` AS `fecha`,`db_sefix`.`ingreso`.`estado` AS `estado`,`db_sefix`.`ingreso`.`id_user` AS `id_user`,`vista_categorias`.`comercial` AS `comercial` from (`db_sefix`.`ingreso` join `db_sefix`.`vista_categorias` on(`db_sefix`.`ingreso`.`id_categoria` = `vista_categorias`.`id`))");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS `vista_ingresos`");
    }
}
