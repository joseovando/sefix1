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

$id_categoria = request('id_categoria') + 0;

if ($id_categoria > 0) {
    $categoria = Categoria::where([
        ['id', $id_categoria],
        ['id_user', auth()->id()],
    ])->first();

    $categoria->categoria = request('categoria');
    $categoria->icono =  request('logo_categoria');
    $categoria->fondo =  request('fondo_categoria');
    $categoria->tipo = request('tipo_categoria');
    $categoria->update();

    $categoria_nueva = DB::table('categoria')
        ->where('id_padre', '=', $categoria->id)
        ->orderBy('orden', 'DESC')
        ->first();

    if (isset($categoria_nueva)) {
        $llave_padre = 0;
    } else {
        $llave_padre = 1;
    }
} else {
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

    $categoria_nueva = DB::table('categoria')
        ->where('id_padre', '=', $categoria->id)
        ->orderBy('orden', 'DESC')
        ->first();

    if (isset($categoria_nueva)) {
        $llave_padre = 0;
    } else {
        $llave_padre = 1;
    }
}
