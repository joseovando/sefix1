<?php

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
            ->orderBy('fecha_inicio', 'DESC')
            ->get();

        $fecha_actual = date("Y-m-d");

        foreach ($vistaIngresoProgramados as $vistaIngresoProgramado) {

            // Unico
            if ($vistaIngresoProgramado->id_frecuencia == 1) {
                $ingreso = IngresoProgramado::find($vistaIngresoProgramado->id);
                $ingreso->fecha_promedio = $vistaIngresoProgramado->fecha_inicio;
                $ingreso->update();
            }

            // Mensual con fecha de Inicio y Fin 
            if (
                $vistaIngresoProgramado->id_frecuencia == 2
                and $vistaIngresoProgramado->fecha_inicio >= $fecha_actual
                and $vistaIngresoProgramado->fecha_fin <= $fecha_actual
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
        }

        return view('presupuestosprogramados.index', [
            'vistaIngresoProgramados' => $vistaIngresoProgramados
        ]);
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
    public function edit($id, $menu)
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request)
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
