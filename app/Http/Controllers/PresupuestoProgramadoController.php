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

function meses()
{
    $meses = array(
        1 => 'Enero',
        2 => 'Febrero',
        3 => 'Marzo',
        4 => 'Abril',
        5 => 'Mayo',
        6 => 'Junio',
        7 => 'Julio',
        8 => 'Agosto',
        9 => 'Septiembre',
        10 => 'Octubre',
        11 => 'Noviembre',
        12 => 'Diciembre'
    );
    return $meses;
}

function fechas_first_last($fecha_actual)
{
    $fecha_actual = strtotime($fecha_actual);
    $fecha[0] = date("Y", $fecha_actual);
    $fecha[1] = date("m", $fecha_actual);
    return $fecha;
}

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\EgresoProgramado;
use App\Models\IngresoProgramado;
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
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id, $menu, $mes, $ano, $estado, Request $request)
    {
        switch ($menu) {
            case 1:
                $titulo = "Ingreso Programado";
                $tipo = 1;
                break;
            case 2:
                $titulo = "Ingreso Ejecutado";
                $tipo = 1;
                break;
            case 3:
                $titulo = "Egreso Programado";
                $tipo = 2;
                break;
            case 4:
                $titulo = "Egreso Ejecutado";
                $tipo = 2;
                break;
        }

        if (request('llave_form') == 1) {
            $ano_actual = request('ano_actual');
            $ano_actual_inicio = $ano_actual - 20;
            $ano_actual_fin = $ano_actual + 20;
            $mes_actual = request('mes_actual');
            $fecha_actual = $ano_actual . "-" . $mes_actual . "-01";
            $meses = meses();
        } else {
            $ano_actual = $ano;
            $ano_actual_inicio = $ano_actual - 20;
            $ano_actual_fin = $ano_actual + 20;
            $mes_actual = $mes;
            $fecha_actual = $ano_actual . "-" . $mes_actual . "-01";
            $meses = meses();
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

        $frecuencias = DB::table('frecuencia')
            ->where('estado', '=', 1)
            ->orderBy('orden', 'ASC')
            ->get();

        if ($tipo == 1) {
            $vistaIngresoProgramados = DB::table('vista_ingreso_programado')
                ->where('id_padre', '=', $id)
                ->where('estado_ingreso_programado', '=', 1)
                ->where('id_user_ingreso_programado', '=', auth()->id())
                ->orderBy('orden_categoria', 'ASC')
                ->get();
        } else {
            $vistaIngresoProgramados = DB::table('vista_egreso_programado')
                ->where('id_padre', '=', $id)
                ->where('estado_egreso_programado', '=', 1)
                ->where('id_user_egreso_programado', '=', auth()->id())
                ->orderBy('orden_categoria', 'ASC')
                ->get();
        }

        $id_ingreso_programado = array();
        $monto = array();
        $id_frecuencia = array();
        $caducidad = array();
        $fecha_inicio = array();
        $fecha_fin = array();

        foreach ($vistaIngresoProgramados as $vistaIngresoProgramado) {
            $valor_caducidad = $vistaIngresoProgramado->sin_caducidad + 0;

            if ($vistaIngresoProgramado->id_frecuencia == 1) //Unico
            {
                $id_ingreso_programado[$vistaIngresoProgramado->id_categoria] = $vistaIngresoProgramado->id;
                $monto[$vistaIngresoProgramado->id_categoria] = $vistaIngresoProgramado->monto_programado;
                $id_frecuencia[$vistaIngresoProgramado->id_categoria] = $vistaIngresoProgramado->id_frecuencia;
                $caducidad[$vistaIngresoProgramado->id_categoria] = $valor_caducidad;
                $fecha_inicio[$vistaIngresoProgramado->id_categoria] = $vistaIngresoProgramado->fecha_inicio;
                $fecha_fin[$vistaIngresoProgramado->id_categoria] = $vistaIngresoProgramado->fecha_fin;
            }

            if ($valor_caducidad == 1) {
                $rango_fechas = fechas_first_last($fecha_actual);
                $rango_inicio = fechas_first_last($vistaIngresoProgramado->fecha_inicio);

                if (
                    $rango_inicio[0] <= $rango_fechas[0]
                    and $rango_inicio[1] <= $rango_fechas[1]
                ) {
                    $id_ingreso_programado[$vistaIngresoProgramado->id_categoria] = $vistaIngresoProgramado->id;
                    $monto[$vistaIngresoProgramado->id_categoria] = $vistaIngresoProgramado->monto_programado;
                    $id_frecuencia[$vistaIngresoProgramado->id_categoria] = $vistaIngresoProgramado->id_frecuencia;
                    $caducidad[$vistaIngresoProgramado->id_categoria] = $valor_caducidad;
                    $fecha_inicio[$vistaIngresoProgramado->id_categoria] = $vistaIngresoProgramado->fecha_inicio;
                    $fecha_fin[$vistaIngresoProgramado->id_categoria] = $vistaIngresoProgramado->fecha_fin;
                }
            } else {

                $rango_fechas = fechas_first_last($fecha_actual);
                $rango_inicio = fechas_first_last($vistaIngresoProgramado->fecha_inicio);
                $rango_fin = fechas_first_last($vistaIngresoProgramado->fecha_fin);

                if (
                    $rango_inicio[0] <= $rango_fechas[0]
                    and $rango_inicio[1] <= $rango_fechas[1]
                    and $rango_fin[0] >= $rango_fechas[0]
                    and $rango_fin[1] >= $rango_fechas[1]
                ) {
                    $id_ingreso_programado[$vistaIngresoProgramado->id_categoria] = $vistaIngresoProgramado->id;
                    $monto[$vistaIngresoProgramado->id_categoria] = $vistaIngresoProgramado->monto_programado;
                    $id_frecuencia[$vistaIngresoProgramado->id_categoria] = $vistaIngresoProgramado->id_frecuencia;
                    $caducidad[$vistaIngresoProgramado->id_categoria] = $valor_caducidad;
                    $fecha_inicio[$vistaIngresoProgramado->id_categoria] = $vistaIngresoProgramado->fecha_inicio;
                    $fecha_fin[$vistaIngresoProgramado->id_categoria] = $vistaIngresoProgramado->fecha_fin;
                }
            }
        }

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
            'estado'
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
