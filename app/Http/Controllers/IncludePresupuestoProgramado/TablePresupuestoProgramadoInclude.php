<?php

$id_ingreso_programado = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
$id_categoria_array = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
$categoria_name = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
$categoria_plantilla = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
$categoria_user = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
$subcategoria_favorita_array = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
$monto = array();
$id_frecuencia = array();
$caducidad = array();
$fecha_inicio = array();
$fecha_fin = array();
$monto_total = 0;
$contador = 0;
$programado = array();

foreach ($vistaCategorias as $vistaCategoria) {
    $id_categoria_array[$contador] = $vistaCategoria->id;
    $categoria_name[$contador] = $vistaCategoria->categoria;
    $categoria_plantilla[$contador] = $vistaCategoria->plantilla;
    $categoria_user[$contador] = $vistaCategoria->id_user;

    if ($tipo == 1) {
        $vistaIngresoProgramados = DB::table('vista_ingreso_programado')
            ->where('id_categoria', '=', $vistaCategoria->id)
            ->where('estado_ingreso_programado', '=', 1)
            ->where('id_user_ingreso_programado', '=', auth()->id())
            ->get();
    } else {
        $vistaIngresoProgramados = DB::table('vista_egreso_programado')
            ->where('id_categoria', '=', $vistaCategoria->id)
            ->where('estado_egreso_programado', '=', 1)
            ->where('id_user_egreso_programado', '=', auth()->id())
            ->get();
    }

    $subcategoria_favorita = DB::table('subcategoria_favorita')
        ->where('id_categoria', '=', $vistaCategoria->id)
        ->where('id_user', '=', auth()->id())
        ->where('estado', '=', 1)
        ->first();

    if (isset($subcategoria_favorita)) {
        $subcategoria_favorita_array[$contador] = $vistaCategoria->id;
    }

    if (!isset($vistaIngresoProgramados)) {
    } else {
        foreach ($vistaIngresoProgramados as $vistaIngresoProgramado) {

            $programado[$contador] =  $vistaIngresoProgramado;
            $valor_caducidad = $vistaIngresoProgramado->sin_caducidad + 0;

            if ($vistaIngresoProgramado->id_frecuencia == 1) //Unico
            {
                $rango_fechas = fechas_first_last($fecha_actual);
                $rango_inicio = fechas_first_last($vistaIngresoProgramado->fecha_inicio);

                if (
                    $rango_inicio[0] == $rango_fechas[0]
                    and $rango_inicio[1] == $rango_fechas[1]
                ) {
                    $id_ingreso_programado[$contador] = $vistaIngresoProgramado->id;
                    $monto[$contador] = $vistaIngresoProgramado->monto_programado;
                    $id_frecuencia[$contador] = $vistaIngresoProgramado->id_frecuencia;
                    $caducidad[$contador] = $valor_caducidad;
                    $fecha_inicio[$contador] = $vistaIngresoProgramado->fecha_inicio;
                    $fecha_fin[$contador] = $vistaIngresoProgramado->fecha_fin;

                    if (!isset($subcategoria_favorita)) {
                        $monto_total = $monto_total + $monto[$contador];
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
                        $id_ingreso_programado[$contador] = $vistaIngresoProgramado->id;
                        $monto[$contador] = $vistaIngresoProgramado->monto_programado;
                        $id_frecuencia[$contador] = $vistaIngresoProgramado->id_frecuencia;
                        $caducidad[$contador] = $valor_caducidad;
                        $fecha_inicio[$contador] = $vistaIngresoProgramado->fecha_inicio;
                        $fecha_fin[$contador] = $vistaIngresoProgramado->fecha_fin;

                        if (!isset($subcategoria_favorita)) {
                            $monto_total = $monto_total + $monto[$contador];
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
                        $id_ingreso_programado[$contador] = $vistaIngresoProgramado->id;
                        $monto[$contador] = $vistaIngresoProgramado->monto_programado;
                        $id_frecuencia[$contador] = $vistaIngresoProgramado->id_frecuencia;
                        $caducidad[$contador] = $valor_caducidad;
                        $fecha_inicio[$contador] = $vistaIngresoProgramado->fecha_inicio;
                        $fecha_fin[$contador] = $vistaIngresoProgramado->fecha_fin;

                        if (!isset($subcategoria_favorita)) {
                            $monto_total = $monto_total + $monto[$contador];
                        }
                    }
                }
            }
        }
    }

    $contador++;
}
