<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_user
 * @property string $fecha_nacimiento
 * @property int $id_pais
 * @property int $estado
 * @property string $created_at
 * @property string $updated_at
 */
class UsersSpecific extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'users_specific';

    /**
     * @var array
     */
    protected $fillable = ['id_user', 'fecha_nacimiento', 'id_pais', 'estado', 'created_at', 'updated_at'];
}
