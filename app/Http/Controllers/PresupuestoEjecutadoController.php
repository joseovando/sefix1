<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Egreso;
use App\Models\EgresoSetting;
use App\Models\Ingreso;
use App\Models\IngresoSetting;

use Illuminate\Http\Request;

include('Function/function.php');


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

        include('IncludePresupuestoProgramado/MenuTituloTipoInclude.php');

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
            $mes_actual = mes_actual($date);

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
            ) = total_subcategoria_mes($date, $vistaCategoria->id, $tipo);

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
