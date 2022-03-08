<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_categoria
 * @property string $detalle
 * @property float $monto_programado
 * @property float $monto_ejecutado
 * @property string $fecha
 * @property int $estado
 * @property int $id_user
 * @property string $created_at
 * @property string $updated_at
 */
class /Models/Egreso extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'egreso';

    /**
     * @var array
     */
    protected $fillable = ['id_categoria', 'detalle', 'monto_programado', 'monto_ejecutado', 'fecha', 'estado', 'id_user', 'created_at', 'updated_at'];
}
