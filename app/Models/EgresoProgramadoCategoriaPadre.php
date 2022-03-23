<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_categoria
 * @property string $detalle
 * @property float $monto_programado
 * @property int $id_frecuencia
 * @property int $sin_caducidad
 * @property string $fecha_inicio
 * @property string $fecha_fin
 * @property string $fecha_promedio
 * @property int $estado
 * @property int $id_user
 * @property string $created_at
 * @property string $updated_at
 */
class EgresoProgramadoCategoriaPadre extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'egreso_programado_categoria_padre';

    /**
     * @var array
     */
    protected $fillable = ['id_categoria', 'detalle', 'monto_programado', 'id_frecuencia', 'sin_caducidad', 'fecha_inicio', 'fecha_fin', 'fecha_promedio', 'estado', 'id_user', 'created_at', 'updated_at'];
}
