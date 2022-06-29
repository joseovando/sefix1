<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateVistaUserRolView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW `vista_user_rol` AS select `db_sefix`.`users`.`id` AS `user_id`,`db_sefix`.`users`.`name` AS `user_name`,`db_sefix`.`users`.`email` AS `user_mail`,`db_sefix`.`roles`.`id` AS `rol_id`,`db_sefix`.`roles`.`name` AS `rol_name`,`db_sefix`.`roles`.`guard_name` AS `rol_guard_name` from ((`db_sefix`.`users` join `db_sefix`.`model_has_roles` on(`db_sefix`.`users`.`id` = `db_sefix`.`model_has_roles`.`model_id`)) join `db_sefix`.`roles` on(`db_sefix`.`model_has_roles`.`role_id` = `db_sefix`.`roles`.`id`))");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS `vista_user_rol`");
    }
}
