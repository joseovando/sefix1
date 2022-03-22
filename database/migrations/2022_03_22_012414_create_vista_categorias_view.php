<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateVistaCategoriasView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW `vista_categorias` AS select `db_sefix`.`categoria`.`tipo` AS `tipo`,`db_sefix`.`categoria_tipo`.`tipo_categoria` AS `tipo_categoria`,`db_sefix`.`categoria_tipo`.`orden` AS `tipo_orden`,`db_sefix`.`categoria`.`id_padre` AS `id_padre`,`vista_categoria_padres`.`categoria` AS `categoria_padre`,`vista_categoria_padres`.`orden` AS `orden_padre`,`db_sefix`.`categoria`.`id` AS `id`,`db_sefix`.`categoria`.`categoria` AS `categoria`,`db_sefix`.`categoria`.`orden` AS `orden`,`db_sefix`.`categoria`.`icono` AS `icono`,`db_sefix`.`categoria`.`fondo` AS `fondo`,`db_sefix`.`categoria`.`plantilla` AS `plantilla`,`db_sefix`.`categoria`.`estado` AS `estado`,`db_sefix`.`categoria`.`id_user` AS `id_user`,`db_sefix`.`categoria`.`created_at` AS `created_at`,`db_sefix`.`categoria`.`updated_at` AS `updated_at` from ((`db_sefix`.`categoria` join `db_sefix`.`vista_categoria_padres` on(`db_sefix`.`categoria`.`id_padre` = `vista_categoria_padres`.`id`)) join `db_sefix`.`categoria_tipo` on(`db_sefix`.`categoria`.`tipo` = `db_sefix`.`categoria_tipo`.`id`))");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS `vista_categorias`");
    }
}
