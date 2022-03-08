<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $ruta_grafica
 * @property int $orden
 * @property int $estado
 * @property int $id_user
 * @property string $created_at
 * @property string $updated_at
 */
class /Models/GraficaFavorita extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'grafica_favorita';

    /**
     * @var array
     */
    protected $fillable = ['ruta_grafica', 'orden', 'estado', 'id_user', 'created_at', 'updated_at'];
}
