<?php

use App\Models\EgresoProgramado;
use App\Models\IngresoProgramado;

$categoria_inicial = request('categoria_inicial');
$id_inicial = request('id_inicial');
$monto_inicial = request('monto_inicial');
$frecuencia_inicial = request('frecuencia_inicial');
$sin_caducidad_inicial = request('sin_caducidad_inicial');
$inicio_inicial = request('inicio_inicial');
$fin_inicial = request('fin_inicial');
$presupuesto_id = array();
$categoria_id = array();

for ($i = 0; $i < sizeof($categoria_inicial); $i++) {

    if ($categoria_inicial[$i] > 0) {

        $id_ingreso_programado = $id_inicial[$i] + 0;
        $monto = $monto_inicial[$i] + 0;

        if ($sin_caducidad_inicial[$i] == 'true') {
            $valor_caducidad = 1;
        } else {
            $valor_caducidad = 0;
        }

        if (request('tipo') == 1) {

            if ($id_ingreso_programado > 0) {
                if ($monto > 0) {
                    $ingresoProgramado = IngresoProgramado::find($id_inicial[$i]);
                    $ingresoProgramado->monto_programado = $monto;
                    $ingresoProgramado->id_frecuencia = $frecuencia_inicial[$i];
                    $ingresoProgramado->sin_caducidad = $valor_caducidad;
                    $ingresoProgramado->fecha_inicio = $inicio_inicial[$i];
                    $ingresoProgramado->fecha_fin = $fin_inicial[$i];
                    $ingresoProgramado->update();

                    $presupuesto_id[$i] = $id_inicial[$i];
                    $categoria_id[$i] = $categoria_inicial[$i];
                }
            } else {
                if ($monto > 0) {
                    $ingresoProgramado = new IngresoProgramado();
                    $ingresoProgramado->id_categoria = $categoria_inicial[$i];
                    $ingresoProgramado->monto_programado = $monto;
                    $ingresoProgramado->id_frecuencia = $frecuencia_inicial[$i];
                    $ingresoProgramado->sin_caducidad = $valor_caducidad;
                    $ingresoProgramado->fecha_inicio = $inicio_inicial[$i];
                    $ingresoProgramado->fecha_fin = $fin_inicial[$i];
                    $ingresoProgramado->estado = 1;
                    $ingresoProgramado->id_user = auth()->id();
                    $ingresoProgramado->save();

                    $presupuesto_id[$i] = $ingresoProgramado->id;
                    $categoria_id[$i] = $categoria_inicial[$i];
                }
            }
        } else {

            if ($id_ingreso_programado > 0) {
                if ($monto > 0) {
                    $egresoProgramado = EgresoProgramado::find($id_inicial[$i]);
                    $egresoProgramado->monto_programado = $monto;
                    $egresoProgramado->id_frecuencia = $frecuencia_inicial[$i];
                    $egresoProgramado->sin_caducidad = $valor_caducidad;
                    $egresoProgramado->fecha_inicio = $inicio_inicial[$i];
                    $egresoProgramado->fecha_fin = $fin_inicial[$i];
                    $egresoProgramado->update();

                    $presupuesto_id[$i] = $id_inicial[$i];
                    $categoria_id[$i] = $categoria_inicial[$i];
                }
            } else {
                if ($monto > 0) {
                    $egresoProgramado = new EgresoProgramado();
                    $egresoProgramado->id_categoria = $categoria_inicial[$i];
                    $egresoProgramado->monto_programado = $monto;
                    $egresoProgramado->id_frecuencia = $frecuencia_inicial[$i];
                    $egresoProgramado->sin_caducidad = $valor_caducidad;
                    $egresoProgramado->fecha_inicio = $inicio_inicial[$i];
                    $egresoProgramado->fecha_fin = $fin_inicial[$i];
                    $egresoProgramado->estado = 1;
                    $egresoProgramado->id_user = auth()->id();
                    $egresoProgramado->save();

                    $presupuesto_id[$i] = $egresoProgramado->id;
                    $categoria_id[$i] = $categoria_inicial[$i];
                }
            }
        }
    }
}
