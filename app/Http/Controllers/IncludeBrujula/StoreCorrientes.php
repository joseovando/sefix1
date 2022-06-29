<?php

use App\Models\BrujulaCorriente;

$id_brujula_corriente = request('id_brujula_corriente');
$tipo_corriente = request('tipo_corriente');
$categoria = request('categoria');
$cuenta = request('cuenta');
$ano_inicio = request('ano_inicio');
$ano_culminacion = request('ano_culminacion');
$tipo_monto = request('tipo_monto');
$monto = request('monto');
$coeficiente_crecimiento = request('coeficiente_crecimiento') + 0;

if ($tipo_monto == "I") {
    $tipo_monto_value = 1;
} else {
    $tipo_monto_value = 0;
}

if ($id_brujula_corriente == 0) {
    $brujulaCorriente = new BrujulaCorriente();
    $brujulaCorriente->tipo = $tipo_corriente;
    $brujulaCorriente->id_categoria = $categoria;
    $brujulaCorriente->cuenta = $cuenta;
    $brujulaCorriente->ano_inicio = $ano_inicio;
    $brujulaCorriente->ano_culminacion = $ano_culminacion;
    $brujulaCorriente->id_tipo_monto = $tipo_monto_value;
    $brujulaCorriente->monto = $monto;
    $brujulaCorriente->coeficiente_crecimiento = $coeficiente_crecimiento;
    $brujulaCorriente->id_user = auth()->id();
    $brujulaCorriente->estado = 1;
    $brujulaCorriente->version = 1;
    $brujulaCorriente->save();

    $id_brujula_corriente = $brujulaCorriente->id;
} else {
    $brujulaCorriente = BrujulaCorriente::where([
        ['id', $id_brujula_corriente],
        ['id_user', auth()->id()],
    ])->first();

    $brujulaCorriente->tipo = $tipo_corriente;
    $brujulaCorriente->id_categoria = $categoria;
    $brujulaCorriente->cuenta = $cuenta;
    $brujulaCorriente->ano_inicio = $ano_inicio;
    $brujulaCorriente->ano_culminacion = $ano_culminacion;
    $brujulaCorriente->id_tipo_monto = $tipo_monto_value;
    $brujulaCorriente->monto = $monto;
    $brujulaCorriente->coeficiente_crecimiento = $coeficiente_crecimiento;
    $brujulaCorriente->update();
}
