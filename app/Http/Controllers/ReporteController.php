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
        include('IncludeReporte/IfAnoMesLlaveFormInclude.php');
        include('IncludeReporte/ComercialSwitchInclude.php');
        include('IncludeReporte/IngresosEgresosSaldoMesInclude.php');
        include('IncludeReporte/IngresosEgresosSaldoAnualInclude.php');
        include('IncludeReporte/GraficaEgresoCategoriaMesInclude.php');
        include('IncludeReporte/EgresoCategoriaMesInclude.php');

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
        include('IncludeReporte/IfAnoMesLlaveFormInclude.php');
        include('IncludeReporte/ComercialSwitchInclude.php');

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
        ) = total_tipo_mes($fecha_actual, $tipo, $comercial);

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
            ) = total_ingresos_egresos_saldo_mes($fecha, $comercial);
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
        include('IncludeReporte/IfAnoMesLlaveFormInclude.php');
        include('IncludeReporte/ComercialSwitchInclude.php');

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
        ) = subcategoria_mes($fecha_actual, $categoria, $comercial);

        $data_nombre_subcategoria = json_encode($nombre_subcategoria);
        $data_egreso_subcategoria_mes = json_encode($egreso_subcategoria_mes);
        $data_egreso_subcategoria_programado_mes = json_encode($egreso_subcategoria_programado_mes);

        $subcategoria_anual = array();
        $programado_subcategoria_anual = array();

        list(
            $subcategoria_anual,
            $programado_subcategoria_anual
        ) = total_categoria_anual($fecha_actual, $categoria, $tipo, $comercial);

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
