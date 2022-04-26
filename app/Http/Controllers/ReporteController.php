<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

include('Function/function.php');

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

            $meses = meses();
        } else {
            $ano_actual = $ano;
            $ano_actual_inicio = $ano_actual - 20;
            $ano_actual_fin = $ano_actual + 20;
            $mes_actual = $mes;
            $fecha_actual = $ano_actual . "-" . $mes_actual . "-01";
            $meses = meses();
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

            $meses = meses();
        } else {
            $ano_actual = $ano;
            $ano_actual_inicio = $ano_actual - 20;
            $ano_actual_fin = $ano_actual + 20;
            $mes_actual = $mes;
            $fecha_actual = $ano_actual . "-" . $mes_actual . "-01";
            $meses = meses();
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
            ) = total_ingresos_egresos_saldo_mes($fecha);
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

            $meses = meses();
        } else {
            $ano_actual = $ano;
            $ano_actual_inicio = $ano_actual - 20;
            $ano_actual_fin = $ano_actual + 20;
            $mes_actual = $mes;
            $fecha_actual = $ano_actual . "-" . $mes_actual . "-01";
            $meses = meses();
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
        ) = total_categoria_anual($fecha_actual, $categoria, $tipo);

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
