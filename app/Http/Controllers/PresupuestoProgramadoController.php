<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\EgresoProgramado;
use App\Models\IngresoProgramado;
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
    public function create($id, $menu, $mes, $ano, $estado, Request $request)
    {
        $navegador_mobile = navegador_mobile();

        include('IncludePresupuestoProgramado/MenuTituloTipoInclude.php');
        include('IncludePresupuestoProgramado/IfLlaveFormInclude.php');

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

        $frecuencias = DB::table('frecuencia')
            ->where('estado', '=', 1)
            ->orderBy('orden', 'ASC')
            ->get();

        include('IncludePresupuestoProgramado/TablePresupuestoProgramadoInclude.php');

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
            'id_ingreso_programado',
            'monto',
            'id_frecuencia',
            'caducidad',
            'fecha_inicio',
            'fecha_fin',
            'estado',
            'navegador_mobile'
        ));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vistaCategorias = DB::table('vista_categorias')
            ->where('id_padre', '=', request('id_categoria'))
            ->where('estado', '=', 1)
            ->orderBy('orden', 'ASC')
            ->get();

        foreach ($vistaCategorias as $vistaCategoria) {

            $input_id = "id_" . $vistaCategoria->id;
            $id_ingreso_programado = request($input_id) + 0;
            $input_monto = "monto_" . $vistaCategoria->id;
            $input_frecuencia = "frecuencia_" . $vistaCategoria->id;
            $input_sin_caducidad = "sin_caducidad_" . $vistaCategoria->id;

            $valor_caducidad = request($input_sin_caducidad);
            if ($valor_caducidad == 'on') {
                $valor_caducidad = 1;
            }

            $input_inicio = "inicio_" . $vistaCategoria->id;
            $input_fin = "fin_" . $vistaCategoria->id;
            $monto = request($input_monto) + 0;

            if (request('tipo') == 1) {

                if ($id_ingreso_programado > 0) {
                    if ($monto > 0) {
                        $ingresoProgramado = IngresoProgramado::find(request($input_id));
                        $ingresoProgramado->monto_programado = $monto;
                        $ingresoProgramado->id_frecuencia = request($input_frecuencia);
                        $ingresoProgramado->sin_caducidad = $valor_caducidad;
                        $ingresoProgramado->fecha_inicio = request($input_inicio);
                        $ingresoProgramado->fecha_fin = request($input_fin);
                        $ingresoProgramado->update();
                    }
                } else {
                    if ($monto > 0) {
                        $ingresoProgramado = new IngresoProgramado();
                        $ingresoProgramado->id_categoria = $vistaCategoria->id;
                        $ingresoProgramado->monto_programado = $monto;
                        $ingresoProgramado->id_frecuencia = request($input_frecuencia);
                        $ingresoProgramado->sin_caducidad = $valor_caducidad;
                        $ingresoProgramado->fecha_inicio = request($input_inicio);
                        $ingresoProgramado->fecha_fin = request($input_fin);
                        $ingresoProgramado->estado = 1;
                        $ingresoProgramado->id_user = auth()->id();
                        $ingresoProgramado->save();
                    }
                }
            } else {

                if ($id_ingreso_programado > 0) {
                    if ($monto > 0) {
                        $egresoProgramado = EgresoProgramado::find(request($input_id));
                        $egresoProgramado->monto_programado = $monto;
                        $egresoProgramado->id_frecuencia = request($input_frecuencia);
                        $egresoProgramado->sin_caducidad = $valor_caducidad;
                        $egresoProgramado->fecha_inicio = request($input_inicio);
                        $egresoProgramado->fecha_fin = request($input_fin);
                        $egresoProgramado->update();
                    }
                } else {
                    if ($monto > 0) {
                        $egresoProgramado = new EgresoProgramado();
                        $egresoProgramado->id_categoria = $vistaCategoria->id;
                        $egresoProgramado->monto_programado = $monto;
                        $egresoProgramado->id_frecuencia = request($input_frecuencia);
                        $egresoProgramado->sin_caducidad = $valor_caducidad;
                        $egresoProgramado->fecha_inicio = request($input_inicio);
                        $egresoProgramado->fecha_fin = request($input_fin);
                        $egresoProgramado->estado = 1;
                        $egresoProgramado->id_user = auth()->id();
                        $egresoProgramado->save();
                    }
                }
            }
        }

        $estado = 1;

        return redirect()->route('presupuestosprogramados.create', [
            'id' => request('id_categoria'),
            'menu' => request('menu'),
            'ano' => request('ano_actual'),
            'mes' => request('mes_actual'),
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
