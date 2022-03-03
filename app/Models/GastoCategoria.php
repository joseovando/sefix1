<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $categoria
 * @property float $gasto
 */
class GastoCategoria extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'gasto_categoria';

    /**
     * @var array
     */
    protected $fillable = ['categoria', 'gasto'];
}
