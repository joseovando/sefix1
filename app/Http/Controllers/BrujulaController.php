<?php

namespace App\Http\Controllers;

use App\Models\BrujulaCoeficiente;
use App\Models\BrujulaCorriente;
use App\Models\BrujulaInversiones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

include('Function/function.php');

class BrujulaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $navegador_mobile = navegador_mobile();

        include('IncludeBrujula/IndexBrujula.php');

        return view('brujula.index', compact(
            'navegador_mobile',
            'vistaUsersSpecific',
            'brujulaDatosBasicos',
            'vistaCategoriaIngresoPadres',
            'vistaCategoriaEgresoPadres',
            'vistaBrujulaIngresosCorrientes',
            'contador_ingresos_corrientes',
            'brujulaInversiones',
            'contador_ingresos_inversiones',
            'vistaBrujulaEgresosCorrientes',
            'contador_egresos_corrientes',
            'brujulaPrestamos',
            'contador_prestamos',
            'vistaBrujulaCoeficientes',
            'vistaCategoriaIngresos',
            'vistaCategoriaEgresos'
        ));
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
    public function store_basicos(Request $request)
    {
        include('IncludeBrujula/StoreDatosBasicos.php');

        return response()->json([
            'brujulaDatosBasicos' => $brujulaDatosBasicos,
        ], 200);
    }

    public function store_corrientes(Request $request)
    {
        include('IncludeBrujula/StoreCorrientes.php');

        $vistaBrujulaCorrientes = DB::table('vista_brujula_corrientes')
            ->where('tipo', '=', $tipo_corriente)
            ->where('id_user', '=', auth()->id())
            ->where('estado', '=', 1)
            ->orderBy('categoria', 'ASC')
            ->orderBy('cuenta', 'ASC')
            ->get();

        return response()->json([
            'vistaBrujulaCorrientes' => $vistaBrujulaCorrientes,
            'tipo_corriente' => $tipo_corriente,
            'id_brujula_corriente' => $id_brujula_corriente,
        ], 200);
    }

    public function store_inversiones(Request $request)
    {
        include('IncludeBrujula/StoreInversiones.php');

        $brujulaInversiones = DB::table('brujula_inversiones')
            ->where('tipo', '=', $tipo_inversion)
            ->where('id_user', '=', auth()->id())
            ->where('estado', '=', 1)
            ->orderBy('cuenta', 'ASC')
            ->get();

        return response()->json([
            'brujulaInversiones' => $brujulaInversiones,
            'tipo_inversion' => $tipo_inversion,
            'id_brujula_inversion' => $id_brujula_inversion,
        ], 200);
    }

    public function store_coeficientes(Request $request)
    {
        include('IncludeBrujula/StoreCoeficientes.php');

        $vistaBrujulaCoeficientes = DB::table('vista_brujula_coeficientes')
            ->where('id_user', '=', auth()->id())
            ->where('estado', '=', 1)
            ->orderBy('orden', 'ASC')
            ->get();

        return response()->json([
            'vistaBrujulaCoeficientes' => $vistaBrujulaCoeficientes,
            'id_brujula_coeficiente' => $id_brujula_coeficiente,
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
    public function edit_corrientes($id)
    {
        $vistaBrujulaCorriente = DB::table('vista_brujula_corrientes')
            ->where('id', '=', $id)
            ->where('id_user', '=', auth()->id())
            ->where('estado', '=', 1)
            ->orderBy('categoria', 'ASC')
            ->first();

        $vistaCategoriaIngresos = DB::table('vista_categoria_padres')
            ->where('tipo', '=', $vistaBrujulaCorriente->tipo)
            ->where('estado', '=', 1)
            ->where('comercial', '=', 0)
            ->orderBy('categoria', 'ASC')
            ->get();

        return response()->json([
            'vistaBrujulaCorriente' => $vistaBrujulaCorriente,
            'vistaCategoriaIngresos' => $vistaCategoriaIngresos
        ], 200);
    }

    public function edit_inversiones($id)
    {
        $brujulaInversiones = DB::table('brujula_inversiones')
            ->where('id', '=', $id)
            ->where('id_user', '=', auth()->id())
            ->where('estado', '=', 1)
            ->orderBy('id', 'ASC')
            ->first();

        return response()->json([
            'brujulaInversiones' => $brujulaInversiones
        ], 200);
    }

    public function edit_coeficientes($id)
    {
        $vistaBrujulaCoeficientes = DB::table('vista_brujula_coeficientes')
            ->where('id', '=', $id)
            ->where('id_user', '=', auth()->id())
            ->where('estado', '=', 1)
            ->orderBy('orden', 'ASC')
            ->first();

        return response()->json([
            'vistaBrujulaCoeficientes' => $vistaBrujulaCoeficientes
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

    public function delete_corrientes($id)
    {
        $brujulaCorriente = BrujulaCorriente::where([
            ['id', $id],
            ['id_user', auth()->id()],
        ])->first();

        $brujulaCorriente->estado = 0;
        $brujulaCorriente->update();

        $vistaBrujulaCorrientes = DB::table('vista_brujula_corrientes')
            ->where('estado', '=', 1)
            ->orderBy('categoria', 'ASC')
            ->orderBy('cuenta', 'ASC')
            ->get();

        $tipo_corriente =  $brujulaCorriente->tipo;

        return response()->json([
            'vistaBrujulaCorrientes' => $vistaBrujulaCorrientes,
            'tipo_corriente' => $tipo_corriente
        ], 200);
    }


    public function delete_inversiones($id)
    {
        $brujulaInversion = BrujulaInversiones::where([
            ['id', $id],
            ['id_user', auth()->id()],
        ])->first();

        $brujulaInversion->estado = 0;
        $brujulaInversion->update();

        $brujulaInversiones = DB::table('brujula_inversiones')
            ->where('tipo', '=', $brujulaInversion->tipo)
            ->where('id_user', '=', auth()->id())
            ->where('estado', '=', 1)
            ->orderBy('cuenta', 'ASC')
            ->get();

        $id_brujula_inversion = 0;
        $tipo_inversion = $brujulaInversion->tipo;

        return response()->json([
            'brujulaInversiones' => $brujulaInversiones,
            'id_brujula_inversion' => $id_brujula_inversion,
            'tipo_inversion' => $tipo_inversion
        ], 200);
    }

    public function delete_coeficientes($id)
    {
        $brujulaCoeficiente = BrujulaCoeficiente::where([
            ['id', $id],
            ['id_usuario', auth()->id()],
        ])->first();

        $brujulaCoeficiente->estado = 0;
        $brujulaCoeficiente->update();

        $vistaBrujulaCoeficientes = DB::table('vista_brujula_coeficientes')
            ->where('id_user', '=', auth()->id())
            ->where('estado', '=', 1)
            ->orderBy('orden', 'ASC')
            ->get();

        $id_brujula_coeficiente =  0;

        return response()->json([
            'vistaBrujulaCoeficientes' => $vistaBrujulaCoeficientes,
            'id_brujula_coeficiente' => $id_brujula_coeficiente,
        ], 200);
    }
}
