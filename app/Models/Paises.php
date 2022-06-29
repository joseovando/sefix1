<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nombre_pais
 * @property int $estado
 * @property int $id_user
 * @property string $created_at
 * @property string $updated_at
 */
class Paises extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'paises';

    /**
     * @var array
     */
    protected $fillable = ['nombre_pais', 'estado', 'id_user', 'created_at', 'updated_at'];
}
