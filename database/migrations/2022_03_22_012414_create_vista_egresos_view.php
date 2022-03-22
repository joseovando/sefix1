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
        DB::statement("CREATE VIEW `vista_egresos` AS select `db_sefix`.`egreso`.`id` AS `id`,`vista_categorias`.`id_padre` AS `id_padre`,`vista_categorias`.`categoria_padre` AS `categoria_padre`,`db_sefix`.`egreso`.`id_categoria` AS `id_categoria`,`vista_categorias`.`categoria` AS `categoria`,`db_sefix`.`egreso`.`detalle` AS `detalle`,`db_sefix`.`egreso`.`monto_programado` AS `monto_programado`,`db_sefix`.`egreso`.`monto_ejecutado` AS `monto_ejecutado`,`db_sefix`.`egreso`.`fecha` AS `fecha`,`db_sefix`.`egreso`.`estado` AS `estado`,`db_sefix`.`egreso`.`id_user` AS `id_user`,`db_sefix`.`egreso_setting`.`id_frecuencia` AS `id_frecuencia`,`db_sefix`.`frecuencia`.`frecuencia` AS `frecuencia`,`db_sefix`.`egreso_setting`.`fecha_fin` AS `fecha_fin`,`db_sefix`.`egreso_setting`.`sin_caducidad` AS `sin_caducidad` from (((`db_sefix`.`egreso` join `db_sefix`.`vista_categorias` on(`db_sefix`.`egreso`.`id_categoria` = `vista_categorias`.`id`)) join `db_sefix`.`egreso_setting` on(`db_sefix`.`egreso`.`id` = `db_sefix`.`egreso_setting`.`id_egreso`)) join `db_sefix`.`frecuencia` on(`db_sefix`.`egreso_setting`.`id_frecuencia` = `db_sefix`.`frecuencia`.`id`))");
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
