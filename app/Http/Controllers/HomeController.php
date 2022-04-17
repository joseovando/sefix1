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

function mes_actual2($fecha_actual)
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

function date_frecuencia2($fecha_actual, $fecha_inicial, $fecha_final, $frecuencia)
{
    $mes_actual = mes_actual2($fecha_actual);
    $fecha_frecuencia = $fecha_inicial;
    $contador = 1;

    //echo "PASO_4 " . $fecha_actual . " FECHA FRECUENCIA " . $fecha_frecuencia . " < " . $mes_actual[0] . "<br>";

    if ($fecha_inicial < $fecha_final) {

        while ($fecha_frecuencia < $mes_actual[0]) {
            //echo "while date_frecuencia " . $fecha_frecuencia . " < " . $mes_actual[0] . "<br>";
            $frecuencia_neo = $frecuencia * $contador;
            $frecuencia_texto = "+" . $frecuencia_neo . " month";
            $date_future = strtotime($frecuencia_texto, strtotime($fecha_inicial));
            $fecha_frecuencia = date('Y-m-d', $date_future);
            $contador++;
        }

        if ($fecha_frecuencia > $fecha_final) {
            $contador = 1;

            while ($fecha_frecuencia > $mes_actual[1]) {
                //echo "date_frecuencia " . $fecha_frecuencia . " > " . $mes_actual[1] . "<br>";
                $frecuencia = $frecuencia * $contador;
                $frecuencia_texto = "-" . $frecuencia . " month";
                $date_future = strtotime($frecuencia_texto, strtotime($fecha_frecuencia));
                $fecha_frecuencia = date('Y-m-d', $date_future);
                $contador++;
            }
        }
    }

    //echo "RESULTADO FECHA PROMEDIO " . $fecha_frecuencia . "<br>";
    return $fecha_frecuencia;
}

function date_frecuencia_caducidad2($fecha_actual, $fecha_inicial, $frecuencia)
{
    $mes_actual = mes_actual2($fecha_actual);
    $fecha_frecuencia = $fecha_inicial;
    $contador = 1;

    //echo "PASO_4 " . $fecha_actual . " FECHA FRECUENCIA " . $fecha_frecuencia . " < " . $mes_actual[0] . "<br>";

    while ($fecha_frecuencia < $mes_actual[0]) {
        //echo "date_frecuencia_caducidad " . $fecha_frecuencia . " < " . $mes_actual[0] . "<br>";
        $frecuencia_neo = $frecuencia * $contador;
        $frecuencia_texto = "+" . $frecuencia_neo . " month";
        $date_future = strtotime($frecuencia_texto, strtotime($fecha_inicial));
        $fecha_frecuencia = date('Y-m-d', $date_future);
        $contador++;
    }

    //echo "RESULTADO FECHA PROMEDIO " . $fecha_frecuencia . "<br>";
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
                //echo "";
            }
        } else {
            $caducidad = $vistaEgresoProgramado->sin_caducidad + 0;

            if ($caducidad == 1) {

                //echo "PASO_3 " . $fecha_actual . " PROGRAMADO ID " . $vistaEgresoProgramado->id . " date_frecuencia_caducidad<br>";

                $fecha_promedio = date_frecuencia_caducidad2(
                    $fecha_actual,
                    $vistaEgresoProgramado->fecha_inicio,
                    $vistaEgresoProgramado->valor_numerico
                );

                if (
                    $fecha_promedio >= $mes_actual[0]
                    and $fecha_promedio <= $mes_actual[1]
                ) {
                    $total_egreso_programado = $total_egreso_programado + $vistaEgresoProgramado->monto_programado;
                    //echo "total_egreso_programado " . $total_egreso_programado . "<br>";
                }
            } else {

                //echo "PASO_3 " . $fecha_actual . " date_frecuencia<br>";

                $fecha_promedio = date_frecuencia2(
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
                    //echo "total_egreso_programado " . $total_egreso_programado . "<br>";
                }
            }
        }
    }
    return $total_egreso_programado;
}

function total_ingresos_egresos_saldo_mes($fecha_actual)
{
    $mes_actual = mes_actual2($fecha_actual);
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

    //echo "PASO_2 date_actual " . $date_actual . " vista egreso<br>";
    $total_egreso_programado = total_monto_programado($date_actual, $mes_actual, $vistaEgresoProgramados);
    //echo "PASO_2 date_actual " . $date_actual . " vista ingreso<br>";
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

function total_egreso_categoria_mes($fecha_actual, $tipo)
{
    $mes_actual = mes_actual2($fecha_actual);

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

function total_categoria_mes($fecha_actual, $categoria, $tipo)
{
    $mes_actual = mes_actual2($fecha_actual);

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

    $total_egreso_programado = total_monto_programado($fecha_actual, $mes_actual, $vistaEgresoProgramados);

    return array(
        $total_egreso,
        $total_egreso_programado,
    );
}

function total_categoria_anual($fecha_actual, $categoria, $tipo)
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
        ) = total_categoria_mes($fecha, $categoria, $tipo);
    }

    return array(
        $egreso_categoria_anual,
        $egreso_programado_categoria_anual,
    );
}

function total_subcategoria_mes($fecha_actual, $categoria, $tipo)
{
    $mes_actual = mes_actual2($fecha_actual);

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

    $total_egreso_programado = total_monto_programado($fecha_actual, $mes_actual, $vistaEgresoProgramados);

    return array(
        $total_egreso,
        $total_egreso_programado,
    );
}

function total_subcategoria_anual($fecha_actual, $categoria, $tipo)
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
        ) = total_subcategoria_mes($fecha, $categoria, $tipo);
    }

    $data_total_egreso_subcategoria = json_encode($total_egreso_subcategoria);
    $data_total_egreso_programado_subcategoria = json_encode($total_egreso_programado_subcategoria);

    return array(
        $data_total_egreso_subcategoria,
        $data_total_egreso_programado_subcategoria,
    );
}

namespace App\Http\Controllers;

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

            //echo "<br><br><hr><br><br>PASO_1 ----> fecha_anual " . $fecha . "<br>";

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

            //echo "ingreso_programado " . $total_ingreso_programado_mes[$i] . "<br>";
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

        // echo $data_ingreso_categoria_anual_corriente . "<br>";
        // echo $data_ingreso_programado_categoria_anual_corriente . "<br>";

        list(
            $ingreso_categoria_anual_tasa_fija,
            $ingreso_programado_categoria_anual_tasa_fija
        ) = total_categoria_anual($fecha_actual, $categoria_tasa_fija, $tipo);

        $data_ingreso_categoria_anual_tasa_fija = json_encode($ingreso_categoria_anual_tasa_fija);
        $data_ingreso_programado_categoria_anual_tasa_fija = json_encode($ingreso_programado_categoria_anual_tasa_fija);

        // echo $data_ingreso_categoria_anual_tasa_fija . "<br>";
        // echo $data_ingreso_programado_categoria_anual_tasa_fija . "<br>";

        list(
            $ingreso_categoria_anual_retorno,
            $ingreso_programado_categoria_anual_retorno
        ) = total_categoria_anual($fecha_actual, $categoria_retorno, $tipo);

        $data_ingreso_categoria_anual_retorno = json_encode($ingreso_categoria_anual_retorno);
        $data_ingreso_programado_categoria_anual_retorno = json_encode($ingreso_programado_categoria_anual_retorno);

        // echo $data_ingreso_categoria_anual_retorno . "<br>";
        // echo $data_ingreso_programado_categoria_anual_retorno . "<br>";

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
