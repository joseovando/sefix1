<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $categoria
 * @property int $id_padre
 * @property int $orden
 * @property string $icono
 * @property string $fondo
 * @property int $plantilla
 * @property int $estado
 * @property int $id_user
 * @property string $created_at
 * @property string $updated_at
 */
class /Models/Categoria extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'categoria';

    /**
     * @var array
     */
    protected $fillable = ['categoria', 'id_padre', 'orden', 'icono', 'fondo', 'plantilla', 'estado', 'id_user', 'created_at', 'updated_at'];
}
