<?php

$search =  request('search');
$entrada = explode(' | ', $search);
$contador = 0;

if (stristr($search, '|') === FALSE) {
    $vistaCategorias = DB::table('vista_categorias')
        ->where('categoria', 'like', '%' . $search . '%')
        ->where('estado', '=', 1)
        ->orderBy('tipo', 'ASC')
        ->orderBy('categoria_padre', 'ASC')
        ->orderBy('categoria', 'ASC')
        ->get();
} else {
    $vistaCategorias = DB::table('vista_categorias')
        ->where('categoria_padre', 'like', '%' . $entrada[1] . '%')
        ->where('categoria', 'like', '%' . $entrada[0] . '%')
        ->where('estado', '=', 1)
        ->orderBy('tipo', 'ASC')
        ->orderBy('categoria_padre', 'ASC')
        ->orderBy('categoria', 'ASC')
        ->get();
}

foreach ($vistaCategorias as $vistaCategoria) {
    $contador++;
}

if ($contador == 0) {
    $search_result = 0;
} else {
    $search_result = 1;

    foreach ($vistaCategorias as $vistaCategoria) {
        $id = $vistaCategoria->id_padre;
    }
}
