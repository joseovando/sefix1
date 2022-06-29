<?php

use App\Models\SubcategoriaFavorita;

$vistaCategorias = request('vistaCategoria');
$arrayCheck = request('check_categorias');
$arrayDisabled = array();

foreach ($vistaCategorias as $vistaCategoria) {
    $subcategoria_favorita = DB::table('subcategoria_favorita')
        ->where('id_categoria', '=', $vistaCategoria['id'])
        ->where('id_user', '=', auth()->id())
        ->first();

    $arrayDisabled[$vistaCategoria['id']] = 0;

    if (!isset($subcategoria_favorita)) {
        if ($arrayCheck[$vistaCategoria['id']] == "false") {
            $favorita = new SubcategoriaFavorita();
            $favorita->id_categoria = $vistaCategoria['id'];
            $favorita->orden =  0;
            $favorita->plantilla =  0;
            $favorita->estado = 1;
            $favorita->id_user = auth()->id();
            $favorita->save();

            $arrayDisabled[$vistaCategoria['id']] = 1;
        }
    } else {
        if ($arrayCheck[$vistaCategoria['id']] == "false") {
            $favorita = SubcategoriaFavorita::find($subcategoria_favorita->id);
            $favorita->estado = 1;
            $favorita->update();
            $arrayDisabled[$vistaCategoria['id']] = 1;
        } else {
            $favorita = SubcategoriaFavorita::find($subcategoria_favorita->id);
            $favorita->estado = 0;
            $favorita->update();
        }
    }
}