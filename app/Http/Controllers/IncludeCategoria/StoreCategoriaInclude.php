<?php

use App\Models\Categoria;

$vistaUserRol = DB::table('vista_user_rol')
    ->where('user_id', '=', auth()->id())
    ->first();

if ($vistaUserRol->rol_name == "administrator") {
    $plantilla = 1;
} else {
    $plantilla = 0;
}

$vistaCategoriaPadres = DB::table('vista_categoria_padres')
    ->where('orden_tipo', '=', request('tipo_categoria'))
    ->orderBy('orden', 'DESC')
    ->first();

$orden = $vistaCategoriaPadres->orden;
$orden = $orden + 1;

$categoria = new Categoria();
$categoria->categoria = request('categoria');
$categoria->id_padre =  0;
$categoria->orden =  $orden;
$categoria->icono =  request('logo_categoria');
$categoria->fondo =  request('fondo_categoria');
$categoria->plantilla =  $plantilla;
$categoria->estado = 1;
$categoria->id_user = auth()->id();
$categoria->tipo =  request('tipo_categoria');
$categoria->comercial =  request('comercial');
$categoria->save();
