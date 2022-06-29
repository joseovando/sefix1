<?php

use App\Models\Categoria;
use App\Models\EgresoProgramado;
use App\Models\IngresoProgramado;

$categoria_adicional = request('categoria_adicional');
$monto_adicional = request('monto_adicional');
$frecuencia_adicional = request('frecuencia_adicional');
$sin_caducidad_adicional = request('sin_caducidad_adicional');
$inicio_adicional = request('inicio_adicional');
$fin_adicional = request('fin_adicional');
$id_categoria_adicional = request('id_categoria_adicional');
$id_adicional = request('id_adicional');
$nueva_categoria_id = array();
$caducidad_adicional = array();
$categoria_adicional_id = array();

for ($i = 0; $i < request('cantidad_tr'); $i++) {

    $monto = $monto_adicional[$i] + 0;
    $neo_presupuesto = $id_adicional[$i] + 0;
    $neo_categoria = $id_categoria_adicional[$i] + 0;

    if ($sin_caducidad_adicional[$i] == 'true') {
        $valor_caducidad = 1;
    } else {
        $valor_caducidad = 0;
    }

    $caducidad_adicional[$i] = $valor_caducidad;

    if ($monto > 0) {

        /* Guardando Categoria */
        $vistaCategoriaPadres = DB::table('vista_categorias')
            ->where('id_padre', '=', request('id_categoria'))
            ->orderBy('orden', 'DESC')
            ->first();

        if (!isset($vistaCategoriaPadres)) {
            $orden = 0;
        } else {
            $orden = $vistaCategoriaPadres->orden;
        }

        $orden = $orden + 1;

        $vistaCategoria = DB::table('vista_categoria_padres')
            ->where('id', '=', request('id_categoria'))
            ->orderBy('orden', 'DESC')
            ->first();

        if ($neo_categoria == 0) {
            $categoria = new Categoria();
            $categoria->categoria = $categoria_adicional[$i];
            $categoria->id_padre =  request('id_categoria');
            $categoria->orden =  $orden;
            $categoria->icono =  $vistaCategoria->icono;
            $categoria->fondo =  $vistaCategoria->fondo;
            $categoria->plantilla =  0;
            $categoria->estado = 1;
            $categoria->id_user = auth()->id();
            $categoria->tipo = request('tipo');
            $categoria->comercial = request('comercial');
            $categoria->save();

            $categoria_adicional_id[$i] = $categoria->id;
        }
        /* Guardando Categoria */

        if (request('tipo') == 1) {

            if ($neo_presupuesto > 0) {
                $ingresoProgramado = IngresoProgramado::find($neo_presupuesto);
                $ingresoProgramado->monto_programado = $monto;
                $ingresoProgramado->id_frecuencia = $frecuencia_adicional[$i];
                $ingresoProgramado->sin_caducidad = $valor_caducidad;
                $ingresoProgramado->fecha_inicio = $inicio_adicional[$i];
                $ingresoProgramado->fecha_fin = $fin_adicional[$i];
                $ingresoProgramado->update();
            } else {
                $ingresoProgramado = new IngresoProgramado();
                $ingresoProgramado->id_categoria = $categoria->id;
                $ingresoProgramado->monto_programado = $monto;
                $ingresoProgramado->id_frecuencia = $frecuencia_adicional[$i];
                $ingresoProgramado->sin_caducidad = $valor_caducidad;
                $ingresoProgramado->fecha_inicio = $inicio_adicional[$i];
                $ingresoProgramado->fecha_fin = $fin_adicional[$i];
                $ingresoProgramado->estado = 1;
                $ingresoProgramado->id_user = auth()->id();
                $ingresoProgramado->save();

                $nueva_categoria_id[$i] = $ingresoProgramado->id;
            }
        } else {

            if ($neo_presupuesto > 0) {
                $egresoProgramado = EgresoProgramado::find($neo_presupuesto);
                $egresoProgramado->monto_programado = $monto;
                $egresoProgramado->id_frecuencia = $frecuencia_adicional[$i];
                $egresoProgramado->sin_caducidad = $valor_caducidad;
                $egresoProgramado->fecha_inicio = $inicio_adicional[$i];
                $egresoProgramado->fecha_fin = $fin_adicional[$i];
                $egresoProgramado->update();
            } else {
                $egresoProgramado = new EgresoProgramado();
                $egresoProgramado->id_categoria = $categoria->id;
                $egresoProgramado->monto_programado = $monto;
                $egresoProgramado->id_frecuencia = $frecuencia_adicional[$i];
                $egresoProgramado->sin_caducidad = $valor_caducidad;
                $egresoProgramado->fecha_inicio = $inicio_adicional[$i];
                $egresoProgramado->fecha_fin = $fin_adicional[$i];
                $egresoProgramado->estado = 1;
                $egresoProgramado->id_user = auth()->id();
                $egresoProgramado->save();

                $nueva_categoria_id[$i] = $egresoProgramado->id;
            }
        }
    }
}
