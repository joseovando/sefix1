<?php

use App\Models\CategoriaFavorita;

$contador = 0;

foreach ($vistaCategoriaFavoritas as $vistaCategoriaFavorita) {
    $contador++;
}

if ($contador == 0) {
    $vistaFavoritaPlantillas = DB::table('vista_categoria_favoritas')
        ->where('tipo', '=', $tipo)
        ->where('estado', '=', 1)
        ->where('comercial', '=', $comercial)
        ->where('id_user', '=', 0)
        ->orderBy('orden', 'ASC')
        ->get();

    foreach ($vistaFavoritaPlantillas as $vistaFavoritaPlantilla) {
        $favorita = new CategoriaFavorita();
        $favorita->id_categoria = $vistaFavoritaPlantilla->id;
        $favorita->orden =  $vistaFavoritaPlantilla->orden;
        $favorita->plantilla =  0;
        $favorita->estado = 1;
        $favorita->id_user = auth()->id();
        $favorita->save();
    }

    $vistaCategoriaFavoritas = DB::table('vista_categoria_favoritas')
        ->where('tipo', '=', $tipo)
        ->where('estado', '=', 1)
        ->where('comercial', '=', $comercial)
        ->where('id_user', '=', auth()->id())
        ->orderBy('orden', 'ASC')
        ->get();
}
