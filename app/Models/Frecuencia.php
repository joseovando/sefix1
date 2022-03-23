<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $frecuencia
 * @property int $valor_numerico
 * @property int $orden
 * @property int $estado
 * @property int $id_user
 * @property string $created_at
 * @property string $updated_at
 */
class Frecuencia extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'frecuencia';

    /**
     * @var array
     */
    protected $fillable = ['frecuencia', 'valor_numerico', 'orden', 'estado', 'id_user', 'created_at', 'updated_at'];
}
