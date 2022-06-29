<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $tipo
 * @property int $id_categoria
 * @property string $cuenta
 * @property int $ano_inicio
 * @property int $ano_culminacion
 * @property int $id_tipo_monto
 * @property float $monto
 * @property float $coeficiente_crecimiento
 * @property int $id_user
 * @property int $estado
 * @property int $version
 * @property string $created_at
 * @property string $updated_at
 */
class BrujulaCorriente extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'brujula_corriente';

    /**
     * @var array
     */
    protected $fillable = ['tipo', 'id_categoria', 'cuenta', 'ano_inicio', 'ano_culminacion', 'id_tipo_monto', 'monto', 'coeficiente_crecimiento', 'id_user', 'estado', 'version', 'created_at', 'updated_at'];
}
