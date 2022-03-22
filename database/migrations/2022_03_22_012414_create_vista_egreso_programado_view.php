<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateVistaEgresoProgramadoView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW `vista_egreso_programado` AS select `db_sefix`.`egreso_programado`.`id` AS `id`,`vista_categorias`.`tipo` AS `tipo`,`vista_categorias`.`tipo_categoria` AS `tipo_categoria`,`vista_categorias`.`tipo_orden` AS `tipo_orden`,`vista_categorias`.`id_padre` AS `id_padre`,`vista_categorias`.`categoria_padre` AS `categoria_padre`,`vista_categorias`.`orden_padre` AS `orden_padre`,`vista_categorias`.`id` AS `id_catgoria`,`vista_categorias`.`categoria` AS `categoria`,`vista_categorias`.`orden` AS `orden_categoria`,`vista_categorias`.`icono` AS `icono`,`vista_categorias`.`fondo` AS `fondo`,`vista_categorias`.`plantilla` AS `plantilla`,`vista_categorias`.`estado` AS `estado_categoria`,`vista_categorias`.`id_user` AS `id_user_categoria`,`db_sefix`.`egreso_programado`.`detalle` AS `detalle`,`db_sefix`.`egreso_programado`.`monto_programado` AS `monto_programado`,`db_sefix`.`egreso_programado`.`id_frecuencia` AS `id_frecuencia`,`db_sefix`.`frecuencia`.`frecuencia` AS `frecuencia`,`db_sefix`.`frecuencia`.`orden` AS `orden_frecuencia`,`db_sefix`.`frecuencia`.`estado` AS `estado_frecuencia`,`db_sefix`.`egreso_programado`.`sin_caducidad` AS `sin_caducidad`,`db_sefix`.`egreso_programado`.`fecha_inicio` AS `fecha_inicio`,`db_sefix`.`egreso_programado`.`fecha_fin` AS `fecha_fin`,`db_sefix`.`egreso_programado`.`estado` AS `estado_egreso_programado`,`db_sefix`.`egreso_programado`.`id_user` AS `id_user_egreso_programado` from ((`db_sefix`.`egreso_programado` join `db_sefix`.`frecuencia` on(`db_sefix`.`egreso_programado`.`id_frecuencia` = `db_sefix`.`frecuencia`.`id`)) join `db_sefix`.`vista_categorias` on(`db_sefix`.`egreso_programado`.`id_categoria` = `vista_categorias`.`id`))");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS `vista_egreso_programado`");
    }
}
