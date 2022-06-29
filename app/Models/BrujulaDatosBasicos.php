<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_user
 * @property int $renta_jubilacion
 * @property int $ano_renta_jubilacion
 * @property float $porcentaje_renta_jubilacion
 * @property int $expectativa_vida
 * @property int $tiene_conyuge
 * @property string $fecha_nacimiento_conyuge
 * @property int $renta_jubilacion_conyuge
 * @property int $ano_renta_jubilacion_conyuge
 * @property float $porcentaje_renta_jubilacion_conyuge
 * @property int $estado
 * @property string $created_at
 * @property string $updated_at
 * @property int $historico
 */
class BrujulaDatosBasicos extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'brujula_datos_basicos';

    /**
     * @var array
     */
    protected $fillable = ['id_user', 'renta_jubilacion', 'ano_renta_jubilacion', 'porcentaje_renta_jubilacion', 'expectativa_vida', 'tiene_conyuge', 'fecha_nacimiento_conyuge', 'renta_jubilacion_conyuge', 'ano_renta_jubilacion_conyuge', 'porcentaje_renta_jubilacion_conyuge', 'estado', 'created_at', 'updated_at', 'historico'];
}
