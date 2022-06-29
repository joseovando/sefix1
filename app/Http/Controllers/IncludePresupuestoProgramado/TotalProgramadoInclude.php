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

$monto_total = 0;

foreach ($vistaIngresoProgramados as $vistaIngresoProgramado) {

    $subcategoria_favorita = DB::table('subcategoria_favorita')
        ->where('id_categoria', '=', $vistaIngresoProgramado->id_categoria)
        ->where('id_user', '=', auth()->id())
        ->where('estado', '=', 1)
        ->first();

    $valor_caducidad = $vistaIngresoProgramado->sin_caducidad + 0;

    if ($vistaIngresoProgramado->id_frecuencia == 1) //Unico
    {
        $rango_fechas = fechas_first_last($fecha_actual);
        $rango_inicio = fechas_first_last($vistaIngresoProgramado->fecha_inicio);

        if (
            $rango_inicio[0] == $rango_fechas[0]
            and $rango_inicio[1] == $rango_fechas[1]
        ) {
            if (!isset($subcategoria_favorita)) {
                $monto_total = $monto_total + $vistaIngresoProgramado->monto_programado;
            }
        }
    } else {

        if ($valor_caducidad == 1) {
            $rango_fechas = fechas_first_last($fecha_actual);
            $rango_inicio = fechas_first_last($vistaIngresoProgramado->fecha_inicio);

            if (
                $rango_inicio[0] <= $rango_fechas[0]
                and $rango_inicio[1] <= $rango_fechas[1]
            ) {
                if (!isset($subcategoria_favorita)) {
                    $monto_total = $monto_total + $vistaIngresoProgramado->monto_programado;
                }
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
                if (!isset($subcategoria_favorita)) {
                    $monto_total = $monto_total + $vistaIngresoProgramado->monto_programado;
                }
            }
        }
    }
}
