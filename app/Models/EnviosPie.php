<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $categoria
 * @property int $porcentaje
 */
class EnviosPie extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'envios_pie';

    /**
     * @var array
     */
    protected $fillable = ['categoria', 'porcentaje'];
}
