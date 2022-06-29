<?php

$search =  request('search');
$entrada = explode(' | ', $search);
$date = request('date');
$tipo = request('tipo');

if (stristr($search, '|') === FALSE) {
    $vistaCategoria = DB::table('vista_categorias')
        ->where('categoria', 'like', '%' . $search . '%')
        ->where('estado', '=', 1)
        ->orderBy('tipo', 'ASC')
        ->orderBy('categoria_padre', 'ASC')
        ->orderBy('categoria', 'ASC')
        ->first();
} else {
    $vistaCategoria = DB::table('vista_categorias')
        ->where('categoria_padre', 'like', '%' . $entrada[1] . '%')
        ->where('categoria', 'like', '%' . $entrada[0] . '%')
        ->where('estado', '=', 1)
        ->orderBy('tipo', 'ASC')
        ->orderBy('categoria_padre', 'ASC')
        ->orderBy('categoria', 'ASC')
        ->first();
}

if (!isset($vistaCategoria)) {
    $search_result = 0;
    $vistaCategoria = 0;
    $vistaIngreso = 0;
} else {
    $search_result = 1;
    $dia_semana = date("N", strtotime($date));
    list($calendario, $fechas) = dias_calendario($date, $dia_semana);
    $n_inputs = 6;
    $egreso[0][0] = 0;
    $detalle[0][0] = '';
    $total_ejecutado_mes = 0;
    $total_programado_mes = 0;
    $array_categoria = array();
    $mes_actual = mes_actual($date);

    $vCategorias = DB::table('vista_categorias')
        ->where('id', '=', $vistaCategoria->id)
        ->orderBy('orden', 'ASC')
        ->first();

    for ($i = 0; $i <= $n_inputs; $i++) {

        $total_monto_dia[$i] = 0;
        $fecha = str_replace("_", "-", $fechas[$i]);

        if ($tipo == 2) {
            $egreso_montos = DB::table('egreso')
                ->where('id_categoria', '=', $vistaCategoria->id)
                ->where('fecha', '=', $fecha)
                ->where('estado', '=', 1)
                ->where('id_user', '=', auth()->id())
                ->get();

            $total_dias = DB::table('vista_egresos')
                ->where('fecha', '=', $fecha)
                ->where('id_padre', '=', $vistaCategoria->id_padre)
                ->where('estado', '=', 1)
                ->where('id_user', '=', auth()->id())
                ->get();
        } else {
            $egreso_montos = DB::table('ingreso')
                ->where('id_categoria', '=', $vistaCategoria->id)
                ->where('fecha', '=', $fecha)
                ->where('estado', '=', 1)
                ->where('id_user', '=', auth()->id())
                ->get();

            $total_dias = DB::table('vista_ingresos')
                ->where('fecha', '=', $fecha)
                ->where('id_padre', '=', $vistaCategoria->id_padre)
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
                $egreso[$i] = $egresoMonto;
                $detalle[$i] = $egreso_monto->detalle;
            }
        }
    }

    list(
        $total_ejecutado_subcategoria[$vistaCategoria->id],
        $total_programado_subcategoria[$vistaCategoria->id]
    ) = total_subcategoria_mes($date, $vistaCategoria->id, $tipo, $comercial);

    $total_ejecutado_mes = $total_ejecutado_mes + $total_ejecutado_subcategoria[$vistaCategoria->id];
    $total_programado_mes = $total_programado_mes + $total_programado_subcategoria[$vistaCategoria->id];
    $diferencia_mes = $total_ejecutado_mes - $total_programado_mes;
    if ($total_programado_mes > 0) {
        $porcentaje_mes = $total_ejecutado_mes - $total_programado_mes;
    } else {
        $porcentaje_mes = 0;
    }
}
