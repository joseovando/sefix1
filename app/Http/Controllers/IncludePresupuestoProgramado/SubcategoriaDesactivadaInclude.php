<?php

$categoria_desactivada = array();
$subcategoriaDesactivadas = DB::table('subcategoria_favorita')
    ->where('estado', '=', 1)
    ->where('id_user', '=', auth()->id())
    ->get();

foreach ($subcategoriaDesactivadas as $subcategoriaDesactivada) {
    $categoria_desactivada[$subcategoriaDesactivada->id_categoria] = $subcategoriaDesactivada->id_categoria;
}
