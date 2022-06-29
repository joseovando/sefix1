<?php

use App\Models\Categoria;
use App\Models\EgresoProgramado;
use App\Models\IngresoProgramado;

$id_ajax = request('id_ajax');
$id_categoria_ajax = request('id_categoria_ajax');
$monto_ajax = request('monto_ajax');
$frecuencia_ajax = request('frecuencia_ajax');
$sin_caducidad_ajax = request('sin_caducidad_ajax');
$inicio_ajax = request('inicio_ajax');
$fin_ajax = request('fin_ajax');

for ($i = 0; $i < sizeof($id_ajax); $i++) {

    if ($id_ajax > 0) {

        $monto = $monto_ajax[$i] + 0;

        if ($sin_caducidad_ajax[$i] == 'true') {
            $valor_caducidad = 1;
        } else {
            $valor_caducidad = 0;
        }

        /* if ($monto > 0) {
            if (request('tipo') == 1) {
                $ingresoProgramado = IngresoProgramado::find($id_ajax[$i]);
                $ingresoProgramado->monto_programado = $monto;
                $ingresoProgramado->id_frecuencia = $frecuencia_ajax[$i];
                $ingresoProgramado->sin_caducidad = $valor_caducidad;
                $ingresoProgramado->fecha_inicio = $inicio_ajax[$i];
                $ingresoProgramado->fecha_fin = $fin_ajax[$i];
                $ingresoProgramado->update();
            } else {
                $egresoProgramado = EgresoProgramado::find($id_ajax[$i]);
                $egresoProgramado->monto_programado = $monto;
                $egresoProgramado->id_frecuencia = $frecuencia_ajax[$i];
                $egresoProgramado->sin_caducidad = $valor_caducidad;
                $egresoProgramado->fecha_inicio = $inicio_ajax[$i];
                $egresoProgramado->fecha_fin = $fin_ajax[$i];
                $egresoProgramado->update();
            }
        } */

        if (request('tipo') == 1) {

            if ($id_ajax[$i] > 0) {
                if ($monto > 0) {
                    $ingresoProgramado = IngresoProgramado::find($id_ajax[$i]);
                    $ingresoProgramado->monto_programado = $monto;
                    $ingresoProgramado->id_frecuencia = $frecuencia_ajax[$i];
                    $ingresoProgramado->sin_caducidad = $valor_caducidad;
                    $ingresoProgramado->fecha_inicio = $inicio_ajax[$i];
                    $ingresoProgramado->fecha_fin = $fin_ajax[$i];
                    $ingresoProgramado->update();
                }
            } else {
                if ($monto > 0) {
                    $ingresoProgramado = new IngresoProgramado();
                    $ingresoProgramado->id_categoria = $id_categoria_ajax[$i];
                    $ingresoProgramado->monto_programado = $monto;
                    $ingresoProgramado->id_frecuencia = $frecuencia_ajax[$i];
                    $ingresoProgramado->sin_caducidad = $valor_caducidad;
                    $ingresoProgramado->fecha_inicio = $inicio_ajax[$i];
                    $ingresoProgramado->fecha_fin = $fin_ajax[$i];
                    $ingresoProgramado->estado = 1;
                    $ingresoProgramado->id_user = auth()->id();
                    $ingresoProgramado->save();
                }
            }
        } else {

            if ($id_ajax[$i] > 0) {
                if ($monto > 0) {
                    $egresoProgramado = EgresoProgramado::find($id_ajax[$i]);
                    $egresoProgramado->monto_programado = $monto;
                    $egresoProgramado->id_frecuencia = $frecuencia_ajax[$i];
                    $egresoProgramado->sin_caducidad = $valor_caducidad;
                    $egresoProgramado->fecha_inicio = $inicio_ajax[$i];
                    $egresoProgramado->fecha_fin = $fin_ajax[$i];
                    $egresoProgramado->update();
                }
            } else {
                if ($monto > 0) {
                    $egresoProgramado = new EgresoProgramado();
                    $egresoProgramado->id_categoria = $id_categoria_ajax[$i];
                    $egresoProgramado->monto_programado = $monto;
                    $egresoProgramado->id_frecuencia = $frecuencia_ajax[$i];
                    $egresoProgramado->sin_caducidad = $valor_caducidad;
                    $egresoProgramado->fecha_inicio = $inicio_ajax[$i];
                    $egresoProgramado->fecha_fin = $fin_ajax[$i];
                    $egresoProgramado->estado = 1;
                    $egresoProgramado->id_user = auth()->id();
                    $egresoProgramado->save();
                }
            }
        }
    }
}

/* if (request('tipo') == 1) {

    if ($id_ajax[$i] > 0) {
        if ($monto > 0) {
            $ingresoProgramado = IngresoProgramado::find($id_ajax[$i]);
            $ingresoProgramado->monto_programado = $monto;
            $ingresoProgramado->id_frecuencia = $frecuencia_ajax[$i];
            $ingresoProgramado->sin_caducidad = $valor_caducidad;
            $ingresoProgramado->fecha_inicio = $inicio_ajax[$i];
            $ingresoProgramado->fecha_fin = $fin_ajax[$i];
            $ingresoProgramado->update();
        }
    } else {
        if ($monto > 0) {
            $ingresoProgramado = new IngresoProgramado();
            $ingresoProgramado->id_categoria = $id_categoria_ajax[$i];
            $ingresoProgramado->monto_programado = $monto;
            $ingresoProgramado->id_frecuencia = $frecuencia_ajax[$i];
            $ingresoProgramado->sin_caducidad = $valor_caducidad;
            $ingresoProgramado->fecha_inicio = $inicio_ajax[$i];
            $ingresoProgramado->fecha_fin = $fin_ajax[$i];
            $ingresoProgramado->estado = 1;
            $ingresoProgramado->id_user = auth()->id();
            $ingresoProgramado->save();
        }
    }
} else {

    if ($id_ajax[$i] > 0) {
        if ($monto > 0) {
            $egresoProgramado = EgresoProgramado::find($id_ajax[$i]);
            $egresoProgramado->monto_programado = $monto;
            $egresoProgramado->id_frecuencia = $frecuencia_ajax[$i];
            $egresoProgramado->sin_caducidad = $valor_caducidad;
            $egresoProgramado->fecha_inicio = $inicio_ajax[$i];
            $egresoProgramado->fecha_fin = $fin_ajax[$i];
            $egresoProgramado->update();
        }
    } else {
        if ($monto > 0) {
            $egresoProgramado = new EgresoProgramado();
            $egresoProgramado->id_categoria = $id_categoria_ajax[$i];
            $egresoProgramado->monto_programado = $monto;
            $egresoProgramado->id_frecuencia = $frecuencia_ajax[$i];
            $egresoProgramado->sin_caducidad = $valor_caducidad;
            $egresoProgramado->fecha_inicio = $inicio_ajax[$i];
            $egresoProgramado->fecha_fin = $fin_ajax[$i];
            $egresoProgramado->estado = 1;
            $egresoProgramado->id_user = auth()->id();
            $egresoProgramado->save();
        }
    }
} */
