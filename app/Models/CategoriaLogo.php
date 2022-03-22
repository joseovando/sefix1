<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $icono
 * @property string $label
 * @property int $orden
 * @property int $estado
 * @property int $id_user
 * @property string $created_at
 * @property string $updated_at
 * @property string $tamaño
 */
class CategoriaLogo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'categoria_logo';

    /**
     * @var array
     */
    protected $fillable = ['icono', 'label', 'orden', 'estado', 'id_user', 'created_at', 'updated_at', 'tamano'];
}
