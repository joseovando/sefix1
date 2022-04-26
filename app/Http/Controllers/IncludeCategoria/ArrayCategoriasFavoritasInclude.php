<?php

$vistaCategoriaPlantillas = DB::table('vista_categoria_padres')
    ->where('tipo', '=', $tipo)
    ->where('estado', '=', 1)
    ->where('comercial', '=', $comercial)
    ->where('plantilla', '=', 1)
    ->orderBy('categoria', 'ASC')
    ->get();

$vistaCategoriaUsers = DB::table('vista_categoria_padres')
    ->where('tipo', '=', $tipo)
    ->where('estado', '=', 1)
    ->where('comercial', '=', $comercial)
    ->where('id_user', '=', auth()->id())
    ->orderBy('categoria', 'ASC')
    ->get();

$contador = 0;
$arrayIdCategoria = array();
$arrayCategoria = array();
$arrayCheckCategoria = array();

foreach ($vistaCategoriaFavoritas as $vistaCategoriaFavorita) {
    $arrayIdCategoria[$contador] = $vistaCategoriaFavorita->id;
    $arrayCategoria[$contador] = $vistaCategoriaFavorita->categoria;
    $arrayCheckCategoria[$contador] = 1;
    $contador++;
}

foreach ($vistaCategoriaUsers as $vistaCategoriaUser) {
    $llave = 0;

    foreach ($vistaCategoriaFavoritas as $vistaCategoriaFavorita) {
        if ($vistaCategoriaUser->id ==  $vistaCategoriaFavorita->id) {
            $llave = 1;
        }
    }

    if ($llave == 0) {
        $arrayIdCategoria[$contador] = $vistaCategoriaUser->id;
        $arrayCategoria[$contador] = $vistaCategoriaUser->categoria;
        $arrayCheckCategoria[$contador] = 0;
        $contador++;
    }
}

foreach ($vistaCategoriaPlantillas as $vistaCategoriaPlantilla) {
    $llave = 0;

    foreach ($vistaCategoriaFavoritas as $vistaCategoriaFavorita) {
        if ($vistaCategoriaPlantilla->id ==  $vistaCategoriaFavorita->id) {
            $llave = 1;
        }
    }

    if ($llave == 0) {
        $arrayIdCategoria[$contador] = $vistaCategoriaPlantilla->id;
        $arrayCategoria[$contador] = $vistaCategoriaPlantilla->categoria;
        $arrayCheckCategoria[$contador] = 0;
        $contador++;
    }
}
