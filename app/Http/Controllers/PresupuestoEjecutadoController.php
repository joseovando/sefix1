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

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Egreso;
use App\Models\EgresoSetting;
use App\Models\Frecuencia;
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
    public function index()
    {
        $vistaEgresos = DB::table('vista_egresos')
            ->where('estado', '=', 1)
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

    public function create($id, Request $request)
    {
        $titulo = "Egreso Ejecutado";

        $fechaActual = date('Y-m-d');
        if (request('llave_form') == 1) {
            $date = request('date');
        } else {
            $date = $fechaActual;
        }

        $vistaCategoriaPadres = VistaCategoriaPadre::all();
        $vistaCategorias = DB::table('vista_categorias')
            ->where('id_padre', '=', $id)
            ->orderBy('orden', 'ASC')
            ->get();

        $calendario = dias_calendario($date);
        $fechas = fechas($date);
        $n_inputs = 8;
        $egreso[0][0] = 0;

        foreach ($vistaCategorias as $vistaCategoria) {
            for ($i = 0; $i <= $n_inputs; $i++) {
                $fecha = str_replace("_", "-", $fechas[$i]);
                $egreso_montos = DB::table('egreso')
                    ->where('id_categoria', '=', $vistaCategoria->id)
                    ->where('fecha', '=', $fecha)
                    ->where('estado', '=', 1)
                    ->get();

                foreach ($egreso_montos as $egreso_monto) {
                    $egresoMonto = $egreso_monto->monto_ejecutado + 0;
                    if ($egresoMonto > 0) {
                        $egreso[$i][$vistaCategoria->id] = $egresoMonto;
                    }
                }
            }
        }

        return view('presupuestosejecutados.create', [
            'vistaCategorias' => $vistaCategorias,
            'vistaCategoriaPadres' => $vistaCategoriaPadres,
            'id_categoria' => $id,
            'n_inputs' => $n_inputs,
            'calendario' => $calendario,
            'fechas' => $fechas,
            'egreso' => $egreso,
            'date' => $date,
            'titulo' => $titulo
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fechas = fechas(request('date_original'));
        $n_inputs = 8;

        $vistaCategorias = DB::table('vista_categorias')
            ->where('id_padre', '=', request('id_categoria'))
            ->orderBy('orden', 'ASC')
            ->get();

        foreach ($vistaCategorias as $vistaCategoria) {
            for ($i = 0; $i <= $n_inputs; $i++) {

                $input = $vistaCategoria->id . "_" . $fechas[$i];
                $fecha = str_replace("_", "-", $fechas[$i]);
                $monto_egreso = request($input) + 0;

                if ($monto_egreso > 0) {

                    $egreso_montos = DB::table('egreso')
                        ->where('id_categoria', '=', $vistaCategoria->id)
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
                        $egreso->monto_ejecutado = $monto_egreso;
                        $egreso->update();
                    } else {
                        $egreso = new Egreso();
                        $egreso->id_categoria = $vistaCategoria->id;
                        $egreso->fecha = $fecha;
                        $egreso->monto_ejecutado = $monto_egreso;
                        $egreso->estado = 1;
                        $egreso->save();

                        $egresoSetting = new EgresoSetting();
                        $egresoSetting->id_egreso = $egreso->id;
                        $egresoSetting->id_frecuencia = 1;
                        $egresoSetting->fecha_inicio = $fecha;
                        $egresoSetting->estado = 1;
                        $egresoSetting->save();
                    }
                }
            }
        }

        return redirect()->route('presupuestosejecutados.index');
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
        $vistaCategoriaPadres = DB::table('vista_categoria_padres')
            ->where('tipo', '=', 1)
            ->orderBy('orden', 'ASC')
            ->get();

        $frecuencias = Frecuencia::all();

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

        return view('presupuestosejecutados.edit', [
            'vistaCategoriaPadres' => $vistaCategoriaPadres,
            'vistaCategorias' => $vistaCategorias,
            'id_categoria_padre' => $id_categoria_padre,
            'frecuencias' => $frecuencias,
            'egreso' => $egreso,
            'egresoSetting' => $egresoSetting,
            'menu' => $menu,
            'titulo' => $titulo
        ]);
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

    public function delete($id)
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
