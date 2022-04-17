<?php
function meses3()
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

function mes_actual3($fecha_actual)
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

function date_frecuencia3($fecha_actual, $fecha_inicial, $fecha_final, $frecuencia)
{
    $mes_actual = mes_actual3($fecha_actual);
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

function date_frecuencia_caducidad3($fecha_actual, $fecha_inicial, $frecuencia)
{
    $mes_actual = mes_actual3($fecha_actual);
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

function total_monto_programado3($fecha_actual, $mes_actual, $array_programados)
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

                $fecha_promedio = date_frecuencia_caducidad3(
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

                $fecha_promedio = date_frecuencia3(
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

function total_ingresos_egresos_saldo_mes3($fecha_actual)
{
    $mes_actual = mes_actual3($fecha_actual);
    $date_actual = $fecha_actual;

    $vistaEgresos = DB::table('vista_egresos')
        ->where('estado', '=', 1)
        ->where('id_user', '=', auth()->id())
        ->whereBetween('fecha', $mes_actual)
        ->orderBy('fecha', 'ASC')
        ->get();

    $vistaIngresos = DB::table('vista_ingresos')
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
        ->where('estado_egreso_programado', '=', 1)
        ->where('id_user_egreso_programado', '=', auth()->id())
        ->orderBy('fecha_inicio', 'ASC')
        ->get();

    $vistaIngresoProgramados = DB::table('vista_ingreso_programado')
        ->where('estado_ingreso_programado', '=', 1)
        ->where('id_user_ingreso_programado', '=', auth()->id())
        ->orderBy('fecha_inicio', 'ASC')
        ->get();

    $total_egreso_programado = total_monto_programado3($date_actual, $mes_actual, $vistaEgresoProgramados);
    $total_ingreso_programado = total_monto_programado3($date_actual, $mes_actual, $vistaIngresoProgramados);

    $saldo_programado = $total_ingreso_programado - $total_egreso_programado;

    $saldo_ejecutado = $total_ingreso - $total_egreso;
    $data_labels = ["Total Ingresos", "Total Egresos", "Saldo"];
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

function total_egreso_categoria_mes3($fecha_actual, $tipo)
{
    $mes_actual = mes_actual3($fecha_actual);

    $vistaCategorias = DB::table('vista_categoria_padres')
        ->where('tipo', '=', $tipo)
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

function total_categoria_mes3($fecha_actual, $categoria, $tipo)
{
    $mes_actual = mes_actual3($fecha_actual);

    if ($tipo == 2) {
        $vistaEgresos = DB::table('vista_egresos')
            ->where('estado', '=', 1)
            ->where('id_user', '=', auth()->id())
            ->where('id_padre', '=', $categoria)
            ->whereBetween('fecha', $mes_actual)
            ->orderBy('fecha', 'ASC')
            ->get();
    } else {
        $vistaEgresos = DB::table('vista_ingresos')
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
            ->where('id_user_egreso_programado', '=', auth()->id())
            ->where('id_padre', '=', $categoria)
            ->orderBy('fecha_inicio', 'ASC')
            ->get();
    } else {
        $vistaEgresoProgramados = DB::table('vista_ingreso_programado')
            ->where('estado_ingreso_programado', '=', 1)
            ->where('id_user_ingreso_programado', '=', auth()->id())
            ->where('id_padre', '=', $categoria)
            ->orderBy('fecha_inicio', 'ASC')
            ->get();
    }

    $total_egreso_programado = total_monto_programado3($fecha_actual, $mes_actual, $vistaEgresoProgramados);

    return array(
        $total_egreso,
        $total_egreso_programado,
    );
}

function total_tipo_mes($fecha_actual, $tipo)
{
    $contador = 0;
    $nombre_categoria = array();
    $egreso_categoria_mes = array();
    $egreso_categoria_programado_mes = array();
    $diferencia_egreso_categoria_mes = array();
    $porcentaje_egreso_categoria_mes = array();

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
        ) = total_categoria_mes3($fecha_actual, $vistaCategoria->id, $tipo);

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

function total_subcategoria_mes3($fecha_actual, $categoria, $tipo)
{
    $mes_actual = mes_actual3($fecha_actual);

    if ($tipo == 2) {
        $vistaEgresos = DB::table('vista_egresos')
            ->where('estado', '=', 1)
            ->where('id_user', '=', auth()->id())
            ->where('id_categoria', '=', $categoria)
            ->whereBetween('fecha', $mes_actual)
            ->orderBy('fecha', 'ASC')
            ->get();
    } else {
        $vistaEgresos = DB::table('vista_ingresos')
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
            ->where('estado_egreso_programado', '=', 1)
            ->where('id_user_egreso_programado', '=', auth()->id())
            ->where('id_categoria', '=', $categoria)
            ->orderBy('fecha_inicio', 'ASC')
            ->get();
    } else {
        $vistaEgresoProgramados = DB::table('vista_ingreso_programado')
            ->where('estado_ingreso_programado', '=', 1)
            ->where('id_user_ingreso_programado', '=', auth()->id())
            ->where('id_categoria', '=', $categoria)
            ->orderBy('fecha_inicio', 'ASC')
            ->get();
    }

    $total_egreso_programado = total_monto_programado3($fecha_actual, $mes_actual, $vistaEgresoProgramados);

    return array(
        $total_egreso,
        $total_egreso_programado,
    );
}

function total_categoria_anual3($fecha_actual, $categoria, $tipo)
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
        ) = total_categoria_mes3($fecha, $categoria, $tipo);
    }

    return array(
        $egreso_categoria_anual,
        $egreso_programado_categoria_anual,
    );
}

function subcategoria_mes($fecha_actual, $categoria)
{
    $contador = 0;
    $nombre_subcategoria = array();
    $egreso_subcategoria_mes = array();
    $egreso_subcategoria_programado_mes = array();
    $diferencia_egreso_subcategoria_mes = array();
    $porcentaje_egreso_subcategoria_mes = array();

    $vistaCategorias = DB::table('vista_categorias')
        ->where('id_padre', '=', $categoria)
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
        ) = total_subcategoria_mes3($fecha_actual, $vistaCategoria->id, $vistaCategoria->tipo);

        //echo $vistaCategoria->categoria . " ejec " . $egreso_subcategoria_mes[$contador] . " prog " . $egreso_subcategoria_programado_mes[$contador] . "<br>";

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

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($mes, $ano, Request $request)
    {
        if ($ano == 1 and $mes == 1) {
            $ano = date("Y");
            $mes = date("m");
        }
    
        if (request('llave_form') == 1) {
            $ano_actual = request('ano_actual');
            $ano_actual_inicio = $ano_actual - 20;
            $ano_actual_fin = $ano_actual + 20;
            $mes_actual = request('mes_actual');
            $fecha_actual = $ano_actual . "-" . $mes_actual . "-01";

            $meses = meses3();
        } else {
            $ano_actual = $ano;
            $ano_actual_inicio = $ano_actual - 20;
            $ano_actual_fin = $ano_actual + 20;
            $mes_actual = $mes;
            $fecha_actual = $ano_actual . "-" . $mes_actual . "-01";
            $meses = meses3();
        }

        $date_future = strtotime('-0 day', strtotime($fecha_actual));
        $mes_actual_text = date("F Y", $date_future);

        list(
            $data_ingresos_egresos_mes_labels,
            $data_ingresos_egresos_mes_values,
            $total_ingreso_bar,
            $total_ingreso_programado_bar,
            $total_egreso_bar,
            $total_egreso_programado_bar,
            $saldo_ejecutado_bar,
            $saldo_programado_bar
        ) = total_ingresos_egresos_saldo_mes3($fecha_actual);

        $diferencia_ingreso_bar = $total_ingreso_bar - $total_ingreso_programado_bar;
        $diferencia_egreso_bar = $total_egreso_bar - $total_egreso_programado_bar;

        if ($total_ingreso_programado_bar != 0) {
            $porcentaje_ingreso_bar = ($total_ingreso_bar / $total_ingreso_programado_bar) * 100;
        } else {
            $porcentaje_ingreso_bar = 0;
        }

        if ($total_egreso_programado_bar != 0) {
            $porcentaje_egreso_bar = ($total_egreso_bar / $total_egreso_programado_bar) * 100;
        } else {
            $porcentaje_egreso_bar = 0;
        }

        $total_ingreso_mes = array();
        $total_ingreso_programado_mes = array();
        $total_egreso_mes = array();
        $total_egreso_programado_mes = array();

        for ($i = 0; $i < 12; $i++) {

            $fecha = strtotime($fecha_actual);
            $ano_actual = date("Y", $fecha);
            $fecha_inicial = $ano_actual . "-01-01";
            $frecuencia_texto = "+" . $i . " month";
            $date_future = strtotime($frecuencia_texto, strtotime($fecha_inicial));
            $fecha = date('Y-m-d', $date_future);

            list(
                $data_labels,
                $data_values,
                $total_ingreso_mes[$i],
                $total_ingreso_programado_mes[$i],
                $total_egreso_mes[$i],
                $total_egreso_programado_mes[$i],
                $saldo_ejecutado_mes,
                $saldo_programado_mes
            ) = total_ingresos_egresos_saldo_mes3($fecha);
        }

        $data_total_ingreso_mes = json_encode($total_ingreso_mes);
        $data_total_ingreso_programado_mes = json_encode($total_ingreso_programado_mes);
        $data_total_egreso_mes = json_encode($total_egreso_mes);
        $data_total_egreso_programado_mes = json_encode($total_egreso_programado_mes);

        $tipo = 2;

        list($egreso_categoria_label, $egreso_categoria_data) = total_egreso_categoria_mes3($fecha_actual, $tipo);

        $data_egreso_categoria_label = json_encode($egreso_categoria_label);
        $data_egreso_categoria_data = json_encode($egreso_categoria_data);

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
            ) = total_categoria_mes3($fecha_actual, $vistaCategoria->id, $tipo);

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

        return view('reportes.index', compact(
            'ano_actual',
            'ano_actual_inicio',
            'ano_actual_fin',
            'meses',
            'mes_actual',
            'fecha_actual',
            'mes_actual_text',
            'total_ingreso_bar',
            'total_ingreso_programado_bar',
            'diferencia_ingreso_bar',
            'porcentaje_ingreso_bar',
            'total_egreso_bar',
            'total_egreso_programado_bar',
            'diferencia_egreso_bar',
            'porcentaje_egreso_bar',
            'saldo_ejecutado_bar',
            'saldo_programado_bar',
            'data_ingresos_egresos_mes_labels',
            'data_ingresos_egresos_mes_values',
            'data_total_ingreso_mes',
            'data_total_ingreso_programado_mes',
            'data_total_egreso_mes',
            'data_total_egreso_programado_mes',
        ));
    }

    public function categoria($mes, $ano, $tipo, Request $request)
    {
        if ($ano == 1 and $mes == 1) {
            $ano = date("Y");
            $mes = date("m");
        }

        if (request('llave_form') == 1) {
            $ano_actual = request('ano_actual');
            $ano_actual_inicio = $ano_actual - 20;
            $ano_actual_fin = $ano_actual + 20;
            $mes_actual = request('mes_actual');
            $fecha_actual = $ano_actual . "-" . $mes_actual . "-01";

            $meses = meses3();
        } else {
            $ano_actual = $ano;
            $ano_actual_inicio = $ano_actual - 20;
            $ano_actual_fin = $ano_actual + 20;
            $mes_actual = $mes;
            $fecha_actual = $ano_actual . "-" . $mes_actual . "-01";
            $meses = meses3();
        }

        $date_future = strtotime('-0 day', strtotime($fecha_actual));
        $mes_actual_text = date("F Y", $date_future);

        list(
            $nombre_categoria,
            $egreso_categoria_mes,
            $egreso_categoria_programado_mes,
            $diferencia_egreso_categoria_mes,
            $porcentaje_egreso_categoria_mes,
            $total_egreso_categoria_mes,
            $total_egreso_categoria_programado_mes,
            $total_diferencia_egreso_categoria_mes,
            $total_porcentaje_egreso_categoria_mes,
            $contador
        ) = total_tipo_mes($fecha_actual, $tipo);

        $data_nombre_categoria = json_encode($nombre_categoria);
        $data_egreso_categoria_mes = json_encode($egreso_categoria_mes);
        $data_egreso_categoria_programado_mes = json_encode($egreso_categoria_programado_mes);

        for ($i = 0; $i < 12; $i++) {

            $fecha = strtotime($fecha_actual);
            $ano_actual = date("Y", $fecha);
            $fecha_inicial = $ano_actual . "-01-01";
            $frecuencia_texto = "+" . $i . " month";
            $date_future = strtotime($frecuencia_texto, strtotime($fecha_inicial));
            $fecha = date('Y-m-d', $date_future);

            list(
                $data_labels,
                $data_values,
                $total_ingreso_mes[$i],
                $total_ingreso_programado_mes[$i],
                $total_egreso_mes[$i],
                $total_egreso_programado_mes[$i],
                $saldo_ejecutado_mes,
                $saldo_programado_mes
            ) = total_ingresos_egresos_saldo_mes3($fecha);
        }

        $data_total_ingreso_mes = json_encode($total_ingreso_mes);
        $data_total_ingreso_programado_mes = json_encode($total_ingreso_programado_mes);
        $data_total_egreso_mes = json_encode($total_egreso_mes);
        $data_total_egreso_programado_mes = json_encode($total_egreso_programado_mes);

        return view('reportes.categoria', compact(
            'ano_actual',
            'ano_actual_inicio',
            'ano_actual_fin',
            'meses',
            'mes_actual',
            'fecha_actual',
            'mes_actual_text',
            'tipo',
            'contador',
            'nombre_categoria',
            'egreso_categoria_mes',
            'egreso_categoria_programado_mes',
            'diferencia_egreso_categoria_mes',
            'porcentaje_egreso_categoria_mes',
            'total_egreso_categoria_mes',
            'total_egreso_categoria_programado_mes',
            'total_diferencia_egreso_categoria_mes',
            'total_porcentaje_egreso_categoria_mes',
            'data_nombre_categoria',
            'data_egreso_categoria_mes',
            'data_egreso_categoria_programado_mes',
            'data_total_ingreso_mes',
            'data_total_ingreso_programado_mes',
            'data_total_egreso_mes',
            'data_total_egreso_programado_mes',
        ));
    }

    public function tablero()
    {

        $fecha_actual = date("Y-m-d");
        $fecha_actual2 = strtotime($fecha_actual);
        $ano_actual = date("Y", $fecha_actual2);
        $mes_actual = date("m", $fecha_actual2);

        $vistaCategoriaIngresos = DB::table('vista_categoria_padres')
            ->where('tipo', '=', 1)
            ->where('estado', '=', 1)
            ->orderBy('orden', 'ASC')
            ->get();

        $vistaCategoriaEgresos = DB::table('vista_categoria_padres')
            ->where('tipo', '=', 2)
            ->where('estado', '=', 1)
            ->orderBy('orden', 'ASC')
            ->get();

        return view('reportes.tablero', compact(
            'vistaCategoriaIngresos',
            'vistaCategoriaEgresos',
            'ano_actual',
            'mes_actual',
        ));
    }

    public function subcategoria($mes, $ano, $categoria, Request $request)
    {
        if ($ano == 1 and $mes == 1) {
            $ano = date("Y");
            $mes = date("m");
        }

        if (request('llave_form') == 1) {
            $ano_actual = request('ano_actual');
            $ano_actual_inicio = $ano_actual - 20;
            $ano_actual_fin = $ano_actual + 20;
            $mes_actual = request('mes_actual');
            $fecha_actual = $ano_actual . "-" . $mes_actual . "-01";

            $meses = meses3();
        } else {
            $ano_actual = $ano;
            $ano_actual_inicio = $ano_actual - 20;
            $ano_actual_fin = $ano_actual + 20;
            $mes_actual = $mes;
            $fecha_actual = $ano_actual . "-" . $mes_actual . "-01";
            $meses = meses3();
        }

        $date_future = strtotime('-0 day', strtotime($fecha_actual));
        $mes_actual_text = date("F Y", $date_future);

        list(
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
            $tipo
        ) = subcategoria_mes($fecha_actual, $categoria);

        $data_nombre_subcategoria = json_encode($nombre_subcategoria);
        $data_egreso_subcategoria_mes = json_encode($egreso_subcategoria_mes);
        $data_egreso_subcategoria_programado_mes = json_encode($egreso_subcategoria_programado_mes);

        $subcategoria_anual = array();
        $programado_subcategoria_anual = array();

        list(
            $subcategoria_anual,
            $programado_subcategoria_anual
        ) = total_categoria_anual3($fecha_actual, $categoria, $tipo);

        $data_subcategoria_anual = json_encode($subcategoria_anual);
        $data_programado_subcategoria_anual = json_encode($programado_subcategoria_anual);

        return view('reportes.subcategoria', compact(
            'ano_actual',
            'ano_actual_inicio',
            'ano_actual_fin',
            'meses',
            'mes_actual',
            'fecha_actual',
            'mes_actual_text',
            'categoria',
            'contador',
            'nombre_subcategoria',
            'egreso_subcategoria_mes',
            'egreso_subcategoria_programado_mes',
            'diferencia_egreso_subcategoria_mes',
            'porcentaje_egreso_subcategoria_mes',
            'total_egreso_subcategoria_mes',
            'total_egreso_subcategoria_programado_mes',
            'total_diferencia_egreso_subcategoria_mes',
            'total_porcentaje_egreso_subcategoria_mes',
            'data_nombre_subcategoria',
            'data_egreso_subcategoria_mes',
            'data_egreso_subcategoria_programado_mes',
            'data_subcategoria_anual',
            'data_programado_subcategoria_anual',
        ));
    }
}
