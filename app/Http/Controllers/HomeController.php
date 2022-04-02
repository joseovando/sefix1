<?php
function mes_actual($fecha_actual)
{
    $fecha_actual = strtotime($fecha_actual);
    $ano_actual = date("Y", $fecha_actual);
    $mes_actual = date("m", $fecha_actual);
    $mes_despues = $mes_actual + 1;
    $mes[0] = $ano_actual . "-" . $mes_actual . "-01";
    $mes_last = $ano_actual . "-" . $mes_despues . "-01";
    $date_future = strtotime('-1 day', strtotime($mes_last));
    $mes[1] = date('Y-m-d', $date_future);
    return $mes;
}

function date_frecuencia($fecha_inicial, $fecha_final, $frecuencia)
{
    $fecha_actual = date("Y-m-d");
    $fecha_frecuencia = $fecha_inicial;
    $contador = 1;

    if ($fecha_inicial < $fecha_final) {

        while ($fecha_frecuencia < $fecha_actual) {
            $frecuencia_neo = $frecuencia * $contador;
            $frecuencia_texto = "+" . $frecuencia_neo . " day";
            $date_future = strtotime($frecuencia_texto, strtotime($fecha_inicial));
            $fecha_frecuencia = date('Y-m-d', $date_future);
            $contador++;
        }

        if ($fecha_frecuencia > $fecha_final) {
            $contador = 1;

            while ($fecha_final < $fecha_frecuencia) {
                $frecuencia = $frecuencia * $contador;
                $frecuencia_texto = "-" . $frecuencia . " day";
                $date_future = strtotime($frecuencia_texto, strtotime($fecha_frecuencia));
                $fecha_frecuencia = date('Y-m-d', $date_future);
                $contador++;
            }
        }
    }

    return $fecha_frecuencia;
}

function date_frecuencia_caducidad($fecha_inicial, $frecuencia)
{
    $fecha_actual = date("Y-m-d");
    $fecha_frecuencia = $fecha_inicial;
    $contador = 1;

    while ($fecha_frecuencia < $fecha_actual) {
        $frecuencia_neo = $frecuencia * $contador;
        $frecuencia_texto = "+" . $frecuencia_neo . " day";
        $date_future = strtotime($frecuencia_texto, strtotime($fecha_inicial));
        $fecha_frecuencia = date('Y-m-d', $date_future);
        $contador++;
    }

    return $fecha_frecuencia;
}

function total_monto_programado($mes_actual, $array_programados)
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

