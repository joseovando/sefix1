<?php

function dias_calendario($date, $dia_semana)
{
    $fechaActual = $date;
    $dias_faltantes = 7 - $dia_semana;
    $contador = $dia_semana;

    for ($i = 0; $i < $dia_semana; $i++) {
        $dias_diferencia = $i - $dia_semana + 1;
        $diferencia_text = $dias_diferencia . " day";
        $date_future = strtotime($diferencia_text, strtotime($fechaActual));
        $calendario[$i] = date('d F', $date_future);
        $fecha[$i] = date('Y_m_d', $date_future);
    }

    for ($i = 1; $i <= $dias_faltantes; $i++) {
        $diferencia_text = "+" . $i . " day";
        $date_future = strtotime($diferencia_text, strtotime($fechaActual));
        $calendario[$contador] = date('d F', $date_future);
        $fecha[$contador] = date('Y_m_d', $date_future);
        $contador++;
    }

    return array(
        $calendario,
        $fecha,
    );
}

function mes_actual4($fecha_actual)
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

function date_frecuencia4($fecha_actual, $fecha_inicial, $fecha_final, $frecuencia)
{
    $mes_actual = mes_actual4($fecha_actual);
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

function date_frecuencia_caducidad4($fecha_actual, $fecha_inicial, $frecuencia)
{
    $mes_actual = mes_actual4($fecha_actual);
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

function total_monto_programado4($fecha_actual, $mes_actual, $array_programados)
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

                $fecha_promedio = date_frecuencia_caducidad4(
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

                $fecha_promedio = date_frecuencia4(
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

function total_subcategoria_mes4($fecha_actual, $categoria, $tipo)
{
    $mes_actual = mes_actual4($fecha_actual);

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

    $total_egreso_programado = total_monto_programado4($fecha_actual, $mes_actual, $vistaEgresoProgramados);

    return array(
        $total_egreso,
        $total_egreso_programado,
    );
}

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Egreso;
use App\Models\EgresoSetting;
use App\Models\Ingreso;
use App\Models\IngresoSetting;

use Illuminate\Http\Request;

class PresupuestoEjecutadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create($id, $menu, $date, $estado, Request $request)
    {
        $id_categoria = $id;

        switch ($menu) {
            case 1:
                $titulo = "Ingreso Programado";
                $tipo = 1;
                break;
            case 2:
                $titulo = "Ingreso Ejecutado";
                $tipo = 1;
                break;
            case 3:
                $titulo = "Egreso Programado";
                $tipo = 2;
                break;
            case 4:
                $titulo = "Egreso Ejecutado";
                $tipo = 2;
                break;
        }

        if (request('llave_form') == 1) {
            $date = request('date');
        }

        $vistaCategoriaPadres = DB::table('vista_categoria_padres')
            ->where('tipo', '=', $tipo)
            ->where('estado', '=', 1)
            ->orderBy('orden', 'ASC')
            ->get();

        $vistaCategorias = DB::table('vista_categorias')
            ->where('id_padre', '=', $id)
            ->where('estado', '=', 1)
            ->orderBy('orden', 'ASC')
            ->get();

        $dia_semana = date("N", strtotime($date));
        list($calendario, $fechas) = dias_calendario($date, $dia_semana);

        $n_inputs = 6;
        $egreso[0][0] = 0;
        $detalle[0][0] = '';
        $total_ejecutado_mes = 0;
        $total_programado_mes = 0;

        foreach ($vistaCategorias as $vistaCategoria) {
            $mes_actual = mes_actual4($date);

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
                        ->where('id_padre', '=', $id)
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
                        ->where('id_padre', '=', $id)
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
                        $egreso[$i][$vistaCategoria->id] = $egresoMonto;
                        $detalle[$i][$vistaCategoria->id] = $egreso_monto->detalle;
                    }
                }
            }

            list(
                $total_ejecutado_subcategoria[$vistaCategoria->id],
                $total_programado_subcategoria[$vistaCategoria->id]
            ) = total_subcategoria_mes4($date, $vistaCategoria->id, $tipo);

            $total_ejecutado_mes = $total_ejecutado_mes + $total_ejecutado_subcategoria[$vistaCategoria->id];
            $total_programado_mes = $total_programado_mes + $total_programado_subcategoria[$vistaCategoria->id];
        }

        return view('presupuestosejecutados.create', compact(
            'vistaCategorias',
            'vistaCategoriaPadres',
            'id_categoria',
            'n_inputs',
            'calendario',
            'fechas',
            'egreso',
            'detalle',
            'total_monto_dia',
            'total_ejecutado_subcategoria',
            'total_programado_subcategoria',
            'total_ejecutado_mes',
            'total_programado_mes',
            'date',
            'titulo',
            'menu',
            'tipo',
            'date',
            'estado',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$fechas = fechas(request('date'));
        $dia_semana = date("N", strtotime(request('date')));
        list($calendario, $fechas) = dias_calendario(request('date'), $dia_semana);
        $n_inputs = 6;

        $vistaCategorias = DB::table('vista_categorias')
            ->where('id_padre', '=', request('id_categoria'))
            ->where('estado', '=', 1)
            ->orderBy('orden', 'ASC')
            ->get();

        foreach ($vistaCategorias as $vistaCategoria) {
            for ($i = 0; $i <= $n_inputs; $i++) {

                $input = $vistaCategoria->id . "_" . $fechas[$i];
                $input_detalle = "detalle_" . $vistaCategoria->id . "_" . $fechas[$i];
                $fecha = str_replace("_", "-", $fechas[$i]);
                $monto_egreso = request($input) + 0;

                if ($monto_egreso > 0) {

                    if (request('tipo') == 2) {

                        $egreso_montos = DB::table('egreso')
                            ->where('id_categoria', '=', $vistaCategoria->id)
                            ->where('estado', '=', 1)
                            ->where('id_user', '=', auth()->id())
                            ->where('fecha', '=', $fecha)
                            ->get();

                        $egresoMonto = 0;
                        $egresoId = 0;

                        foreach ($egreso_montos as $egreso_monto) {
                            $egresoMonto = $egreso_monto->monto_ejecutado + 0;
                            $egresoId = $egreso_monto->id;
                        }

                        if ($egresoMonto > 0) {
                            $egreso = Egreso::find($egresoId);
                            $egreso->detalle = request($input_detalle);
                            $egreso->monto_ejecutado = $monto_egreso;
                            $egreso->update();
                        } else {
                            $egreso = new Egreso();
                            $egreso->id_categoria = $vistaCategoria->id;
                            $egreso->detalle = request($input_detalle);
                            $egreso->fecha = $fecha;
                            $egreso->monto_ejecutado = $monto_egreso;
                            $egreso->estado = 1;
                            $egreso->id_user = auth()->id();
                            $egreso->save();

                            $egresoSetting = new EgresoSetting();
                            $egresoSetting->id_egreso = $egreso->id;
                            $egresoSetting->id_frecuencia = 1;
                            $egresoSetting->fecha_inicio = $fecha;
                            $egresoSetting->estado = 1;
                            $egresoSetting->id_user = auth()->id();
                            $egresoSetting->save();
                        }
                    } else {

                        $ingreso_montos = DB::table('ingreso')
                            ->where('id_categoria', '=', $vistaCategoria->id)
                            ->where('fecha', '=', $fecha)
                            ->where('estado', '=', 1)
                            ->where('id_user', '=', auth()->id())
                            ->get();

                        $ingresoMonto = 0;
                        $ingresoId = 0;

                        foreach ($ingreso_montos as $ingreso_monto) {
                            $ingresoMonto = $ingreso_monto->monto_ejecutado + 0;
                            $ingresoId = $ingreso_monto->id;
                        }

                        if ($ingresoMonto > 0) {
                            $ingreso = Ingreso::find($ingresoId);
                            $ingreso->detalle = request($input_detalle);
                            $ingreso->monto_ejecutado = $monto_egreso;
                            $ingreso->update();
                        } else {
                            $ingreso = new Ingreso();
                            $ingreso->id_categoria = $vistaCategoria->id;
                            $ingreso->detalle = request($input_detalle);
                            $ingreso->fecha = $fecha;
                            $ingreso->monto_ejecutado = $monto_egreso;
                            $ingreso->estado = 1;
                            $ingreso->id_user = auth()->id();
                            $ingreso->save();

                            $ingresoSetting = new IngresoSetting();
                            $ingresoSetting->id_ingreso = $ingreso->id;
                            $ingresoSetting->id_frecuencia = 1;
                            $ingresoSetting->fecha_inicio = $fecha;
                            $ingresoSetting->estado = 1;
                            $ingresoSetting->id_user = auth()->id();
                            $ingresoSetting->save();
                        }
                    }
                }
            }
        }

        $estado = 1;

        return redirect()->route('presupuestosejecutados.create', [
            'id' => request('id_categoria'),
            'menu' => request('menu'),
            'date' => request('date'),
            'estado' => $estado,
        ]);
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
    public function edit($id, $menu)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
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
    }
}
