<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\EgresoProgramado;
use App\Models\IngresoProgramado;
use App\Models\SubcategoriaFavorita;
use Illuminate\Http\Request;

include('Function/function.php');

class PresupuestoProgramadoController extends Controller
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
    public function create($id, $menu, $mes, $ano, $estado, $comercial, Request $request)
    {
        $navegador_mobile = navegador_mobile();
        $cantidad_tr = 9; //tr adicionales hidden

        include('IncludePresupuestoProgramado/MenuTituloTipoInclude.php');
        include('IncludePresupuestoProgramado/IfLlaveFormInclude.php');

        $vistaCategoriaPadres = DB::table('vista_categoria_padres')
            ->where('tipo', '=', $tipo)
            ->where('estado', '=', 1)
            ->where('comercial', '=', $comercial)
            ->orderBy('orden', 'ASC')
            ->get();

        $vistaCategorias = DB::table('vista_categorias')
            ->where('id_padre', '=', $id)
            ->where('estado', '=', 1)
            ->where('comercial', '=', $comercial)
            ->orderBy('orden', 'ASC')
            ->get();

        $frecuencias = DB::table('frecuencia')
            ->where('estado', '=', 1)
            ->orderBy('orden', 'ASC')
            ->get();

        include('IncludePresupuestoProgramado/SubcategoriaDesactivadaInclude.php');
        include('IncludePresupuestoProgramado/TablePresupuestoProgramadoInclude.php');
        include('IncludeCategoria/BuscadorCategoriasInclude.php');

        return view('presupuestosprogramados.create', compact(
            'titulo',
            'vistaCategoriaPadres',
            'vistaCategorias',
            'frecuencias',
            'id',
            'menu',
            'tipo',
            'ano_actual',
            'ano_actual_inicio',
            'ano_actual_fin',
            'meses',
            'mes_actual',
            'categoria_desactivada',
            'id_categoria_array',
            'categoria_name',
            'categoria_plantilla',
            'categoria_user',
            'id_ingreso_programado',
            'monto',
            'monto_total',
            'id_frecuencia',
            'caducidad',
            'fecha_inicio',
            'fecha_fin',
            'estado',
            'navegador_mobile',
            'cantidad_tr',
            'json',
            'comercial'
        ));
    }

    public function desactivar_categorias($id)
    {
        $favorita = new SubcategoriaFavorita();
        $favorita->id_categoria = $id;
        $favorita->orden =  0;
        $favorita->plantilla =  0;
        $favorita->estado = 1;
        $favorita->id_user = auth()->id();
        $favorita->save();

        return response()->json(['success' => 'Registro Guardado Correctamente.']);
    }

    public function activar_categorias(Request $request)
    {
        include('IncludePresupuestoProgramado/ActivarCategoriaInclude.php');

        return response()->json([
            'vistaCategorias' => $vistaCategorias,
            'arrayDisabled' => $arrayDisabled,
        ], 200);
    }

    public function subcategorias($id)
    {
        $subcategorias = DB::table('vista_categorias')
            ->where('id_padre', '=', $id)
            ->where('estado', '=', 1)
            ->orderBy('orden', 'ASC')
            ->get();

        return $subcategorias;
    }

    public function total_programado(Request $request)
    {
        $tipo = request('tipo');
        $id = request('id_categoria');

        include('IncludePresupuestoProgramado/IfLlaveFormInclude.php');
        include('IncludePresupuestoProgramado/TotalProgramadoInclude.php');

        return response()->json([
            'monto_total' => $monto_total,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        include('IncludePresupuestoProgramado/StorePresupuestoProgramadoInclude.php');
        include('IncludePresupuestoProgramado/StorePresupuestoProgramadoAdicionalInclude.php');
        /* include('IncludePresupuestoProgramado/StorePresupuestoProgramadoAjaxInclude.php');
        include('IncludePresupuestoProgramado/StorePresupuestoProgramadoSearchInclude.php'); */

        /* $nueva_categoria_id = 0;
        $categoria_adicional = 0;
        $monto_adicional = 0;
        $frecuencia_adicional = 0;
        $caducidad_adicional = 0;
        $inicio_adicional = 0;
        $fin_adicional = 0; 
        $id_categoria_search = 0; */

        return response()->json([
            'presupuesto_id' => $presupuesto_id,
            'categoria_id' => $categoria_id,
            'nueva_categoria_id' => $nueva_categoria_id,
            'categoria_adicional_id' => $categoria_adicional_id,
        ], 200);
    }

    public function search(Request $request)
    {
        $tipo = request('tipo');
        $comercial = request('comercial');

        include('IncludePresupuestoProgramado/IfLlaveFormInclude.php');
        include('IncludePresupuestoProgramado/SearchCategoriaInclude.php');

        if ($search_result == 1) {
            include('IncludePresupuestoProgramado/TablePresupuestoProgramadoInclude.php');

            return response()->json([
                'search_result' => $search_result,
                'vistaCategorias' => $vistaCategorias,
                'vistaIngresoProgramados' => $vistaIngresoProgramados,
                'id_categoria_array' => $id_categoria_array,
                'categoria_name' => $categoria_name,
                'categoria_plantilla' => $categoria_plantilla,
                'categoria_user' => $categoria_user,
                'subcategoria_favorita_array' => $subcategoria_favorita_array,
                'id_ingreso_programado' => $id_ingreso_programado,
                'monto' => $monto,
                'id_frecuencia' => $id_frecuencia,
                'caducidad' => $caducidad,
                'fecha_inicio' => $fecha_inicio,
                'fecha_fin' => $fecha_fin,
                'id_categoria' => $id,
                'mes_actual' => $mes_actual,
                'ano_actual' => $ano_actual,
            ], 200);
        } else {
            return response()->json([
                'search_result' => $search_result,
            ], 200);
        }
    }

    public function cambiar_fecha(Request $request)
    {
        $tipo = request('tipo');
        $id = request('id_categoria');
        $comercial = request('comercial');

        $vistaCategorias = DB::table('vista_categorias')
            ->where('id_padre', '=', $id)
            ->where('estado', '=', 1)
            ->where('comercial', '=', $comercial)
            ->orderBy('orden', 'ASC')
            ->get();

        include('IncludePresupuestoProgramado/IfLlaveFormInclude.php');
        include('IncludePresupuestoProgramado/TablePresupuestoProgramadoInclude.php');

        return response()->json([
            'vistaCategorias' => $vistaCategorias,
            'id_categoria_array' => $id_categoria_array,
            'categoria_name' => $categoria_name,
            'categoria_plantilla' => $categoria_plantilla,
            'categoria_user' => $categoria_user,
            'subcategoria_favorita_array' => $subcategoria_favorita_array,
            'id_ingreso_programado' => $id_ingreso_programado,
            'monto' => $monto,
            'id_frecuencia' => $id_frecuencia,
            'caducidad' => $caducidad,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'id_categoria' => $id,
            'mes_actual' => $mes_actual,
            'ano_actual' => $ano_actual,
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
