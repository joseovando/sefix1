<?php

$contador = 0;
$diferencia_egreso_categoria_mes = array();
$porcentaje_egreso_categoria_mes = array();
$nombre_categoria = array();

$vistaCategorias = DB::table('vista_categoria_padres')
    ->where('tipo', '=', $tipo)
    ->where('estado', '=', 1)

    ->orderBy('orden', 'ASC')
    ->get();

$total_egreso_categoria_mes = 0;
$total_egreso_categoria_programado_mes = 0;
$total_diferencia_egreso_categoria_mes = 0;
$total_porcentaje_egreso_categoria_mes = 0;

foreach ($vistaCategorias as $vistaCategoria) {

    list(
        $egreso_categoria_mes[$contador],
        $egreso_categoria_programado_mes[$contador]
    ) = total_categoria_mes($fecha_actual, $vistaCategoria->id, $tipo, $comercial);

    $diferencia_egreso_categoria_mes[$contador] = $egreso_categoria_mes[$contador] - $egreso_categoria_programado_mes[$contador];

    if ($egreso_categoria_programado_mes[$contador] != 0) {
        $porcentaje_egreso_categoria_mes[$contador] = ($egreso_categoria_mes[$contador] / $egreso_categoria_programado_mes[$contador]) * 100;
    } else {
        $porcentaje_egreso_categoria_mes[$contador] = 0;
    }

    $nombre_categoria[$contador] = $vistaCategoria->categoria;

    $total_egreso_categoria_mes = $total_egreso_categoria_mes + $egreso_categoria_mes[$contador];
    $total_egreso_categoria_programado_mes = $total_egreso_categoria_programado_mes + $egreso_categoria_programado_mes[$contador];
    $total_diferencia_egreso_categoria_mes = $total_diferencia_egreso_categoria_mes + $diferencia_egreso_categoria_mes[$contador];
    $total_porcentaje_egreso_categoria_mes = $total_porcentaje_egreso_categoria_mes + $porcentaje_egreso_categoria_mes[$contador];

    $contador++;
}