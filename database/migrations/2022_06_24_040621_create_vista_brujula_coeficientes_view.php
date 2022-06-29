<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateVistaBrujulaCoeficientesView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW `vista_brujula_coeficientes` AS select `db_sefix`.`brujula_coeficiente`.`id` AS `id`,`db_sefix`.`brujula_coeficiente`.`id_coeficiente` AS `id_coeficiente`,`db_sefix`.`brujula_coeficiente`.`orden` AS `orden`,`vista_categoria_padres`.`categoria` AS `categoria`,`vista_categoria_padres`.`tipo` AS `tipo`,`vista_categoria_padres`.`tipo_categoria` AS `tipo_categoria`,`vista_categoria_padres`.`comercial` AS `comercial`,`db_sefix`.`brujula_coeficiente`.`id_valor_calculo` AS `id_valor_calculo`,`db_sefix`.`brujula_coeficiente`.`valor_sistema` AS `valor_sistema`,`db_sefix`.`brujula_coeficiente`.`valor_usuario` AS `valor_usuario`,`db_sefix`.`brujula_coeficiente`.`informacion_adicional` AS `informacion_adicional`,`db_sefix`.`brujula_coeficiente`.`id_usuario` AS `id_usuario`,`db_sefix`.`brujula_coeficiente`.`estado` AS `estado`,`db_sefix`.`brujula_coeficiente`.`version` AS `version` from (`db_sefix`.`brujula_coeficiente` join `db_sefix`.`vista_categoria_padres` on(`db_sefix`.`brujula_coeficiente`.`id_coeficiente` = `vista_categoria_padres`.`id`))");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS `vista_brujula_coeficientes`");
    }
}
