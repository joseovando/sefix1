<?php

if (stristr($search, '|') === FALSE) {
    $vistaCategoria = DB::table('vista_categorias')
        ->where('categoria', 'like', '%' . $search . '%')
        ->where('estado', '=', 1)
        ->orderBy('tipo', 'ASC')
        ->orderBy('categoria_padre', 'ASC')
        ->orderBy('categoria', 'ASC')
        ->first();
} else {
    $vistaCategoria = DB::table('vista_categorias')
        ->where('categoria_padre', 'like', '%' . $entrada[1] . '%')
        ->where('categoria', 'like', '%' . $entrada[0] . '%')
        ->where('estado', '=', 1)
        ->orderBy('tipo', 'ASC')
        ->orderBy('categoria_padre', 'ASC')
        ->orderBy('categoria', 'ASC')
        ->first();
}
