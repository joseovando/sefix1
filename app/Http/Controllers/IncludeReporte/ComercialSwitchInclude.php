<?php

$categoriaComercial = DB::table('categoria_comercial')
    ->where('estado', '=', 1)
    ->where('id_user', '=', auth()->id())
    ->orderBy('comercial', 'ASC')
    ->first();

if (!isset($categoriaComercial)) {
    $comercial = 0;
} else {
    $comercial = $categoriaComercial->comercial;
}
