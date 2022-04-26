<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateVistaCuentasView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW `vista_cuentas` AS select `db_sefix`.`cuenta`.`id` AS `id`,`db_sefix`.`cuenta`.`fecha` AS `fecha`,`db_sefix`.`cuenta`.`tipo_cuenta` AS `id_tipo_cuenta`,`db_sefix`.`cuenta_tipo`.`tipo_categoria` AS `tipo_cuenta`,`db_sefix`.`cuenta`.`tipo_time` AS `id_tipo_time`,`db_sefix`.`cuenta_time`.`tipo_categoria` AS `tipo_time`,`db_sefix`.`cuenta`.`monto` AS `monto`,`db_sefix`.`cuenta`.`detalle` AS `detalle`,`db_sefix`.`cuenta`.`estado` AS `estado`,`db_sefix`.`cuenta`.`id_user` AS `id_user`,`db_sefix`.`cuenta`.`created_at` AS `created_at`,`db_sefix`.`cuenta`.`updated_at` AS `updated_at` from ((`db_sefix`.`cuenta` join `db_sefix`.`cuenta_tipo` on(`db_sefix`.`cuenta`.`tipo_cuenta` = `db_sefix`.`cuenta_tipo`.`id`)) join `db_sefix`.`cuenta_time` on(`db_sefix`.`cuenta`.`tipo_time` = `db_sefix`.`cuenta_time`.`id`))");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS `vista_cuentas`");
    }
}
