<?php

use App\Models\BrujulaInversiones;

$id_brujula_inversion = request('id_brujula_inversion');
$cuenta = request('cuenta');
$tipo_inversion = request('tipo_inversion');
$ano_inicio = request('ano_inicio');
$ano_culminacion = request('ano_culminacion');
$tipo_capital = request('tipo_capital');
$capital = request('capital');
$interes_anual = request('interes_anual');
$devolucion_capital = request('devolucion_capital');
$coeficiente_crecimiento = request('coeficiente_crecimiento');

if ($tipo_capital == "I") {
    $tipo_capital_value = 1;
} else {
    $tipo_capital_value = 0;
}

if ($devolucion_capital == "I") {
    $devolucion_capital_value = 1;
} else {
    $devolucion_capital_value = 0;
}

if ($id_brujula_inversion == 0) {
    $brujulaInversiones = new BrujulaInversiones();
    $brujulaInversiones->tipo = $tipo_inversion;
    $brujulaInversiones->cuenta = $cuenta;
    $brujulaInversiones->ano_inicio = $ano_inicio;
    $brujulaInversiones->ano_culminacion = $ano_culminacion;
    $brujulaInversiones->id_tipo_capital = $tipo_capital_value;
    $brujulaInversiones->capital = $capital;
    $brujulaInversiones->porcentaje_interes_anual = $interes_anual;
    $brujulaInversiones->tiene_devolucion_capital = $devolucion_capital_value;
    $brujulaInversiones->coeficiente_crecimiento = $coeficiente_crecimiento;
    $brujulaInversiones->id_user = auth()->id();
    $brujulaInversiones->estado = 1;
    $brujulaInversiones->version = 1;
    $brujulaInversiones->save();

    $id_brujula_inversion = $brujulaInversiones->id;
} else {
    $brujulaInversiones = BrujulaInversiones::where([
        ['id', $id_brujula_inversion],
        ['id_user', auth()->id()],
    ])->first();

    $brujulaInversiones->tipo = $tipo_inversion;
    $brujulaInversiones->cuenta = $cuenta;
    $brujulaInversiones->ano_inicio = $ano_inicio;
    $brujulaInversiones->ano_culminacion = $ano_culminacion;
    $brujulaInversiones->id_tipo_capital = $tipo_capital_value;
    $brujulaInversiones->capital = $capital;
    $brujulaInversiones->porcentaje_interes_anual = $interes_anual;
    $brujulaInversiones->tiene_devolucion_capital = $devolucion_capital_value;
    $brujulaInversiones->coeficiente_crecimiento = $coeficiente_crecimiento;
    $brujulaInversiones->update();
}
