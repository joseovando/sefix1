<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_ingreso
 * @property int $id_frecuencia
 * @property string $fecha_inicio
 * @property string $fecha_fin
 * @property int $sin_caducidad
 * @property int $estado
 * @property int $id_user
 * @property string $created_at
 * @property string $updated_at
 */
class /Models/IngresoSetting extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'ingreso_setting';

    /**
     * @var array
     */
    protected $fillable = ['id_ingreso', 'id_frecuencia', 'fecha_inicio', 'fecha_fin', 'sin_caducidad', 'estado', 'id_user', 'created_at', 'updated_at'];
}