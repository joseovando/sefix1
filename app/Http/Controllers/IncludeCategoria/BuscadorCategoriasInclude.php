<?php

$vistaCategorias = DB::table('vista_categorias')
    ->where('estado', '=', 1)
    ->where('plantilla', '=', 1)
    ->where('comercial', '=', $comercial)
    ->orderBy('tipo', 'ASC')
    ->orderBy('categoria_padre', 'ASC')
    ->orderBy('categoria', 'ASC')
    ->get();

$vistaCategoriaUsers = DB::table('vista_categorias')
    ->where('estado', '=', 1)
    ->where('plantilla', '=', 0)
    ->where('comercial', '=', $comercial)
    ->where('id_user', '=', auth()->id())
    ->orderBy('tipo', 'ASC')
    ->orderBy('categoria_padre', 'ASC')
    ->orderBy('categoria', 'ASC')
    ->get();

$estado = 0;
$json_plantilla = [];

foreach ($vistaCategorias as $vistaCategoria) {
    $json_plantilla[] = $vistaCategoria->categoria . " | " . substr($vistaCategoria->categoria_padre, 0, 25);
}

$json_user = [];

foreach ($vistaCategoriaUsers as $vistaCategoriaUser) {
    $json_user[] = $vistaCategoriaUser->categoria . " | " . substr($vistaCategoriaUser->categoria_padre, 0, 25);
}

$json = array_merge($json_plantilla, $json_user);