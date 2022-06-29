<?php

namespace App\Http\Controllers;

use App\Models\Cuenta;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

include('Function/function.php');

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

        include('IncludePresupuestoProgramado/IfLlaveFormInclude.php');

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

        include('IncludePresupuestoProgramado/IfLlaveFormInclude.php');
        include('IncludeReporte/ComercialSwitchInclude.php');

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
        ) = total_ingresos_egresos_saldo_mes($fecha_actual, $comercial);

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
        ) = total_ingresos_egresos_saldo_mes($fecha_actual, $comercial);

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

        include('IncludePresupuestoProgramado/IfLlaveFormInclude.php');

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
