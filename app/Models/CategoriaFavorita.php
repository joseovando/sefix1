<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_categoria
 * @property int $orden
 * @property int $plantilla
 * @property int $estado
 * @property int $id_user
 * @property string $created_at
 * @property string $updated_at
 */
class CategoriaFavorita extends Model
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
    protected $fillable = ['id_categoria', 'orden', 'plantilla', 'estado', 'id_user', 'created_at', 'updated_at'];
}