function total_ingresos_egresos_saldo_mes($fecha_actual)
{
    $mes_actual = mes_actual($fecha_actual);

    $vistaEgresos = DB::table('vista_egresos')
        ->where('estado', '=', 1)
        ->whereBetween('fecha', $mes_actual)
        ->orderBy('fecha', 'ASC')
        ->get();

    $vistaIngresos = DB::table('vista_ingresos')
        ->where('estado', '=', 1)
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
        ->orderBy('fecha_inicio', 'ASC')
        ->get();

    $vistaIngresoProgramados = DB::table('vista_ingreso_programado')
        ->where('estado_ingreso_programado', '=', 1)
        ->orderBy('fecha_inicio', 'ASC')
        ->get();

    $total_egreso_programado = total_monto_programado($mes_actual, $vistaEgresoProgramados);
    $total_ingreso_programado = total_monto_programado($mes_actual, $vistaIngresoProgramados);
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

function total_egreso_categoria_mes($fecha_actual, $tipo)
{
    $mes_actual = mes_actual($fecha_actual);

    $vistaCategorias = DB::table('vista_categoria_padres')
        ->where('tipo', '=', $tipo)
        ->where('estado', '=', 1)
        ->orderBy('orden', 'ASC')
        ->get();

    $contador = 0;
    $egreso_data = array();
    $egreso_label = array();

    foreach ($vistaCategorias as $vistaCategoria) {

        $monto_egreso = 0;

        $vistaEgresos = DB::table('vista_egresos')
            ->where('estado', '=', 1)
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

function total_categoria_mes($fecha_actual, $categoria, $tipo)
{
    $mes_actual = mes_actual($fecha_actual);

    if ($tipo == 2) {
        $vistaEgresos = DB::table('vista_egresos')
            ->where('estado', '=', 1)
            ->where('id_padre', '=', $categoria)
            ->whereBetween('fecha', $mes_actual)
            ->orderBy('fecha', 'ASC')
            ->get();
    } else {
        $vistaEgresos = DB::table('vista_ingresos')
            ->where('estado', '=', 1)
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
            ->where('id_padre', '=', $categoria)
            ->orderBy('fecha_inicio', 'ASC')
            ->get();
    } else {
        $vistaEgresoProgramados = DB::table('vista_ingreso_programado')
            ->where('estado_ingreso_programado', '=', 1)
            ->where('id_padre', '=', $categoria)
            ->orderBy('fecha_inicio', 'ASC')
            ->get();
    }

    $total_egreso_programado = total_monto_programado($mes_actual, $vistaEgresoProgramados);

    return array(
        $total_egreso,
        $total_egreso_programado,
    );
}

namespace App\Http\Controllers;

use App\Models\Envio;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */

    public function index()
    {
        $fecha_actual = date("Y-m-d");
        $mes_actual_text = date("F Y");

        list(
            $data_ingresos_egresos_mes_labels,
            $data_ingresos_egresos_mes_values,
            $total_ingreso,
            $total_ingreso_programado,
            $total_egreso,
            $total_egreso_programado,
            $saldo_ejecutado,
            $saldo_programado
        ) = total_ingresos_egresos_saldo_mes($fecha_actual);

        $diferencia_ingreso = $total_ingreso - $total_ingreso_programado;
        $diferencia_egreso = $total_egreso - $total_egreso_programado;

        if ($total_ingreso_programado != 0) {
            $porcentaje_ingreso = ($total_ingreso / $total_ingreso_programado) * 100;
        } else {
            $porcentaje_ingreso = 0;
        }

        if ($total_egreso_programado != 0) {
            $porcentaje_egreso = ($total_egreso / $total_egreso_programado) * 100;
        } else {
            $porcentaje_egreso = 0;
        }

        $total_ingreso_mes = array();
        $total_ingreso_programado_mes = array();
        $total_egreso_mes = array();
        $total_egreso_programado_mes = array();

        for ($i = 0; $i < 12; $i++) {

            $mes = $i + 1;
            $fecha = strtotime($fecha_actual);
            $ano_actual = date("Y", $fecha);
            $fecha =   $ano_actual . "-" . $mes . "-01";

            list(
                $data_labels,
                $data_values,
                $total_ingreso_mes[$i],
                $total_ingreso_programado_mes[$i],
                $total_egreso_mes[$i],
                $total_egreso_programado_mes[$i],
                $saldo_ejecutado_mes,
                $saldo_programado_mes
            ) = total_ingresos_egresos_saldo_mes($fecha);
        }

        $data_total_ingreso_mes = json_encode($total_ingreso_mes);
        $data_total_ingreso_programado_mes = json_encode($total_ingreso_programado_mes);
        $data_total_egreso_mes = json_encode($total_egreso_mes);
        $data_total_egreso_programado_mes = json_encode($total_egreso_programado_mes);

        $tipo = 2;

        list($egreso_categoria_label, $egreso_categoria_data) = total_egreso_categoria_mes($fecha_actual, $tipo);

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
            ) = total_categoria_mes($fecha_actual, $vistaCategoria->id, $tipo);

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

        return view('dashboard', compact(
            'fecha_actual',
            'mes_actual_text',
            'data_ingresos_egresos_mes_labels',
            'data_ingresos_egresos_mes_values',
            'data_total_ingreso_mes',
            'data_total_ingreso_programado_mes',
            'data_total_egreso_mes',
            'data_total_egreso_programado_mes',
            'data_egreso_categoria_label',
            'data_egreso_categoria_data',
            'total_ingreso',
            'total_ingreso_programado',
            'total_egreso',
            'total_egreso_programado',
            'saldo_ejecutado',
            'saldo_programado',
            'diferencia_ingreso',
            'diferencia_egreso',
            'porcentaje_ingreso',
            'porcentaje_egreso',
            'nombre_categoria',
            'egreso_categoria_mes',
            'egreso_categoria_programado_mes',
            'diferencia_egreso_categoria_mes',
            'porcentaje_egreso_categoria_mes',
            'total_egreso_categoria_mes',
            'total_egreso_categoria_programado_mes',
            'total_diferencia_egreso_categoria_mes',
            'total_porcentaje_egreso_categoria_mes',
            'contador'
        ));
    }
}
