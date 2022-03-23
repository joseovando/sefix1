<?php

function date_frecuencia($fecha_inicial, $fecha_final, $frecuencia)
{
    $fecha_actual = date("Y-m-d");
    $fecha_frecuencia = $fecha_inicial;
    $contador = 1;

    if ($fecha_inicial < $fecha_final) {

        while ($fecha_frecuencia < $fecha_actual) {
            $frecuencia_neo = $frecuencia * $contador;
            $frecuencia_texto = "+" . $frecuencia_neo . " day";
            $date_future = strtotime($frecuencia_texto, strtotime($fecha_inicial));
            $fecha_frecuencia = date('Y-m-d', $date_future);
            $contador++;
        }

        if ($fecha_frecuencia > $fecha_final) {
            $contador = 1;

            while ($fecha_final < $fecha_frecuencia) {
                $frecuencia = $frecuencia * $contador;
                $frecuencia_texto = "-" . $frecuencia . " day";
                $date_future = strtotime($frecuencia_texto, strtotime($fecha_frecuencia));
                $fecha_frecuencia = date('Y-m-d', $date_future);
                $contador++;
            }
        }
    }

    return $fecha_frecuencia;
}

function date_frecuencia_caducidad($fecha_inicial, $frecuencia)
{
    $fecha_actual = date("Y-m-d");
    $fecha_frecuencia = $fecha_inicial;
    $contador = 1;

    while ($fecha_frecuencia < $fecha_actual) {
        $frecuencia_neo = $frecuencia * $contador;
        $frecuencia_texto = "+" . $frecuencia_neo . " day";
        $date_future = strtotime($frecuencia_texto, strtotime($fecha_inicial));
        $fecha_frecuencia = date('Y-m-d', $date_future);
        $contador++;
    }

    return $fecha_frecuencia;
}

function mes_actual()
{
    $fecha_actual = date("Y-m");
    $mes[0] = $fecha_actual . "-01";
    $mes[1] = $fecha_actual . "-28";
    return $mes;
}

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Egreso;
use App\Models\EgresoSetting;
use App\Models\Ingreso;
use App\Models\IngresoSetting;
use App\Models\Frecuencia;
use App\Models\IngresoProgramado;
use App\Models\VistaCategoriaPadre;
use Illuminate\Http\Request;

class PresupuestoProgramadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vistaIngresoProgramados = DB::table('vista_ingreso_programado')
            ->where('estado_ingreso_programado', '=', 1)
            ->orderBy('fecha_promedio', 'DESC')
            ->get();

        $fecha_actual = date("Y-m-d");

        foreach ($vistaIngresoProgramados as $vistaIngresoProgramado) {

            //Unico y Por defecto
            $ingreso = IngresoProgramado::find($vistaIngresoProgramado->id);
            $ingreso->fecha_promedio = $vistaIngresoProgramado->fecha_inicio;
            $ingreso->update();

            // Mensual con fecha de Inicio y Fin 
            if (
                $vistaIngresoProgramado->id_frecuencia == 2
                and $vistaIngresoProgramado->fecha_inicio <= $fecha_actual
                and $vistaIngresoProgramado->fecha_fin >= $fecha_actual
            ) {
                $ingreso = IngresoProgramado::find($vistaIngresoProgramado->id);
                $ingreso->fecha_promedio = $fecha_actual;
                $ingreso->update();
            }

            // Mensual con fecha de Inicio y Sin Caducidad 
            if (
                $vistaIngresoProgramado->id_frecuencia == 2
                and $vistaIngresoProgramado->sin_caducidad == 1
            ) {
                $ingreso = IngresoProgramado::find($vistaIngresoProgramado->id);
                $ingreso->fecha_promedio = $fecha_actual;
                $ingreso->update();
            }

            // Trimestral, Semestral, Anual con fecha de Inicio y Fin 
            if (
                $vistaIngresoProgramado->id_frecuencia == 3 // Trimestral
                or $vistaIngresoProgramado->id_frecuencia == 4 // Semestral
                or $vistaIngresoProgramado->id_frecuencia == 5 // Anual
                and $vistaIngresoProgramado->fecha_inicio <= $fecha_actual
                and $vistaIngresoProgramado->fecha_fin >= $fecha_actual
            ) {
                $fecha_promedio = date_frecuencia(
                    $vistaIngresoProgramado->fecha_inicio,
                    $vistaIngresoProgramado->fecha_fin,
                    $vistaIngresoProgramado->valor_numerico
                );

                $ingreso = IngresoProgramado::find($vistaIngresoProgramado->id);
                $ingreso->fecha_promedio = $fecha_promedio;
                $ingreso->update();
            }

            // Trimestral, Semestral, Anual Sin Caducidad 
            if (
                $vistaIngresoProgramado->id_frecuencia == 3 // Trimestral
                or $vistaIngresoProgramado->id_frecuencia == 4 // Semestral
                or $vistaIngresoProgramado->id_frecuencia == 5 // Anual
                and $vistaIngresoProgramado->sin_caducidad == 1
            ) {
                $fecha_promedio = date_frecuencia_caducidad(
                    $vistaIngresoProgramado->fecha_inicio,
                    $vistaIngresoProgramado->valor_numerico
                );
                $ingreso = IngresoProgramado::find($vistaIngresoProgramado->id);
                $ingreso->fecha_promedio = $fecha_promedio;
                $ingreso->update();
            }
        }


        $vistaIngresoProgramadoPadres = DB::table('vista_ingreso_programado')
            ->orderBy('orden_padre', 'ASC')
            ->whereBetween('fecha_promedio', mes_actual())
            ->groupBy('id_padre')
            ->get();

        return view('presupuestosprogramados.index', compact('vistaIngresoProgramadoPadres'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create2($id, $menu)
    {
        switch ($menu) {
            case 1:
                $titulo = "Ingreso Programado";
                $tipo = 2;
                break;
            case 2:
                $titulo = "Ingreso Ejecutado";
                $tipo = 2;
                break;
            case 3:
                $titulo = "Egreso Programado";
                $tipo = 1;
                break;
            case 4:
                $titulo = "Egreso Ejecutado";
                $tipo = 1;
                break;
        }

        $vistaCategoriaPadres = DB::table('vista_categoria_padres')
            ->where('tipo', '=', $tipo)
            ->orderBy('orden', 'ASC')
            ->get();

        $vistaCategorias = DB::table('vista_categorias')
            ->where('id_padre', '=', $id)
            ->orderBy('orden', 'ASC')
            ->get();

        $frecuencias = Frecuencia::all();

        return view('presupuestosprogramados.create', [
            'vistaCategoriaPadres' => $vistaCategoriaPadres,
            'vistaCategorias' => $vistaCategorias,
            'frecuencias' => $frecuencias,
            'id_categoria' => $id,
            'menu' => $menu,
            'titulo' => $titulo
        ]);
    }

    public function create($id, Request $request)
    {
        $titulo = "Egreso Programado";

        $vistaCategoriaPadres = VistaCategoriaPadre::all();

        $vistaCategorias = DB::table('vista_categorias')
            ->where('id_padre', '=', $id)
            ->orderBy('orden', 'ASC')
            ->get();

        $frecuencias = Frecuencia::all();

        return view('presupuestosprogramados.create', compact(
            'titulo',
            'vistaCategoriaPadres',
            'vistaCategorias',
            'frecuencias',
            'id'
        ));
    }

    public function subcategorias($id)
    {
        $subcategorias = DB::table('vista_categorias')
            ->where('id_padre', '=', $id)
            ->orderBy('orden', 'ASC')
            ->get();

        return $subcategorias;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store2(Request $request)
    {
        if (request('menu') == 1 or request('menu') == 2) {
            $ingreso = new Ingreso();
            $ingreso->id_categoria = request('subcategoria');
            $ingreso->fecha = request('inicio');

            if (request('menu') == 1) {
                $ingreso->monto_programado = request('monto');
                $ingreso->monto_ejecutado = 0;
            } else {
                $ingreso->monto_programado = 0;
                $ingreso->monto_ejecutado = request('monto');
            }

            $ingreso->estado = 1;
            $ingreso->save();

            $ingresoSetting = new IngresoSetting();
            $ingresoSetting->id_ingreso = $ingreso->id;
            $ingresoSetting->id_frecuencia = request('frecuencia');
            $ingresoSetting->fecha_inicio = request('inicio');
            $ingresoSetting->fecha_fin = request('fin');
            $ingresoSetting->sin_caducidad = request('sin_caducidad');
            $ingresoSetting->estado = 1;
            $ingresoSetting->save();

            return redirect()->route('presupuestosprogramados.index');
        } else {
            $egreso = new Egreso();
            $egreso->id_categoria = request('subcategoria');
            $egreso->fecha = request('inicio');

            if (request('menu') == 3) {
                $egreso->monto_programado = request('monto');
                $egreso->monto_ejecutado = 0;
            } else {
                $egreso->monto_programado = 0;
                $egreso->monto_ejecutado = request('monto');
            }

            $egreso->estado = 1;
            $egreso->save();

            $egresoSetting = new EgresoSetting();
            $egresoSetting->id_egreso = $egreso->id;
            $egresoSetting->id_frecuencia = request('frecuencia');
            $egresoSetting->fecha_inicio = request('inicio');
            $egresoSetting->fecha_fin = request('fin');
            $egresoSetting->sin_caducidad = request('sin_caducidad');
            $egresoSetting->estado = 1;
            $egresoSetting->save();

            return redirect()->route('presupuestosejecutados.index');
        }
    }

    public function store(Request $request)
    {
        $vistaCategorias = DB::table('vista_categorias')
            ->where('id_padre', '=', request('id_categoria'))
            ->orderBy('orden', 'ASC')
            ->get();

        foreach ($vistaCategorias as $vistaCategoria) {

            $input_monto = "monto_" . $vistaCategoria->id;
            $input_frecuencia = "frecuencia_" . $vistaCategoria->id;
            $input_frecuencia = "frecuencia_" . $vistaCategoria->id;
            $input_sin_caducidad = "sin_caducidad_" . $vistaCategoria->id;
            $input_inicio = "inicio_" . $vistaCategoria->id;
            $input_fin = "fin_" . $vistaCategoria->id;
            $monto = request($input_monto) + 0;

            if ($monto > 0) {
                $ingresoProgramado = new IngresoProgramado();
                $ingresoProgramado->id_categoria = $vistaCategoria->id;
                $ingresoProgramado->monto_programado = $monto;
                $ingresoProgramado->id_frecuencia = request($input_frecuencia);
                $ingresoProgramado->sin_caducidad = request($input_sin_caducidad);
                $ingresoProgramado->fecha_inicio = request($input_inicio);
                $ingresoProgramado->fecha_fin = request($input_fin);
                $ingresoProgramado->estado = 1;
                $ingresoProgramado->id_user = 1;
                $ingresoProgramado->save();
            }
        }

        return redirect()->route('presupuestosprogramados.index');
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
            ->where('tipo', '=', 2)
            ->orderBy('orden', 'ASC')
            ->get();

        $frecuencias = Frecuencia::all();

        $titulo = "Editar Ingreso";

        $ingreso = Ingreso::find($id);
        $ingresoSetting = IngresoSetting::where('id_ingreso', $ingreso->id)->first();

        $idCategoriaPadre = DB::table('vista_categorias')
            ->where('id', '=', $ingreso->id_categoria)
            ->first();

        $id_categoria_padre = $idCategoriaPadre->id_padre;

        $vistaCategorias = DB::table('vista_categorias')
            ->where('id_padre', '=', $id_categoria_padre)
            ->orderBy('orden', 'ASC')
            ->get();

        return view('presupuestosprogramados.edit', [
            'vistaCategoriaPadres' => $vistaCategoriaPadres,
            'vistaCategorias' => $vistaCategorias,
            'id_categoria_padre' => $id_categoria_padre,
            'frecuencias' => $frecuencias,
            'ingreso' => $ingreso,
            'ingresoSetting' => $ingresoSetting,
            'menu' => $menu,
            'titulo' => $titulo
        ]);
    }

    public function edit($id, $menu)
    {
        $titulo = "Egreso Programado";

        $vistaCategoriaPadre = DB::table('vista_categoria_padres')
            ->where('id', '=', $id)
            ->orderBy('orden', 'ASC')
            ->first();

        $vistaCategorias = DB::table('vista_categorias')
            ->where('id_padre', '=', $id)
            ->orderBy('orden', 'ASC')
            ->get();

        $frecuencias = Frecuencia::all();

        $vistaIngresoProgramados = DB::table('vista_ingreso_programado')
            ->where('id_padre', '=', $id)
            ->orderBy('orden_categoria', 'ASC')
            ->get();

        foreach ($vistaIngresoProgramados as $vistaIngresoProgramado) {
            $id_ingreso_programado[$vistaIngresoProgramado->id_categoria] = $vistaIngresoProgramado->id;
            $monto[$vistaIngresoProgramado->id_categoria] = $vistaIngresoProgramado->monto_programado;
            $id_frecuencia[$vistaIngresoProgramado->id_categoria] = $vistaIngresoProgramado->id_frecuencia;
            $caducidad[$vistaIngresoProgramado->id_categoria] = $vistaIngresoProgramado->sin_caducidad + 0;
            $fecha_inicio[$vistaIngresoProgramado->id_categoria] = $vistaIngresoProgramado->fecha_inicio;
            $fecha_fin[$vistaIngresoProgramado->id_categoria] = $vistaIngresoProgramado->fecha_fin;
        }

        return view('presupuestosprogramados.edit', compact(
            'titulo',
            'id',
            'vistaCategoriaPadre',
            'vistaCategorias',
            'frecuencias',
            'id_ingreso_programado',
            'monto',
            'id_frecuencia',
            'caducidad',
            'fecha_inicio',
            'fecha_fin'
        ));
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
        $ingreso = Ingreso::find(request('id'));
        $ingreso->id_categoria = request('subcategoria');
        $ingreso->monto_programado = request('monto_programado');
        $ingreso->monto_ejecutado = request('monto_ejecutado');
        $ingreso->fecha = request('inicio');
        $ingreso->update();

        $idIngresoSetting = IngresoSetting::where('id_ingreso', request('id'))->first();

        $ingresoSetting = IngresoSetting::find($idIngresoSetting->id);
        $ingresoSetting->id_frecuencia = request('frecuencia');
        $ingresoSetting->fecha_inicio = request('inicio');
        $ingresoSetting->fecha_fin = request('fin');
        $ingresoSetting->sin_caducidad = request('sin_caducidad');
        $ingresoSetting->update();

        return redirect()->route('presupuestosprogramados.index');
    }

    public function update(Request $request)
    {
        $vistaCategorias = DB::table('vista_categorias')
            ->where('id_padre', '=', request('id_categoria'))
            ->orderBy('orden', 'ASC')
            ->get();

        foreach ($vistaCategorias as $vistaCategoria) {

            $input_id = "id_" . $vistaCategoria->id;
            $input_monto = "monto_" . $vistaCategoria->id;
            $input_frecuencia = "frecuencia_" . $vistaCategoria->id;
            $input_frecuencia = "frecuencia_" . $vistaCategoria->id;
            $input_sin_caducidad = "sin_caducidad_" . $vistaCategoria->id;
            $input_inicio = "inicio_" . $vistaCategoria->id;
            $input_fin = "fin_" . $vistaCategoria->id;
            $monto = request($input_monto) + 0;

            if ($monto > 0) {
                $ingresoProgramado = IngresoProgramado::find(request($input_id));
                $ingresoProgramado->monto_programado = $monto;
                $ingresoProgramado->id_frecuencia = request($input_frecuencia);
                $ingresoProgramado->sin_caducidad = request($input_sin_caducidad);
                $ingresoProgramado->fecha_inicio = request($input_inicio);
                $ingresoProgramado->fecha_fin = request($input_fin);
                $ingresoProgramado->update();
            }
        }

        return redirect()->route('presupuestosprogramados.index');
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
        $ingreso = Ingreso::find($id);
        $ingreso->estado = 0;
        $ingreso->update();

        $idIngresoSetting = IngresoSetting::where('id_ingreso', $id)->first();

        $ingresoSetting = IngresoSetting::find($idIngresoSetting->id);
        $ingresoSetting->estado = 0;
        $ingresoSetting->update();

        return redirect()->route('presupuestosprogramados.index');
    }
}
