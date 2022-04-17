<?php

function dias_calendario($date)
{
    $fechaActual = $date;

    $date_future = strtotime('-4 day', strtotime($fechaActual));
    $calendario[0] = date('d F', $date_future);

    $date_future = strtotime('-3 day', strtotime($fechaActual));
    $calendario[1] = date('d F', $date_future);

    $date_future = strtotime('-2 day', strtotime($fechaActual));
    $calendario[2] = date('d F', $date_future);

    $date_future = strtotime('-1 day', strtotime($fechaActual));
    $calendario[3] = date('d F', $date_future);

    $date_future = strtotime('+0 day', strtotime($fechaActual));
    $calendario[4] = date('d F', $date_future);

    // $calendario[4] = date('d F');

    $date_future = strtotime('+1 day', strtotime($fechaActual));
    $calendario[5] = date('d F', $date_future);

    $date_future = strtotime('+2 day', strtotime($fechaActual));
    $calendario[6] = date('d F', $date_future);

    $date_future = strtotime('+3 day', strtotime($fechaActual));
    $calendario[7] = date('d F', $date_future);

    $date_future = strtotime('+4 day', strtotime($fechaActual));
    $calendario[8] = date('d F', $date_future);

    return $calendario;
}

function fechas($date)
{
    $fechaActual = $date;

    $date_future = strtotime('-4 day', strtotime($fechaActual));
    $fecha[0] = date('Y_m_d', $date_future);

    $date_future = strtotime('-3 day', strtotime($fechaActual));
    $fecha[1] = date('Y_m_d', $date_future);

    $date_future = strtotime('-2 day', strtotime($fechaActual));
    $fecha[2] = date('Y_m_d', $date_future);

    $date_future = strtotime('-1 day', strtotime($fechaActual));
    $fecha[3] = date('Y_m_d', $date_future);

    $date_future = strtotime('+0 day', strtotime($fechaActual));
    $fecha[4] = date('Y_m_d', $date_future);

    // $fecha[4] = date('Y_m_d');

    $date_future = strtotime('+1 day', strtotime($fechaActual));
    $fecha[5] = date('Y_m_d', $date_future);

    $date_future = strtotime('+2 day', strtotime($fechaActual));
    $fecha[6] = date('Y_m_d', $date_future);

    $date_future = strtotime('+3 day', strtotime($fechaActual));
    $fecha[7] = date('Y_m_d', $date_future);

    $date_future = strtotime('+4 day', strtotime($fechaActual));
    $fecha[8] = date('Y_m_d', $date_future);

    return $fecha;
}

function mes_actual($fecha_actual)
{
    $fecha_actual = strtotime($fecha_actual);
    $ano_actual = date("Y", $fecha_actual);
    $mes_actual = date("m", $fecha_actual);
    $mes_despues = $mes_actual + 1;
    $mes[0] = $ano_actual . "-" . $mes_actual . "-01";
    $mes[1] = $ano_actual . "-" . $mes_despues . "-01";

    return $mes;
}

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Egreso;
use App\Models\EgresoSetting;
use App\Models\Frecuencia;
use App\Models\Ingreso;
use App\Models\IngresoSetting;
use App\Models\VistaCategoria;
use App\Models\VistaCategoriaPadre;

use Illuminate\Http\Request;

class PresupuestoEjecutadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index2()
    {
        $vistaEgresos = DB::table('vista_egresos')
            ->where('estado', '=', 1)
            ->where('id_user', '=', auth()->id())
            ->orderBy('fecha', 'ASC')
            ->get();

        return view('presupuestosejecutados.index', [
            'vistaEgresos' => $vistaEgresos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create($id, $menu, $date, Request $request)
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

        $calendario = dias_calendario($date);
        $fechas = fechas($date);
        $n_inputs = 8;
        $egreso[0][0] = 0;
        $detalle[0][0] = '';

        foreach ($vistaCategorias as $vistaCategoria) {
            $total_monto_mes[$vistaCategoria->id] = 0;

            $mes_actual = mes_actual($date);

            if ($tipo == 2) {
                $total_meses = DB::table('vista_egresos')
                    ->whereBetween('fecha', $mes_actual)
                    ->where('id_categoria', '=', $vistaCategoria->id)
                    ->where('estado', '=', 1)
                    ->where('id_user', '=', auth()->id())
                    ->get();
            } else {
                $total_meses = DB::table('vista_ingresos')
                    ->whereBetween('fecha', $mes_actual)
                    ->where('id_categoria', '=', $vistaCategoria->id)
                    ->where('estado', '=', 1)
                    ->where('id_user', '=', auth()->id())
                    ->get();
            }

            foreach ($total_meses as $total_mes) {
                $total_monto_mes[$vistaCategoria->id] = $total_monto_mes[$vistaCategoria->id] + $total_mes->monto_ejecutado;
            }

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
        }

        $total = 0;
        foreach ($total_monto_mes as $item) {
            $total = $total + $item;
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
            'total_monto_mes',
            'total',
            'date',
            'titulo',
            'menu',
            'tipo',
            'date',
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
        $fechas = fechas(request('date'));
        $n_inputs = 8;

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

        return redirect()->route('presupuestosejecutados.create', [
            'id' => request('id_categoria'),
            'menu' => request('menu'),
            'date' => request('date'),
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
    public function edit2($id, $menu)
    {
        $vistaCategoriaPadres = DB::table('vista_categoria_padres')
            ->where('tipo', '=', 1)
            ->where('estado', '=', 1)

            ->orderBy('orden', 'ASC')
            ->get();

        $frecuencias = DB::table('frecuencia')
            ->where('estado', '=', 1)
            ->orderBy('orden', 'ASC')
            ->get();

        $titulo = "Editar Egreso";

        $egreso = Egreso::find($id);

        $egresoSetting = egresoSetting::where('id_egreso', $egreso->id)->first();

        $idCategoriaPadre = DB::table('vista_categorias')
            ->where('id', '=', $egreso->id_categoria)

            ->first();

        $id_categoria_padre = $idCategoriaPadre->id_padre;

        $vistaCategorias = DB::table('vista_categorias')
            ->where('id_padre', '=', $id_categoria_padre)

            ->orderBy('orden', 'ASC')
            ->get();

        /* return view('presupuestosejecutados.edit', [
            'vistaCategoriaPadres' => $vistaCategoriaPadres,
            'vistaCategorias' => $vistaCategorias,
            'id_categoria_padre' => $id_categoria_padre,
            'frecuencias' => $frecuencias,
            'egreso' => $egreso,
            'egresoSetting' => $egresoSetting,
            'menu' => $menu,
            'titulo' => $titulo
        ]); */
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update2(Request $request)
    {
        $egreso = Egreso::find(request('id'));
        $egreso->id_categoria = request('subcategoria');
        $egreso->monto_programado = request('monto_programado');
        $egreso->monto_ejecutado = request('monto_ejecutado');
        $egreso->fecha = request('inicio');
        $egreso->update();

        $idEgresoSetting = EgresoSetting::where('id_egreso', request('id'))->first();

        $egresoSetting = EgresoSetting::find($idEgresoSetting->id);
        $egresoSetting->id_frecuencia = request('frecuencia');
        $egresoSetting->fecha_inicio = request('inicio');
        $egresoSetting->fecha_fin = request('fin');
        $egresoSetting->sin_caducidad = request('sin_caducidad');
        $egresoSetting->update();

        return redirect()->route('presupuestosejecutados.index');
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

    public function delete2($id)
    {
        $egreso = Egreso::find($id);
        $egreso->estado = 0;
        $egreso->update();

        $idEgresoSetting = EgresoSetting::where('id_egreso', $id)->first();

        $egresoSetting = EgresoSetting::find($idEgresoSetting->id);
        $egresoSetting->estado = 0;
        $egresoSetting->update();

        return redirect()->route('presupuestosejecutados.index');
    }
}
