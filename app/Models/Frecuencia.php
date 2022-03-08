<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $frecuencia
 * @property int $orden
 * @property int $estado
 * @property int $id_user
 * @property string $created_at
 * @property string $updated_at
 */
class /Models/Frecuencia extends Model
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
    protected $fillable = ['frecuencia', 'orden', 'estado', 'id_user', 'created_at', 'updated_at'];
}
