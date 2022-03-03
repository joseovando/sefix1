<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $mes
 * @property float $programado
 * @property float $ejecutado
 */
class EnviosGroupBar extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'envios_group_bar';

    /**
     * @var array
     */
    protected $fillable = ['mes', 'programado', 'ejecutado'];
}
