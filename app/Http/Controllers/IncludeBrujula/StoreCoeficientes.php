<?php

use App\Models\BrujulaCoeficiente;

$coeficiente = request('coeficiente');
$id_coeficiente = request('id_coeficiente');
$valor_calculo = request('valor_calculo');
$valor_personalizado = request('valor_personalizado');
$informacion_adicional = request('informacion_adicional');
$orden = 0;

if ($valor_calculo == "I") {
    $valor_calculo_value = 1;
} else {
    $valor_calculo_value = 0;
}

$vistaCategoriaPadres = DB::table('vista_categorias')
    ->where('id', '=', $coeficiente)
    ->orderBy('id', 'ASC')
    ->first();

$tipo_coeficiente = $vistaCategoriaPadres->tipo;

$vistaBrujulaCoeficientes = DB::table('vista_brujula_coeficientes')
    ->where('tipo', '=', $tipo_coeficiente)
    ->where('id_user', '=', auth()->id())
    ->orderBy('orden', 'DESC')
    ->first();

if (isset($vistaBrujulaCoeficientes)) {
    $orden = $vistaBrujulaCoeficientes->orden;
    $orden = $orden + 1;
} else {
    $orden = 1;
}

if ($id_coeficiente == 0) {
    $brujulaCoeficiente = new BrujulaCoeficiente();
    $brujulaCoeficiente->id_coeficiente = $coeficiente;
    $brujulaCoeficiente->orden = $orden;
    $brujulaCoeficiente->id_valor_calculo = $valor_calculo_value;
    $brujulaCoeficiente->valor_sistema = 0;
    $brujulaCoeficiente->valor_usuario = $valor_personalizado;
    $brujulaCoeficiente->informacion_adicional = $informacion_adicional;
    $brujulaCoeficiente->id_usuario = auth()->id();
    $brujulaCoeficiente->estado = 1;
    $brujulaCoeficiente->version = 1;
    $brujulaCoeficiente->save();

    $id_brujula_coeficiente = $brujulaCoeficiente->id;
} else {
    $brujulaCoeficiente = BrujulaCoeficiente::where([
        ['id', $id_coeficiente],
        ['id_usuario', auth()->id()],
    ])->first();

    $brujulaCoeficiente->id_coeficiente = $coeficiente;
    $brujulaCoeficiente->id_valor_calculo = $valor_calculo_value;
    $brujulaCoeficiente->valor_usuario = $valor_personalizado;
    $brujulaCoeficiente->informacion_adicional = $informacion_adicional;
    $brujulaCoeficiente->update();

    $id_brujula_coeficiente = $id_coeficiente;
}
