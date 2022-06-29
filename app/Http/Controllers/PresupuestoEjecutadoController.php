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

    public function search(Request $request)
    {
        include('IncludeReporte/ComercialSwitchInclude.php');
        include('IncludePresupuestoEjecutado/SearchCategoriaInclude.php');

        return response()->json([
            'search_result' => $search_result,
            'vistaCategoria' => $vistaCategoria,
            'egreso_search' => $egreso,
            'detalle' => $detalle,
            'fechas' => $fechas,
            'total_ejecutado_mes_search' => $total_ejecutado_mes,
            'total_programado_mes_search' => $total_programado_mes,
            'diferencia_mes_search' => $diferencia_mes,
            'porcentaje_mes_search' => $porcentaje_mes
        ], 200);
    }

    public function totales(Request $request)
    {
        $egreso_dia_primario = array();
        $total_ejecutado = 0;
        $total_programado = 0;
        $tipo = request('tipo');

        include('IncludeReporte/ComercialSwitchInclude.php');
        include('IncludePresupuestoEjecutado/TotalesPresupuestoEjecutadoInclude.php');

        return response()->json([
            'egreso_primario' => $egreso_dia_primario,
            'total_ejecutado_mes_primario' => $total_ejecutado_mes_primario,
            'total_programado_mes_primario' => $total_programado_mes_primario,
            'diferencia_mes_primario' => $diferencia_mes_primario,
            'porcentaje_mes_primario' => $porcentaje_mes_primario,
            'total_ejecutado' => $total_ejecutado,
            'total_programado' => $total_programado,
        ], 200);
    }

    public function cambiar_fecha(Request $request)
    {
        $id_categoria = request('id_categoria');
        $id = request('id_categoria');
        $tipo = request('tipo');

        if (request('llave_form') == 1) {
            $date = request('date');
        }

        $vistaCategoriaPadres = DB::table('vista_categoria_padres')
            ->where('tipo', '=', $tipo)
            ->where('estado', '=', 1)
            ->orderBy('orden', 'ASC')
            ->get();

        if ($tipo == 1) {
            $vistaCategorias = DB::table('vista_ingreso_programado')
                ->select('id_categoria')
                ->where('id_padre', '=', $id)
                ->where('estado_ingreso_programado', '=', 1)
                ->where('id_user_ingreso_programado', '=', auth()->id())
                ->groupBy('id_categoria')
                ->get();
        } else {
            $vistaCategorias = DB::table('vista_egreso_programado')
                ->select('id_categoria')
                ->where('id_padre', '=', $id)
                ->where('estado_egreso_programado', '=', 1)
                ->where('id_user_egreso_programado', '=', auth()->id())
                ->groupBy('id_categoria')
                ->get();
        }

        include('IncludeReporte/ComercialSwitchInclude.php');
        include('IncludePresupuestoEjecutado/TablePresupuestoEjecutadoInclude.php');

        return response()->json([
            'vistaCategorias' => $vistaCategorias,
            'array_categoria' => $array_categoria,
            'n_inputs' => $n_inputs,
            'calendario' => $calendario,
            'fechas' => $fechas,
            'egreso' => $egreso,
            'detalle' => $detalle,
            'id_categoria' => $id_categoria,
            'date' => $date
        ], 200);
    }

    public function create($id, $menu, $date, $estado, $comercial, Request $request)
    {
        $id_categoria = $id;
        $n_ajax = 10;

        include('IncludePresupuestoProgramado/MenuTituloTipoInclude.php');
        include('IncludeReporte/ComercialSwitchInclude.php');

        if (request('llave_form') == 1) {
            $date = request('date');
        }

        $vistaCategoriaPadres = DB::table('vista_categoria_padres')
            ->where('tipo', '=', $tipo)
            ->where('comercial', '=', $comercial)
            ->where('estado', '=', 1)
            ->orderBy('orden', 'ASC')
            ->get();

        if ($tipo == 1) {
            $vistaCategorias = DB::table('vista_ingreso_programado')
                ->select('id_categoria')
                ->where('id_padre', '=', $id)
                ->where('estado_ingreso_programado', '=', 1)
                ->where('id_user_ingreso_programado', '=', auth()->id())
                ->groupBy('id_categoria')
                ->get();
        } else {
            $vistaCategorias = DB::table('vista_egreso_programado')
                ->select('id_categoria')
                ->where('id_padre', '=', $id)
                ->where('estado_egreso_programado', '=', 1)
                ->where('id_user_egreso_programado', '=', auth()->id())
                ->groupBy('id_categoria')
                ->get();
        }

        include('IncludePresupuestoEjecutado/TablePresupuestoEjecutadoInclude.php');
        include('IncludeCategoria/BuscadorCategoriasInclude.php');

        $fecha_actual = $date;
        $date_future = strtotime('-0 day', strtotime($fecha_actual));
        $mes_actual_text = date("F Y", $date_future);

        include('IncludeReporte/IngresosEgresosSaldoAnualInclude.php');

        return view('presupuestosejecutados.create', compact(
            'vistaCategorias',
            'vistaCategoriaPadres',
            'id_categoria',
            'array_categoria',
            'n_inputs',
            'n_ajax',
            'calendario',
            'fechas',
            'egreso',
            'detalle',
            'total_monto_dia',
            'total_ejecutado_subcategoria',
            'total_programado_subcategoria',
            'diferencia',
            'porcentaje',
            'total_ejecutado_mes',
            'total_programado_mes',
            'color_porcentaje',
            'date',
            'titulo',
            'menu',
            'tipo',
            'date',
            'estado',
            'json',
            'comercial',
            'data_total_ingreso_mes',
            'data_total_ingreso_programado_mes',
            'data_total_egreso_mes',
            'data_total_egreso_programado_mes',
            'mes_actual_text'
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
        $tipo = request('tipo');

        include('IncludeReporte/ComercialSwitchInclude.php');
        include('IncludePresupuestoEjecutado/StorePresupuestoEjecutadoInclude.php');
        include('IncludePresupuestoEjecutado/TotalesPresupuestoEjecutadoInclude.php');
        include('IncludePresupuestoEjecutado/StorePresupuestoEjecutadoAjaxInclude.php');
        include('IncludePresupuestoEjecutado/StorePresupuestoEjecutadoSearchInclude.php');

        return response()->json([
            'egreso_primario' => $egreso_dia_primario,
            'total_ejecutado_mes_primario' => $total_ejecutado_mes_primario,
            'total_programado_mes_primario' => $total_programado_mes_primario,
            'diferencia_mes_primario' => $diferencia_mes_primario,
            'porcentaje_mes_primario' => $porcentaje_mes_primario,
            'total_ejecutado' => $total_ejecutado,
            'total_programado' => $total_programado,
            'egreso_search' => $egreso_dia_search,
            'total_ejecutado_mes_search' => $total_ejecutado_mes_search,
            'total_programado_mes_search' => $total_programado_mes_search,
            'diferencia_mes_search' => $diferencia_mes_search,
            'porcentaje_mes_search' => $porcentaje_mes_search,
            'llave_categoria' => $llave_categoria
        ], 200);
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
