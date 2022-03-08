<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_categoria
 * @property int $orden
 * @property int $estado
 * @property int $id_user
 * @property string $created_at
 * @property string $updated_at
 */
class /Models/CategoriaFavorita extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'categoria_favorita';

    /**
     * @var array
     */
    protected $fillable = ['id_categoria', 'orden', 'estado', 'id_user', 'created_at', 'updated_at'];
}
