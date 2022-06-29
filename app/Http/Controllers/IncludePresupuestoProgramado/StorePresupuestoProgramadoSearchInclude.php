<?php

use App\Models\Categoria;
use App\Models\EgresoProgramado;
use App\Models\IngresoProgramado;

$id_search = request('id_search');
$id_categoria_search = request('id_categoria_search');
$monto_search = request('monto_search');
$frecuencia_search = request('frecuencia_search');
$sin_caducidad_search = request('sin_caducidad_search');
$inicio_search = request('inicio_search');
$fin_search = request('fin_search');

for ($i = 0; $i < sizeof($id_search); $i++) {

    $id_ingreso_programado = $id_search[$i] + 0;
    $monto = $monto_search[$i] + 0;

    if ($sin_caducidad_search[$i] == 'true') {
        $valor_caducidad = 1;
    } else {
        $valor_caducidad = 0;
    }

    if (request('tipo') == 1) {

        if ($id_ingreso_programado > 0) {
            if ($monto > 0) {
                $ingresoProgramado = IngresoProgramado::find($id_search[$i]);
                $ingresoProgramado->monto_programado = $monto;
                $ingresoProgramado->id_frecuencia = $frecuencia_search[$i];
                $ingresoProgramado->sin_caducidad = $valor_caducidad;
                $ingresoProgramado->fecha_inicio = $inicio_search[$i];
                $ingresoProgramado->fecha_fin = $fin_search[$i];
                $ingresoProgramado->update();
            }
        } else {
            if ($monto > 0) {
                $ingresoProgramado = new IngresoProgramado();
                $ingresoProgramado->id_categoria = $id_categoria_search[$i];
                $ingresoProgramado->monto_programado = $monto;
                $ingresoProgramado->id_frecuencia = $frecuencia_search[$i];
                $ingresoProgramado->sin_caducidad = $valor_caducidad;
                $ingresoProgramado->fecha_inicio = $inicio_search[$i];
                $ingresoProgramado->fecha_fin = $fin_search[$i];
                $ingresoProgramado->estado = 1;
                $ingresoProgramado->id_user = auth()->id();
                $ingresoProgramado->save();
            }
        }
    } else {

        if ($id_ingreso_programado > 0) {
            if ($monto > 0) {
                $egresoProgramado = EgresoProgramado::find($id_search[$i]);
                $egresoProgramado->monto_programado = $monto;
                $egresoProgramado->id_frecuencia = $frecuencia_search[$i];
                $egresoProgramado->sin_caducidad = $valor_caducidad;
                $egresoProgramado->fecha_inicio = $inicio_search[$i];
                $egresoProgramado->fecha_fin = $fin_search[$i];
                $egresoProgramado->update();
            }
        } else {
            if ($monto > 0) {
                $egresoProgramado = new EgresoProgramado();
                $egresoProgramado->id_categoria = $id_categoria_search[$i];
                $egresoProgramado->monto_programado = $monto;
                $egresoProgramado->id_frecuencia = $frecuencia_search[$i];
                $egresoProgramado->sin_caducidad = $valor_caducidad;
                $egresoProgramado->fecha_inicio = $inicio_search[$i];
                $egresoProgramado->fecha_fin = $fin_search[$i];
                $egresoProgramado->estado = 1;
                $egresoProgramado->id_user = auth()->id();
                $egresoProgramado->save();
            }
        }
    }
}
