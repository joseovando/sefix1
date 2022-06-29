<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_coeficiente
 * @property int $id_valor_calculo
 * @property float $valor_sistema
 * @property float $valor_usuario
 * @property string $informacion_adicional
 * @property int $id_usuario
 * @property int $estado
 * @property int $version
 * @property string $created_at
 * @property string $updated_at
 */
class BrujulaCoeficiente extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'brujula_coeficiente';

    /**
     * @var array
     */
    protected $fillable = ['id_coeficiente', 'id_valor_calculo', 'valor_sistema', 'valor_usuario', 'informacion_adicional', 'id_usuario', 'estado', 'version', 'created_at', 'updated_at'];
}
