<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $comercial
 * @property int $estado
 * @property int $id_user
 * @property string $created_at
 * @property string $updated_at
 */
class CategoriaComercial extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'categoria_comercial';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['comercial', 'estado', 'id_user', 'created_at', 'updated_at'];
}
