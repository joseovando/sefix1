<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateVistaUsersSpecificView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW `vista_users_specific` AS select `db_sefix`.`users`.`id` AS `id`,`db_sefix`.`users`.`name` AS `name`,`db_sefix`.`users_specific`.`estado` AS `estado`,`db_sefix`.`users_specific`.`id_pais` AS `id_pais`,`db_sefix`.`paises`.`nombre_pais` AS `nombre_pais`,`db_sefix`.`users_specific`.`fecha_nacimiento` AS `fecha_nacimiento`,`db_sefix`.`users_specific`.`id` AS `id_users_specific` from ((`db_sefix`.`users` join `db_sefix`.`users_specific` on(`db_sefix`.`users`.`id` = `db_sefix`.`users_specific`.`id_user`)) join `db_sefix`.`paises` on(`db_sefix`.`users_specific`.`id_pais` = `db_sefix`.`paises`.`id`))");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS `vista_users_specific`");
    }
}
