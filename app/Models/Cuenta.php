<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $fecha
 * @property int $tipo_cuenta
 * @property int $tipo_time
 * @property float $monto
 * @property string $detalle
 * @property int $estado
 * @property int $id_user
 * @property string $created_at
 * @property string $updated_at
 */
class Cuenta extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'cuenta';

    /**
     * @var array
     */
    protected $fillable = ['fecha', 'tipo_cuenta', 'tipo_time', 'monto', 'detalle', 'estado', 'id_user', 'created_at', 'updated_at'];
}
