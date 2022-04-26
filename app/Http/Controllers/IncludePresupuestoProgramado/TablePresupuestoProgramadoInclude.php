<?php

if ($tipo == 1) {
    $vistaIngresoProgramados = DB::table('vista_ingreso_programado')
        ->where('id_padre', '=', $id)
        ->where('estado_ingreso_programado', '=', 1)
        ->where('id_user_ingreso_programado', '=', auth()->id())
        ->orderBy('orden_categoria', 'ASC')
        ->get();
} else {
    $vistaIngresoProgramados = DB::table('vista_egreso_programado')
        ->where('id_padre', '=', $id)
        ->where('estado_egreso_programado', '=', 1)
        ->where('id_user_egreso_programado', '=', auth()->id())
        ->orderBy('orden_categoria', 'ASC')
        ->get();
}

$id_ingreso_programado = array();
$monto = array();
$id_frecuencia = array();
$caducidad = array();
$fecha_inicio = array();
$fecha_fin = array();

foreach ($vistaIngresoProgramados as $vistaIngresoProgramado) {
    $valor_caducidad = $vistaIngresoProgramado->sin_caducidad + 0;

    if ($vistaIngresoProgramado->id_frecuencia == 1) //Unico
    {
        $id_ingreso_programado[$vistaIngresoProgramado->id_categoria] = $vistaIngresoProgramado->id;
        $monto[$vistaIngresoProgramado->id_categoria] = $vistaIngresoProgramado->monto_programado;
        $id_frecuencia[$vistaIngresoProgramado->id_categoria] = $vistaIngresoProgramado->id_frecuencia;
        $caducidad[$vistaIngresoProgramado->id_categoria] = $valor_caducidad;
        $fecha_inicio[$vistaIngresoProgramado->id_categoria] = $vistaIngresoProgramado->fecha_inicio;
        $fecha_fin[$vistaIngresoProgramado->id_categoria] = $vistaIngresoProgramado->fecha_fin;
    }

    if ($valor_caducidad == 1) {
        $rango_fechas = fechas_first_last($fecha_actual);
        $rango_inicio = fechas_first_last($vistaIngresoProgramado->fecha_inicio);

        if (
            $rango_inicio[0] <= $rango_fechas[0]
            and $rango_inicio[1] <= $rango_fechas[1]
        ) {
            $id_ingreso_programado[$vistaIngresoProgramado->id_categoria] = $vistaIngresoProgramado->id;
            $monto[$vistaIngresoProgramado->id_categoria] = $vistaIngresoProgramado->monto_programado;
            $id_frecuencia[$vistaIngresoProgramado->id_categoria] = $vistaIngresoProgramado->id_frecuencia;
            $caducidad[$vistaIngresoProgramado->id_categoria] = $valor_caducidad;
            $fecha_inicio[$vistaIngresoProgramado->id_categoria] = $vistaIngresoProgramado->fecha_inicio;
            $fecha_fin[$vistaIngresoProgramado->id_categoria] = $vistaIngresoProgramado->fecha_fin;
        }
    } else {

        $rango_fechas = fechas_first_last($fecha_actual);
        $rango_inicio = fechas_first_last($vistaIngresoProgramado->fecha_inicio);
        $rango_fin = fechas_first_last($vistaIngresoProgramado->fecha_fin);

        if (
            $rango_inicio[0] <= $rango_fechas[0]
            and $rango_inicio[1] <= $rango_fechas[1]
            and $rango_fin[0] >= $rango_fechas[0]
            and $rango_fin[1] >= $rango_fechas[1]
        ) {
            $id_ingreso_programado[$vistaIngresoProgramado->id_categoria] = $vistaIngresoProgramado->id;
            $monto[$vistaIngresoProgramado->id_categoria] = $vistaIngresoProgramado->monto_programado;
            $id_frecuencia[$vistaIngresoProgramado->id_categoria] = $vistaIngresoProgramado->id_frecuencia;
            $caducidad[$vistaIngresoProgramado->id_categoria] = $valor_caducidad;
            $fecha_inicio[$vistaIngresoProgramado->id_categoria] = $vistaIngresoProgramado->fecha_inicio;
            $fecha_fin[$vistaIngresoProgramado->id_categoria] = $vistaIngresoProgramado->fecha_fin;
        }
    }
}
