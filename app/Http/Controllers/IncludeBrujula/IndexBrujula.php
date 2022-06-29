<?php

$vistaUsersSpecific = DB::table('vista_users_specific')
    ->where('id', '=', auth()->id())
    ->where('estado', '=', 1)
    ->orderBy('name', 'ASC')
    ->first();

$brujulaDatosBasicos = DB::table('brujula_datos_basicos')
    ->where('id_user', '=', auth()->id())
    ->where('estado', '=', 1)
    ->orderBy('id_user', 'ASC')
    ->first();

$vistaCategoriaIngresoPadres = DB::table('vista_categoria_padres')
    ->where('tipo', '=', 1)
    ->where('estado', '=', 1)
    ->where('comercial', '=', 0)
    ->orderBy('orden', 'ASC')
    ->get();

$vistaCategoriaEgresoPadres = DB::table('vista_categoria_padres')
    ->where('tipo', '=', 2)
    ->where('estado', '=', 1)
    ->where('comercial', '=', 0)
    ->orderBy('orden', 'ASC')
    ->get();

$vistaBrujulaIngresosCorrientes = DB::table('vista_brujula_corrientes')
    ->where('tipo', '=', 1)
    ->where('id_user', '=', auth()->id())
    ->where('estado', '=', 1)
    ->orderBy('categoria', 'ASC')
    ->orderBy('cuenta', 'ASC')
    ->get();

$contador_ingresos_corrientes = 0;

foreach ($vistaBrujulaIngresosCorrientes as $vistaBrujulaCorriente) {
    $contador_ingresos_corrientes++;
}

$brujulaInversiones = DB::table('brujula_inversiones')
    ->where('tipo', '=', 1)
    ->where('id_user', '=', auth()->id())
    ->where('estado', '=', 1)
    ->orderBy('cuenta', 'ASC')
    ->get();

$contador_ingresos_inversiones = 0;

foreach ($brujulaInversiones as $brujulaInversion) {
    $contador_ingresos_inversiones++;
}

$vistaBrujulaEgresosCorrientes = DB::table('vista_brujula_corrientes')
    ->where('tipo', '=', 2)
    ->where('id_user', '=', auth()->id())
    ->where('estado', '=', 1)
    ->orderBy('categoria', 'ASC')
    ->orderBy('cuenta', 'ASC')
    ->get();

$contador_egresos_corrientes = 0;

foreach ($vistaBrujulaEgresosCorrientes as $vistaBrujulaCorriente) {
    $contador_egresos_corrientes++;
}

$brujulaPrestamos = DB::table('brujula_inversiones')
    ->where('tipo', '=', 2)
    ->where('id_user', '=', auth()->id())
    ->where('estado', '=', 1)
    ->orderBy('cuenta', 'ASC')
    ->get();

$contador_prestamos = 0;

foreach ($brujulaPrestamos as $brujulaInversion) {
    $contador_prestamos++;
}

$vistaBrujulaCoeficientes = DB::table('vista_brujula_coeficientes')
    ->where('comercial', '=', 0)
    ->where('id_user', '=', auth()->id())
    ->where('estado', '=', 1)
    ->orderBy('tipo', 'ASC')
    ->orderBy('orden', 'ASC')
    ->get();

$comercial = 0;

$vistaCategoriaIngresos = DB::table('vista_categorias')
    ->where('estado', '=', 1)
    ->where('tipo', '=', 1)
    ->where('comercial', '=', $comercial)
    ->orderBy('orden_padre', 'ASC')
    ->orderBy('orden', 'ASC')
    ->get();

$vistaCategoriaEgresos = DB::table('vista_categorias')
    ->where('estado', '=', 1)
    ->where('tipo', '=', 2)
    ->where('comercial', '=', $comercial)
    ->orderBy('orden_padre', 'ASC')
    ->orderBy('orden', 'ASC')
    ->get();
