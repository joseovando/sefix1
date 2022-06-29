<?php

$dia_semana = date("N", strtotime($date));
list($calendario, $fechas) = dias_calendario($date, $dia_semana);

$n_inputs = 6;
$egreso[0][0] = 0;
$detalle[0][0] = '';
$total_ejecutado_mes = 0;
$total_programado_mes = 0;
$array_categoria = array();
$color_porcentaje = array();
$total_monto_dia = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0);
$total_ejecutado_subcategoria = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0);
$total_programado_subcategoria = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0);
$diferencia = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0);
$porcentaje = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0);

foreach ($vistaCategorias as $vistaCategoria) {
    $mes_actual = mes_actual($date);

    $vCategorias = DB::table('vista_categorias')
        ->where('id', '=', $vistaCategoria->id_categoria)
        ->orderBy('orden', 'ASC')
        ->first();

    $array_categoria[$vistaCategoria->id_categoria]['id_categoria'] = $vCategorias->categoria;
    $array_categoria[$vistaCategoria->id_categoria]['plantilla'] = $vCategorias->plantilla;
    $array_categoria[$vistaCategoria->id_categoria]['id_user'] = $vCategorias->id_user;

    for ($i = 0; $i <= $n_inputs; $i++) {

        $total_monto_dia[$i] = 0;
        $fecha = str_replace("_", "-", $fechas[$i]);

        if ($tipo == 2) {
            $egreso_montos = DB::table('egreso')
                ->where('id_categoria', '=', $vistaCategoria->id_categoria)
                ->where('fecha', '=', $fecha)
                ->where('estado', '=', 1)
                ->where('id_user', '=', auth()->id())
                ->get();

            $total_dias = DB::table('vista_egresos')
                ->where('fecha', '=', $fecha)
                ->where('id_padre', '=', $id)
                ->where('estado', '=', 1)
                ->where('id_user', '=', auth()->id())
                ->get();
        } else {
            $egreso_montos = DB::table('ingreso')
                ->where('id_categoria', '=', $vistaCategoria->id_categoria)
                ->where('fecha', '=', $fecha)
                ->where('estado', '=', 1)
                ->where('id_user', '=', auth()->id())
                ->get();

            $total_dias = DB::table('vista_ingresos')
                ->where('fecha', '=', $fecha)
                ->where('id_padre', '=', $id)
                ->where('estado', '=', 1)
                ->where('id_user', '=', auth()->id())
                ->get();
        }

        foreach ($total_dias as $total_dia) {
            $total_monto_dia[$i] = $total_monto_dia[$i] + $total_dia->monto_ejecutado;
        }

        foreach ($egreso_montos as $egreso_monto) {
            $egresoMonto = $egreso_monto->monto_ejecutado + 0;

            if ($egresoMonto > 0) {
                $egreso[$i][$vistaCategoria->id_categoria] = $egresoMonto;
                $detalle[$i][$vistaCategoria->id_categoria] = $egreso_monto->detalle;
            }
        }
    }

    list(
        $total_ejecutado_subcategoria[$vistaCategoria->id_categoria],
        $total_programado_subcategoria[$vistaCategoria->id_categoria]
    ) = total_subcategoria_mes($date, $vistaCategoria->id_categoria, $tipo, $comercial);

    $diferencia[$vistaCategoria->id_categoria] = $total_ejecutado_subcategoria[$vistaCategoria->id_categoria] -  $total_programado_subcategoria[$vistaCategoria->id_categoria];
    if ($total_programado_subcategoria[$vistaCategoria->id_categoria] > 0) {
        $porcentaje[$vistaCategoria->id_categoria] = ($total_ejecutado_subcategoria[$vistaCategoria->id_categoria] /  $total_programado_subcategoria[$vistaCategoria->id_categoria]) * 100;
    } else {
        $porcentaje[$vistaCategoria->id_categoria] = 0;
    }

    $total_ejecutado_mes = $total_ejecutado_mes + $total_ejecutado_subcategoria[$vistaCategoria->id_categoria];
    $total_programado_mes = $total_programado_mes + $total_programado_subcategoria[$vistaCategoria->id_categoria];

    //color de alerta
    if ($tipo == 1) {
        if (
            $porcentaje[$vistaCategoria->id_categoria] >= 0 and
            $porcentaje[$vistaCategoria->id_categoria] < 70
        ) {
            $color_porcentaje[$vistaCategoria->id_categoria] = "#f087b9";
        }
        if (
            $porcentaje[$vistaCategoria->id_categoria] >= 70 and
            $porcentaje[$vistaCategoria->id_categoria] < 90
        ) {
            $color_porcentaje[$vistaCategoria->id_categoria] = "#fa9e39";
        }
        if ($porcentaje[$vistaCategoria->id_categoria] >= 90) {
            $color_porcentaje[$vistaCategoria->id_categoria] = "#35d3ee";
        }
    } else {
        if (
            $porcentaje[$vistaCategoria->id_categoria] >= 0 and
            $porcentaje[$vistaCategoria->id_categoria] < 70
        ) {
            $color_porcentaje[$vistaCategoria->id_categoria] = "#b1d537";
        }
        if (
            $porcentaje[$vistaCategoria->id_categoria] >= 70 and
            $porcentaje[$vistaCategoria->id_categoria] < 90
        ) {
            $color_porcentaje[$vistaCategoria->id_categoria] = "#fae033";
        }
        if ($porcentaje[$vistaCategoria->id_categoria] >= 90) {
            $color_porcentaje[$vistaCategoria->id_categoria] = "#f96666";
        }
    }
}
