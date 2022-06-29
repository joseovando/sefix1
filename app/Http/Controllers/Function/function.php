<?php

function navegador_mobile()
{
    $user_agent = $_SERVER["HTTP_USER_AGENT"];
    if (preg_match("/(android|webos|avantgo|iphone|ipod|ipad|bolt|boost|cricket|docomo|fone|hiptop|opera mini|mini|kitkat|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $user_agent)) {
        $navegador_mobile = 1;
    } else {
        $navegador_mobile = 0;
    }

    return $navegador_mobile;
}

function diaEs($fecha)
{
    $day = date("l", $fecha);
    switch ($day) {
        case "Sunday":
            $dia = "Dom";
            break;
        case "Monday":
            $dia = "Lun";
            break;
        case "Tuesday":
            $dia = "Mar";
            break;
        case "Wednesday":
            $dia = "Mie";
            break;
        case "Thursday":
            $dia = "Jue";
            break;
        case "Friday":
            $dia = "Vie";
            break;
        case "Saturday":
            $dia = "Sab";
            break;
    }
    return $dia;
}

function meses()
{
    $meses = array(
        1 => 'Enero',
        2 => 'Febrero',
        3 => 'Marzo',
        4 => 'Abril',
        5 => 'Mayo',
        6 => 'Junio',
        7 => 'Julio',
        8 => 'Agosto',
        9 => 'Septiembre',
        10 => 'Octubre',
        11 => 'Noviembre',
        12 => 'Diciembre'
    );
    return $meses;
}

function mes_actual($fecha_actual)
{
    $fecha_actual_num = strtotime($fecha_actual);
    $ano_actual = date("Y", $fecha_actual_num);
    $mes_actual = date("m", $fecha_actual_num);

    $date_future = strtotime('+1 month', strtotime($fecha_actual));
    $mes_futuro = date('Y-m-d', $date_future);

    $fecha_actual_num = strtotime($mes_futuro);
    $ano_future = date("Y", $fecha_actual_num);
    $mes_future = date("m", $fecha_actual_num);

    $mes[0] = $ano_actual . "-" . $mes_actual . "-01";
    $mes_last = $ano_future . "-" . $mes_future . "-01";
    $date_future = strtotime('-1 day', strtotime($mes_last));
    $mes[1] = date('Y-m-d', $date_future);
    return $mes;
}

function date_frecuencia($fecha_actual, $fecha_inicial, $fecha_final, $frecuencia)
{
    $mes_actual = mes_actual($fecha_actual);
    $fecha_frecuencia = $fecha_inicial;
    $contador = 1;

    if ($fecha_inicial < $fecha_final) {

        while ($fecha_frecuencia < $mes_actual[0]) {

            $frecuencia_neo = $frecuencia * $contador;
            $frecuencia_texto = "+" . $frecuencia_neo . " month";
            $date_future = strtotime($frecuencia_texto, strtotime($fecha_inicial));
            $fecha_frecuencia = date('Y-m-d', $date_future);
            $contador++;
        }

        if ($fecha_frecuencia > $fecha_final) {
            $contador = 1;

            while ($fecha_frecuencia > $mes_actual[1]) {

                $frecuencia = $frecuencia * $contador;
                $frecuencia_texto = "-" . $frecuencia . " month";
                $date_future = strtotime($frecuencia_texto, strtotime($fecha_frecuencia));
                $fecha_frecuencia = date('Y-m-d', $date_future);
                $contador++;
            }
        }
    }

    return $fecha_frecuencia;
}

function date_frecuencia_caducidad($fecha_actual, $fecha_inicial, $frecuencia)
{
    $mes_actual = mes_actual($fecha_actual);
    $fecha_frecuencia = $fecha_inicial;
    $contador = 1;

    while ($fecha_frecuencia < $mes_actual[0]) {

        $frecuencia_neo = $frecuencia * $contador;
        $frecuencia_texto = "+" . $frecuencia_neo . " month";
        $date_future = strtotime($frecuencia_texto, strtotime($fecha_inicial));
        $fecha_frecuencia = date('Y-m-d', $date_future);
        $contador++;
    }

    return $fecha_frecuencia;
}

function total_monto_programado($fecha_actual, $mes_actual, $array_programados)
{
    $total_egreso_programado = 0;

    foreach ($array_programados as $vistaEgresoProgramado) {

        if ($vistaEgresoProgramado->id_frecuencia == 1) {

            if (
                $vistaEgresoProgramado->fecha_inicio >= $mes_actual[0]
                and $vistaEgresoProgramado->fecha_inicio < $mes_actual[1]
            ) {
                $total_egreso_programado = $total_egreso_programado + $vistaEgresoProgramado->monto_programado;
            }
        } else {
            $caducidad = $vistaEgresoProgramado->sin_caducidad + 0;

            if ($caducidad == 1) {

                $fecha_promedio = date_frecuencia_caducidad(
                    $fecha_actual,
                    $vistaEgresoProgramado->fecha_inicio,
                    $vistaEgresoProgramado->valor_numerico
                );

                if (
                    $fecha_promedio >= $mes_actual[0]
                    and $fecha_promedio <= $mes_actual[1]
                ) {
                    $total_egreso_programado = $total_egreso_programado + $vistaEgresoProgramado->monto_programado;
                }
            } else {

                $fecha_promedio = date_frecuencia(
                    $fecha_actual,
                    $vistaEgresoProgramado->fecha_inicio,
                    $vistaEgresoProgramado->fecha_fin,
                    $vistaEgresoProgramado->valor_numerico
                );

                if (
                    $fecha_promedio >= $mes_actual[0]
                    and $fecha_promedio <= $mes_actual[1]
                ) {
                    $total_egreso_programado = $total_egreso_programado + $vistaEgresoProgramado->monto_programado;
                }
            }
        }
    }
    return $total_egreso_programado;
}

function total_ingresos_egresos_saldo_mes($fecha_actual, $comercial)
{
    $mes_actual = mes_actual($fecha_actual);
    $date_actual = $fecha_actual;

    $vistaEgresos = DB::table('vista_egresos')
        ->where('comercial', '=', $comercial)
        ->where('estado', '=', 1)
        ->where('id_user', '=', auth()->id())
        ->whereBetween('fecha', $mes_actual)
        ->orderBy('fecha', 'ASC')
        ->get();

    $vistaIngresos = DB::table('vista_ingresos')
        ->where('comercial', '=', $comercial)
        ->where('estado', '=', 1)
        ->where('id_user', '=', auth()->id())
        ->whereBetween('fecha', $mes_actual)
        ->orderBy('fecha', 'ASC')
        ->get();

    $total_egreso = 0;
    $total_ingreso = 0;

    foreach ($vistaEgresos as $vistaEgreso) {
        $total_egreso = $total_egreso + $vistaEgreso->monto_ejecutado;
    }

    foreach ($vistaIngresos as $vistaIngreso) {
        $total_ingreso = $total_ingreso + $vistaIngreso->monto_ejecutado;
    }

    $vistaEgresoProgramados = DB::table('vista_egreso_programado')
        ->where('comercial', '=', $comercial)
        ->where('estado_egreso_programado', '=', 1)
        ->where('id_user_egreso_programado', '=', auth()->id())
        ->orderBy('fecha_inicio', 'ASC')
        ->get();

    $vistaIngresoProgramados = DB::table('vista_ingreso_programado')
        ->where('comercial', '=', $comercial)
        ->where('estado_ingreso_programado', '=', 1)
        ->where('id_user_ingreso_programado', '=', auth()->id())
        ->orderBy('fecha_inicio', 'ASC')
        ->get();

    $total_egreso_programado = total_monto_programado($date_actual, $mes_actual, $vistaEgresoProgramados);
    $total_ingreso_programado = total_monto_programado($date_actual, $mes_actual, $vistaIngresoProgramados);

    $saldo_programado = $total_ingreso_programado - $total_egreso_programado;

    $saldo_ejecutado = $total_ingreso - $total_egreso;
    $data_labels = ["Ingresos", "Egresos", "Saldo"];
    $data_values = [$total_ingreso, $total_egreso, $saldo_ejecutado];
    $data_ingresos_egresos_mes_labels = json_encode($data_labels);
    $data_ingresos_egresos_mes_values = json_encode($data_values);

    return array(
        $data_ingresos_egresos_mes_labels,
        $data_ingresos_egresos_mes_values,
        $total_ingreso,
        $total_ingreso_programado,
        $total_egreso,
        $total_egreso_programado,
        $saldo_ejecutado,
        $saldo_programado
    );
}

function total_egreso_categoria_mes($fecha_actual, $tipo, $comercial)
{
    $mes_actual = mes_actual($fecha_actual);

    $vistaCategorias = DB::table('vista_categoria_padres')
        ->where('tipo', '=', $tipo)
        ->where('comercial', '=', $comercial)
        ->where('estado', '=', 1)
        ->where('id_user', '=', auth()->id())
        ->orwhere('plantilla', '=', 1)
        ->orderBy('orden', 'ASC')
        ->get();

    $contador = 0;
    $egreso_data = array();
    $egreso_label = array();

    foreach ($vistaCategorias as $vistaCategoria) {

        $monto_egreso = 0;

        $vistaEgresos = DB::table('vista_egresos')
            ->where('comercial', '=', $comercial)
            ->where('estado', '=', 1)
            ->where('id_user', '=', auth()->id())
            ->where('id_padre', '=', $vistaCategoria->id)
            ->whereBetween('fecha', $mes_actual)
            ->orderBy('fecha', 'ASC')
            ->get();

        foreach ($vistaEgresos as $vistaEgreso) {
            $monto_egreso = $monto_egreso + $vistaEgreso->monto_ejecutado;
        }

        $egreso_label[$contador] = $vistaCategoria->categoria;
        $egreso_data[$contador] = $monto_egreso;
        $contador++;
    }

    return array($egreso_label, $egreso_data);
}

function total_categoria_mes($fecha_actual, $categoria, $tipo, $comercial)
{
    $mes_actual = mes_actual($fecha_actual);

    if ($tipo == 2) {
        $vistaEgresos = DB::table('vista_egresos')
            ->where('comercial', '=', $comercial)
            ->where('estado', '=', 1)
            ->where('id_user', '=', auth()->id())
            ->where('id_padre', '=', $categoria)
            ->whereBetween('fecha', $mes_actual)
            ->orderBy('fecha', 'ASC')
            ->get();
    } else {
        $vistaEgresos = DB::table('vista_ingresos')
            ->where('comercial', '=', $comercial)
            ->where('estado', '=', 1)
            ->where('id_user', '=', auth()->id())
            ->where('id_padre', '=', $categoria)
            ->whereBetween('fecha', $mes_actual)
            ->orderBy('fecha', 'ASC')
            ->get();
    }

    $total_egreso = 0;

    foreach ($vistaEgresos as $vistaEgreso) {
        $total_egreso = $total_egreso + $vistaEgreso->monto_ejecutado;
    }

    if ($tipo == 2) {
        $vistaEgresoProgramados = DB::table('vista_egreso_programado')
            ->where('estado_egreso_programado', '=', 1)
            ->where('comercial', '=', $comercial)
            ->where('id_user_egreso_programado', '=', auth()->id())
            ->where('id_padre', '=', $categoria)
            ->orderBy('fecha_inicio', 'ASC')
            ->get();
    } else {
        $vistaEgresoProgramados = DB::table('vista_ingreso_programado')
            ->where('estado_ingreso_programado', '=', 1)
            ->where('comercial', '=', $comercial)
            ->where('id_user_ingreso_programado', '=', auth()->id())
            ->where('id_padre', '=', $categoria)
            ->orderBy('fecha_inicio', 'ASC')
            ->get();
    }

    $total_egreso_programado = total_monto_programado($fecha_actual, $mes_actual, $vistaEgresoProgramados);

    return array(
        $total_egreso,
        $total_egreso_programado,
    );
}

function total_categoria_anual($fecha_actual, $categoria, $tipo, $comercial)
{
    for ($i = 0; $i < 12; $i++) {

        $fecha = strtotime($fecha_actual);
        $ano_actual = date("Y", $fecha);
        $fecha_inicial = $ano_actual . "-01-01";
        $frecuencia_texto = "+" . $i . " month";
        $date_future = strtotime($frecuencia_texto, strtotime($fecha_inicial));
        $fecha = date('Y-m-d', $date_future);

        list(
            $egreso_categoria_anual[$i],
            $egreso_programado_categoria_anual[$i]
        ) = total_categoria_mes($fecha, $categoria, $tipo, $comercial);
    }

    return array(
        $egreso_categoria_anual,
        $egreso_programado_categoria_anual,
    );
}

function total_subcategoria_mes($fecha_actual, $categoria, $tipo, $comercial)
{
    $mes_actual = mes_actual($fecha_actual);

    if ($tipo == 2) {
        $vistaEgresos = DB::table('vista_egresos')
            ->where('comercial', '=', $comercial)
            ->where('estado', '=', 1)
            ->where('id_user', '=', auth()->id())
            ->where('id_categoria', '=', $categoria)
            ->whereBetween('fecha', $mes_actual)
            ->orderBy('fecha', 'ASC')
            ->get();
    } else {
        $vistaEgresos = DB::table('vista_ingresos')
            ->where('comercial', '=', $comercial)
            ->where('estado', '=', 1)
            ->where('id_user', '=', auth()->id())
            ->where('id_categoria', '=', $categoria)
            ->whereBetween('fecha', $mes_actual)
            ->orderBy('fecha', 'ASC')
            ->get();
    }

    $total_egreso = 0;

    foreach ($vistaEgresos as $vistaEgreso) {
        $total_egreso = $total_egreso + $vistaEgreso->monto_ejecutado;
    }

    if ($tipo == 2) {
        $vistaEgresoProgramados = DB::table('vista_egreso_programado')
            ->where('comercial', '=', $comercial)
            ->where('estado_egreso_programado', '=', 1)
            ->where('id_user_egreso_programado', '=', auth()->id())
            ->where('id_categoria', '=', $categoria)
            ->orderBy('fecha_inicio', 'ASC')
            ->get();
    } else {
        $vistaEgresoProgramados = DB::table('vista_ingreso_programado')
            ->where('comercial', '=', $comercial)
            ->where('estado_ingreso_programado', '=', 1)
            ->where('id_user_ingreso_programado', '=', auth()->id())
            ->where('id_categoria', '=', $categoria)
            ->orderBy('fecha_inicio', 'ASC')
            ->get();
    }

    $total_egreso_programado = total_monto_programado($fecha_actual, $mes_actual, $vistaEgresoProgramados);

    return array(
        $total_egreso,
        $total_egreso_programado,
    );
}

function total_subcategoria_anual($fecha_actual, $categoria, $tipo, $comercial)
{
    for ($i = 0; $i < 12; $i++) {

        $fecha = strtotime($fecha_actual);
        $ano_actual = date("Y", $fecha);
        $fecha_inicial = $ano_actual . "-01-01";
        $frecuencia_texto = "+" . $i . " month";
        $date_future = strtotime($frecuencia_texto, strtotime($fecha_inicial));
        $fecha = date('Y-m-d', $date_future);

        list(
            $total_egreso_subcategoria[$i],
            $total_egreso_programado_subcategoria[$i]
        ) = total_subcategoria_mes($fecha, $categoria, $tipo, $comercial);
    }

    $data_total_egreso_subcategoria = json_encode($total_egreso_subcategoria);
    $data_total_egreso_programado_subcategoria = json_encode($total_egreso_programado_subcategoria);

    return array(
        $data_total_egreso_subcategoria,
        $data_total_egreso_programado_subcategoria,
    );
}

function titulo_cuenta($id)
{
    if ($id == 1) {
        $titulo = "Cuentas por Cobrar";
    } else {
        $titulo = "Cuentas por Pagar";
    }

    return $titulo;
}

function suma_cuentas($cuentaTimes, $id, $mes_actual)
{
    $total_cuenta = array();
    $label_cuenta = array();
    $total = 0;
    $contador = 0;

    foreach ($cuentaTimes as $cuentaTime) {
        $label_cuenta[$contador] = $cuentaTime->tipo_categoria;
        $total_cuenta[$contador] = 0;
        $vistaCuentaTimes = DB::table('vista_cuentas')
            ->where('estado', '=', 1)
            ->where('id_tipo_cuenta', '=', $id)
            ->where('id_tipo_time', '=', $cuentaTime->id)
            ->whereBetween('fecha', $mes_actual)
            ->where('id_user', '=', auth()->id())
            ->orderBy('id_tipo_cuenta', 'ASC')
            ->orderBy('id_tipo_time', 'ASC')
            ->orderBy('fecha', 'ASC')
            ->get();

        foreach ($vistaCuentaTimes as $vistaCuentaTime) {
            $total_cuenta[$contador] = $total_cuenta[$contador] + $vistaCuentaTime->monto;
            $total = $total + $vistaCuentaTime->monto;
        }

        ++$contador;
    }

    return array(
        $contador,
        $label_cuenta,
        $total_cuenta,
        $total
    );
}

function dias_calendario($date, $dia_semana)
{
    $fechaActual = $date;
    $dias_faltantes = 7 - $dia_semana;
    $contador = $dia_semana;

    for ($i = 0; $i < $dia_semana; $i++) {
        $dias_diferencia = $i - $dia_semana + 1;
        $diferencia_text = $dias_diferencia . " day";
        $date_future = strtotime($diferencia_text, strtotime($fechaActual));
        $dia = diaEs($date_future);
        $calendario[$i] = $dia . " " . date('d F', $date_future);
        $fecha[$i] = date('Y_m_d', $date_future);
    }

    for ($i = 1; $i <= $dias_faltantes; $i++) {
        $diferencia_text = "+" . $i . " day";
        $date_future = strtotime($diferencia_text, strtotime($fechaActual));
        $dia = diaEs($date_future);
        $calendario[$contador] = $dia . " " . date('d F', $date_future);
        $fecha[$contador] = date('Y_m_d', $date_future);
        $contador++;
    }

    return array(
        $calendario,
        $fecha,
    );
}

function fechas_first_last($fecha_actual)
{
    $fecha_actual = strtotime($fecha_actual);
    $fecha[0] = date("Y", $fecha_actual);
    $fecha[1] = date("m", $fecha_actual);
    return $fecha;
}

function total_tipo_mes($fecha_actual, $tipo, $comercial)
{
    $contador = 0;
    $nombre_categoria = array();
    $egreso_categoria_mes = array();
    $egreso_categoria_programado_mes = array();
    $diferencia_egreso_categoria_mes = array();
    $porcentaje_egreso_categoria_mes = array();

    $vistaCategorias = DB::table('vista_categoria_padres')
        ->where('tipo', '=', $tipo)
        ->where('comercial', '=', $comercial)
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

    return array(
        $nombre_categoria,
        $egreso_categoria_mes,
        $egreso_categoria_programado_mes,
        $diferencia_egreso_categoria_mes,
        $porcentaje_egreso_categoria_mes,
        $total_egreso_categoria_mes,
        $total_egreso_categoria_programado_mes,
        $total_diferencia_egreso_categoria_mes,
        $total_porcentaje_egreso_categoria_mes,
        $contador,
    );
}

function subcategoria_mes($fecha_actual, $categoria, $comercial)
{
    $contador = 0;
    $tipo = 0;
    $nombre_subcategoria = array();
    $egreso_subcategoria_mes = array();
    $egreso_subcategoria_programado_mes = array();
    $diferencia_egreso_subcategoria_mes = array();
    $porcentaje_egreso_subcategoria_mes = array();

    $vistaCategorias = DB::table('vista_categorias')
        ->where('id_padre', '=', $categoria)
        ->where('comercial', '=', $comercial)
        ->where('estado', '=', 1)
        ->orderBy('orden', 'ASC')
        ->get();

    $total_egreso_subcategoria_mes = 0;
    $total_egreso_subcategoria_programado_mes = 0;
    $total_diferencia_egreso_subcategoria_mes = 0;
    $total_porcentaje_egreso_subcategoria_mes = 0;

    foreach ($vistaCategorias as $vistaCategoria) {
        list(
            $egreso_subcategoria_mes[$contador],
            $egreso_subcategoria_programado_mes[$contador]
        ) = total_subcategoria_mes($fecha_actual, $vistaCategoria->id, $vistaCategoria->tipo, $comercial);

        $diferencia_egreso_subcategoria_mes[$contador] = $egreso_subcategoria_mes[$contador] - $egreso_subcategoria_programado_mes[$contador];

        if ($egreso_subcategoria_programado_mes[$contador] != 0) {
            $porcentaje_egreso_subcategoria_mes[$contador] = ($egreso_subcategoria_mes[$contador] / $egreso_subcategoria_programado_mes[$contador]) * 100;
        } else {
            $porcentaje_egreso_subcategoria_mes[$contador] = 0;
        }

        $nombre_subcategoria[$contador] = $vistaCategoria->categoria;

        $total_egreso_subcategoria_mes = $total_egreso_subcategoria_mes + $egreso_subcategoria_mes[$contador];
        $total_egreso_subcategoria_programado_mes = $total_egreso_subcategoria_programado_mes + $egreso_subcategoria_programado_mes[$contador];
        $total_diferencia_egreso_subcategoria_mes = $total_diferencia_egreso_subcategoria_mes + $diferencia_egreso_subcategoria_mes[$contador];
        $total_porcentaje_egreso_subcategoria_mes = $total_porcentaje_egreso_subcategoria_mes + $porcentaje_egreso_subcategoria_mes[$contador];

        $contador++;
        $tipo = $vistaCategoria->tipo;
    }

    return array(
        $nombre_subcategoria,
        $egreso_subcategoria_mes,
        $egreso_subcategoria_programado_mes,
        $diferencia_egreso_subcategoria_mes,
        $porcentaje_egreso_subcategoria_mes,
        $total_egreso_subcategoria_mes,
        $total_egreso_subcategoria_programado_mes,
        $total_diferencia_egreso_subcategoria_mes,
        $total_porcentaje_egreso_subcategoria_mes,
        $contador,
        $tipo,
    );
}

function total_categoria_dia($fecha, $categoria, $tipo, $comercial)
{

    if ($tipo == 2) {
        $vistaIngresos = DB::table('vista_egresos')
            ->where('id_padre', '=', $categoria)
            ->where('fecha', '=', $fecha)
            ->where('comercial', '=', $comercial)
            ->where('id_user', '=', auth()->id())
            ->where('estado', '=', 1)
            ->orderBy('id', 'ASC')
            ->get();
    } else {
        $vistaIngresos = DB::table('vista_ingresos')
            ->where('id_padre', '=', $categoria)
            ->where('fecha', '=', $fecha)
            ->where('comercial', '=', $comercial)
            ->where('id_user', '=', auth()->id())
            ->where('estado', '=', 1)
            ->orderBy('id', 'ASC')
            ->get();
    }

    $monto_total = 0;

    foreach ($vistaIngresos as $vistaIngreso) {
        $monto_total = $monto_total + $vistaIngreso->monto_ejecutado;
    }

    return $monto_total;
}
