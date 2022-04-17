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

function date_frecuencia_caducidad($fecha_actual, $fecha_inicial, $frecuencia)
{
    $mes_actual = mes_actual($fecha_actual);
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
                    //echo "total_egreso_programado " . $total_egreso_programado . "<br>";
                }
            } else {

                //echo "PASO_3 " . $fecha_actual . " date_frecuencia<br>";

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
                    //echo "total_egreso_programado " . $total_egreso_programado . "<br>";
                }
            }
        }
    }
    return $total_egreso_programado;
}

function total_ingresos_egresos_saldo_mes($fecha_actual)
{
    $mes_actual = mes_actual($fecha_actual);
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

namespace App\Http\Controllers;

use App\Models\Cuenta;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CuentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id, $mes, $ano, Request $request)
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

        $mes = mes_actual($fecha_actual);
        $navegador_mobile = navegador_mobile();
        $titulo = titulo_cuenta($id);

        $vistaCuentas = DB::table('vista_cuentas')
            ->where('estado', '=', 1)
            ->where('id_tipo_cuenta', '=', $id)
            ->whereBetween('fecha', $mes)
            ->where('id_user', '=', auth()->id())
            ->orderBy('id_tipo_cuenta', 'ASC')
            ->orderBy('id_tipo_time', 'ASC')
            ->orderBy('fecha', 'ASC')
            ->get();

        $cuentaTimes = DB::table('cuenta_time')
            ->where('estado', '=', 1)
            ->orderBy('orden', 'ASC')
            ->get();

        list(
            $contador,
            $label_cuenta,
            $total_cuenta,
            $total
        ) = suma_cuentas($cuentaTimes, $id, $mes);

        return view('cuentas.index', compact(
            'ano_actual',
            'ano_actual_inicio',
            'ano_actual_fin',
            'meses',
            'mes_actual',
            'fecha_actual',
            'mes_actual_text',
            'navegador_mobile',
            'id',
            'titulo',
            'vistaCuentas',
            'cuentaTimes',
            'contador',
            'label_cuenta',
            'total_cuenta',
            'total'
        ));
    }

    public function reporte($mes, $ano, Request $request)
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

        $cuentaTipos = DB::table('cuenta_tipo')
            ->where('estado', '=', 1)
            ->orderBy('orden', 'ASC')
            ->get();

        $mes = mes_actual($fecha_actual);

        $total_tipo = array();
        foreach ($cuentaTipos as $cuentaTipo) {

            $cuentaTimes = DB::table('cuenta_time')
                ->where('estado', '=', 1)
                ->orderBy('orden', 'ASC')
                ->get();

            list(
                $contador,
                $label_cuenta,
                $total_cuenta,
                $total
            ) = suma_cuentas($cuentaTimes, $cuentaTipo->id, $mes);

            $total_tipo[$cuentaTipo->id] = $total;
        }

        list(
            $data_ingresos_egresos_mes_labels,
            $data_ingresos_egresos_mes_values,
            $total_ingreso,
            $total_ingreso_programado,
            $total_egreso,
            $total_egreso_programado,
            $saldo_ejecutado_bar,
            $saldo_programado_bar
        ) = total_ingresos_egresos_saldo_mes($fecha_actual);

        $total_ingreso_plus = $total_ingreso + $total_tipo[1];
        $total_egreso_plus = $total_egreso + $total_tipo[2];
        $deficit = $total_ingreso_plus - $total_egreso_plus;

        return view('cuentas.reporte', compact(
            'ano_actual',
            'ano_actual_inicio',
            'ano_actual_fin',
            'meses',
            'mes_actual',
            'fecha_actual',
            'mes_actual_text',
            'cuentaTipos',
            'total_tipo',
            'total_ingreso',
            'total_egreso',
            'total_ingreso_plus',
            'total_egreso_plus',
            'deficit'
        ));
    }

    public function getVistaCuentas($id, $mes, $ano)
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

        $mes = mes_actual($fecha_actual);
        $titulo = titulo_cuenta($id);

        $vistaCuentas = DB::table('vista_cuentas')
            ->where('estado', '=', 1)
            ->where('id_tipo_cuenta', '=', $id)
            ->whereBetween('fecha', $mes)
            ->where('id_user', '=', auth()->id())
            ->orderBy('id_tipo_cuenta', 'ASC')
            ->orderBy('id_tipo_time', 'ASC')
            ->orderBy('fecha', 'ASC')
            ->get();

        $cuentaTimes = DB::table('cuenta_time')
            ->where('estado', '=', 1)
            ->orderBy('orden', 'ASC')
            ->get();

        list(
            $contador,
            $label_cuenta,
            $total_cuenta,
            $total
        ) = suma_cuentas($cuentaTimes, $id, $mes);

        return response()->json([
            'titulo' => $titulo,
            'vistaCuentas' => $vistaCuentas,
            'contador' => $contador,
            'label_cuenta' => $label_cuenta,
            'total_cuenta' => $total_cuenta,
            'total' => $total
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cuenta = Cuenta::where([
            ['id', request('id_cuenta')],
            ['id_user', auth()->id()],
        ])->first();

        if (isset($cuenta->id)) {
            $cuenta->fecha = request('date');
            $cuenta->detalle = request('detalle');
            $cuenta->tipo_cuenta = request('tipo_cuenta');
            $cuenta->tipo_time =  1;
            $cuenta->monto =  request('monto');
            $cuenta->estado = 1;
            $cuenta->id_user = auth()->id();
            $cuenta->update();

            return response()->json(['success' => 'Registro Actualizado Correctamente.']);
        } else {
            $cuenta = new Cuenta();
            $cuenta->fecha = request('date');
            $cuenta->detalle = request('detalle');
            $cuenta->tipo_cuenta = request('tipo_cuenta');
            $cuenta->tipo_time =  1;
            $cuenta->monto =  request('monto');
            $cuenta->estado = 1;
            $cuenta->id_user = auth()->id();
            $cuenta->save();

            return response()->json(['success' => 'Registro Guardado Correctamente.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vistaCuentas = DB::table('vista_cuentas')
            ->where('estado', '=', 1)
            ->where('id', '=', $id)
            ->where('id_user', '=', auth()->id())
            ->orderBy('id_tipo_cuenta', 'ASC')
            ->orderBy('id_tipo_time', 'ASC')
            ->orderBy('fecha', 'ASC')
            ->get();

        return response()->json([
            'vistaCuentas' => $vistaCuentas,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function delete($id)
    {
        $cuenta = Cuenta::where([
            ['id', $id],
            ['id_user', auth()->id()],
        ])->first();

        $cuenta->estado = 0;
        $cuenta->update();

        return response()->json(['success' => 'Registro Eliminado Correctamente, Información Actualizada']);
    }
}
