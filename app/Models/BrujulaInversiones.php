<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $tipo
 * @property string $cuenta
 * @property int $ano_inicio
 * @property int $ano_culminacion
 * @property int $id_tipo_capital
 * @property float $capital
 * @property float $porcentaje_interes_anual
 * @property int $tiene_devolucion_capital
 * @property float $coeficiente_crecimiento
 * @property int $id_user
 * @property int $estado
 * @property int $version
 * @property string $created_at
 * @property string $updated_at
 */
class BrujulaInversiones extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'brujula_inversiones';

    /**
     * @var array
     */
    protected $fillable = ['tipo', 'cuenta', 'ano_inicio', 'ano_culminacion', 'id_tipo_capital', 'capital', 'porcentaje_interes_anual', 'tiene_devolucion_capital', 'coeficiente_crecimiento', 'id_user', 'estado', 'version', 'created_at', 'updated_at'];
}
