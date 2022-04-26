<?php

namespace App\Http\Controllers;

use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;

include('Function/function.php');

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

        $navegador_mobile = navegador_mobile();
        $fecha_actual = date("Y-m-d");
        $mes_actual_text = date("F Y");

        list(
            $data_ingresos_egresos_mes_labels,
            $data_ingresos_egresos_mes_values,
            $total_ingreso_bar,
            $total_ingreso_programado_bar,
            $total_egreso_bar,
            $total_egreso_programado_bar,
            $saldo_ejecutado_bar,
            $saldo_programado_bar
        ) = total_ingresos_egresos_saldo_mes($fecha_actual);

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

        $tipo = 1;
        $ingreso_categoria_anual_corriente = array();
        $ingreso_programado_categoria_anual_corriente = array();
        $ingreso_categoria_anual_tasa_fija = array();
        $ingreso_programado_categoria_anual_tasa_fija = array();
        $ingreso_categoria_anual_retorno = array();
        $ingreso_programado_categoria_anual_retorno = array();
        $categoria_corriente = 19; // Ingresos Corrientes
        $categoria_tasa_fija = 24; // Inversiones Tasa Fija Retorno
        $categoria_retorno = 35; // Inversiones Retorno Fluctuante

        list(
            $ingreso_categoria_anual_corriente,
            $ingreso_programado_categoria_anual_corriente
        ) = total_categoria_anual($fecha_actual, $categoria_corriente, $tipo);

        $data_ingreso_categoria_anual_corriente = json_encode($ingreso_categoria_anual_corriente);
        $data_ingreso_programado_categoria_anual_corriente = json_encode($ingreso_programado_categoria_anual_corriente);

        list(
            $ingreso_categoria_anual_tasa_fija,
            $ingreso_programado_categoria_anual_tasa_fija
        ) = total_categoria_anual($fecha_actual, $categoria_tasa_fija, $tipo);

        $data_ingreso_categoria_anual_tasa_fija = json_encode($ingreso_categoria_anual_tasa_fija);
        $data_ingreso_programado_categoria_anual_tasa_fija = json_encode($ingreso_programado_categoria_anual_tasa_fija);

        list(
            $ingreso_categoria_anual_retorno,
            $ingreso_programado_categoria_anual_retorno
        ) = total_categoria_anual($fecha_actual, $categoria_retorno, $tipo);

        $data_ingreso_categoria_anual_retorno = json_encode($ingreso_categoria_anual_retorno);
        $data_ingreso_programado_categoria_anual_retorno = json_encode($ingreso_programado_categoria_anual_retorno);

        return view('dashboard', compact(
            'navegador_mobile',
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
            'data_ingreso_categoria_anual_corriente',
            'data_ingreso_programado_categoria_anual_corriente',
            'data_ingreso_categoria_anual_tasa_fija',
            'data_ingreso_programado_categoria_anual_tasa_fija',
            'data_ingreso_categoria_anual_retorno',
            'data_ingreso_programado_categoria_anual_retorno',
            'total_ingreso_bar',
            'total_ingreso_programado_bar',
            'total_egreso_bar',
            'total_egreso_programado_bar',
            'saldo_ejecutado_bar',
            'saldo_programado_bar',
            'diferencia_ingreso_bar',
            'diferencia_egreso_bar',
            'porcentaje_ingreso_bar',
            'porcentaje_egreso_bar',
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
