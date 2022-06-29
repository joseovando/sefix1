<?php

namespace App\Http\Controllers;

use App\Models\CategoriaComercial;
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

        include('IncludeReporte/ComercialSwitchInclude.php');
        include('IncludeReporte/IngresosEgresosSaldoMesInclude.php');
        include('IncludeReporte/IngresosEgresosSaldoAnualInclude.php');
        include('IncludeReporte/GraficaEgresoCategoriaMesInclude.php');
        include('IncludeReporte/EgresoCategoriaMesInclude.php');
        include('IncludeReporte/IngresoCategoriaAnualInclude.php');

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
            'contador',
            'comercial'
        ));
    }

    public function switch($id)
    {
        if ($id == "checked") {
            $comercial = 0;
        } else {
            $comercial = 1;
        }

        $categoriaComercial = DB::table('categoria_comercial')
            ->where('estado', '=', 1)
            ->where('id_user', '=', auth()->id())
            ->orderBy('comercial', 'ASC')
            ->first();

        if (!isset($categoriaComercial)) {
            $categoria_comercial = new CategoriaComercial();
            $categoria_comercial->comercial = $comercial;
            $categoria_comercial->estado = 1;
            $categoria_comercial->id_user = auth()->id();
            $categoria_comercial->save();
        } else {
            $categoria_comercial = CategoriaComercial::find($categoriaComercial->id);
            $categoria_comercial->comercial = $comercial;
            $categoria_comercial->update();
        }

        return response()->json([
            'comercial' => $comercial,
        ], 200);
    }
}
