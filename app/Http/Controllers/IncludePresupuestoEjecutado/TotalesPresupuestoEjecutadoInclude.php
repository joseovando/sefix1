<?php

$fechas = request('fecha');

for ($j = 0; $j < count($fechas); $j++) {
    $egreso_dia_primario[$j] = total_categoria_dia($fechas[$j], request('id_categoria'), request('tipo'), $comercial);
}

if ($tipo == 1) {
    $vistaCategorias = DB::table('vista_ingreso_programado')
        ->select('id_categoria')
        ->where('id_padre', '=', request('id_categoria'))
        ->where('estado_ingreso_programado', '=', 1)
        ->where('id_user_ingreso_programado', '=', auth()->id())
        ->groupBy('id_categoria')
        ->get();
} else {
    $vistaCategorias = DB::table('vista_egreso_programado')
        ->select('id_categoria')
        ->where('id_padre', '=', request('id_categoria'))
        ->where('estado_egreso_programado', '=', 1)
        ->where('id_user_egreso_programado', '=', auth()->id())
        ->groupBy('id_categoria')
        ->get();
}

foreach ($vistaCategorias as $vistaCategoria) {
    list(
        $total_ejecutado_mes_primario[$vistaCategoria->id_categoria],
        $total_programado_mes_primario[$vistaCategoria->id_categoria]
    ) = total_subcategoria_mes(request('date'), $vistaCategoria->id_categoria, request('tipo'), $comercial);

    $diferencia_mes_primario[$vistaCategoria->id_categoria] = $total_ejecutado_mes_primario[$vistaCategoria->id_categoria] -  $total_programado_mes_primario[$vistaCategoria->id_categoria];
    if ($total_programado_mes_primario[$vistaCategoria->id_categoria] > 0) {
        $porcentaje_mes_primario[$vistaCategoria->id_categoria] = ($total_ejecutado_mes_primario[$vistaCategoria->id_categoria] /  $total_programado_mes_primario[$vistaCategoria->id_categoria]) * 100;
    } else {
        $porcentaje_mes_primario[$vistaCategoria->id_categoria] = 0;
    }

    $total_ejecutado = $total_ejecutado + $total_ejecutado_mes_primario[$vistaCategoria->id_categoria];
    $total_programado = $total_programado + $total_programado_mes_primario[$vistaCategoria->id_categoria];
}
