<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateVistaBrujulaCorrientesView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW `vista_brujula_corrientes` AS select `db_sefix`.`brujula_corriente`.`id` AS `id`,`db_sefix`.`brujula_corriente`.`tipo` AS `tipo`,`db_sefix`.`brujula_corriente`.`id_categoria` AS `id_categoria`,`vista_categoria_padres`.`categoria` AS `categoria`,`db_sefix`.`brujula_corriente`.`cuenta` AS `cuenta`,`db_sefix`.`brujula_corriente`.`ano_inicio` AS `ano_inicio`,`db_sefix`.`brujula_corriente`.`ano_culminacion` AS `ano_culminacion`,`db_sefix`.`brujula_corriente`.`id_tipo_monto` AS `id_tipo_monto`,`db_sefix`.`brujula_corriente`.`monto` AS `monto`,`db_sefix`.`brujula_corriente`.`coeficiente_crecimiento` AS `coeficiente_crecimiento`,`db_sefix`.`brujula_corriente`.`id_user` AS `id_user`,`db_sefix`.`brujula_corriente`.`estado` AS `estado`,`db_sefix`.`brujula_corriente`.`version` AS `version` from (`db_sefix`.`brujula_corriente` join `db_sefix`.`vista_categoria_padres` on(`db_sefix`.`brujula_corriente`.`id_categoria` = `vista_categoria_padres`.`id`))");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS `vista_brujula_corrientes`");
    }
}
