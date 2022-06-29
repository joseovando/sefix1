<?php

use App\Models\BrujulaDatosBasicos;

$id_datos_basicos = request('id_datos_basicos') + 0;
$expectativa_vida = request('expectativa_vida');
$select_jubilacion = request('select_jubilacion');
$ano_jubilacion = request('ano_jubilacion');
$porcentaje_renta = request('porcentaje_renta');
$select_conyuge = request('select_conyuge');
$fecha_nacimiento_conyuge = request('fecha_nacimiento_conyuge');
$select_jubilacion_conyuge = request('select_jubilacion_conyuge');
$ano_jubilacion_conyuge = request('ano_jubilacion_conyuge');
$porcentaje_renta_conyuge = request('porcentaje_renta_conyuge');

if ($select_jubilacion == "I") {
    $select_jubilacion_value = 1;
} else {
    $select_jubilacion_value = 0;
}

if ($select_conyuge == "I") {
    $select_conyuge_value = 1;
} else {
    $select_conyuge_value = 0;
}

if ($select_jubilacion_conyuge == "I") {
    $select_jubilacion_conyuge_value = 1;
} else {
    $select_jubilacion_conyuge_value = 0;
}

if ($id_datos_basicos == 0) {
    $brujulaDatosBasicos = new BrujulaDatosBasicos();
    $brujulaDatosBasicos->id_user = auth()->id();
    $brujulaDatosBasicos->renta_jubilacion = $select_jubilacion_value;
    $brujulaDatosBasicos->ano_renta_jubilacion = $ano_jubilacion;
    $brujulaDatosBasicos->porcentaje_renta_jubilacion = $porcentaje_renta;
    $brujulaDatosBasicos->expectativa_vida = $expectativa_vida;
    $brujulaDatosBasicos->tiene_conyuge = $select_conyuge_value;
    $brujulaDatosBasicos->fecha_nacimiento_conyuge = $fecha_nacimiento_conyuge;
    $brujulaDatosBasicos->renta_jubilacion_conyuge = $select_jubilacion_conyuge_value;
    $brujulaDatosBasicos->ano_renta_jubilacion_conyuge = $ano_jubilacion_conyuge;
    $brujulaDatosBasicos->porcentaje_renta_jubilacion_conyuge = $porcentaje_renta_conyuge;
    $brujulaDatosBasicos->estado = 1;
    $brujulaDatosBasicos->save();
} else {
    $brujulaDatosBasicos = BrujulaDatosBasicos::where([
        ['id', $id_datos_basicos],
        ['id_user', auth()->id()],
    ])->first();

    $brujulaDatosBasicos->renta_jubilacion = $select_jubilacion_value;
    $brujulaDatosBasicos->ano_renta_jubilacion = $ano_jubilacion;
    $brujulaDatosBasicos->porcentaje_renta_jubilacion = $porcentaje_renta;
    $brujulaDatosBasicos->expectativa_vida = $expectativa_vida;
    $brujulaDatosBasicos->tiene_conyuge = $select_conyuge_value;
    $brujulaDatosBasicos->fecha_nacimiento_conyuge = $fecha_nacimiento_conyuge;
    $brujulaDatosBasicos->renta_jubilacion_conyuge = $select_jubilacion_conyuge_value;
    $brujulaDatosBasicos->ano_renta_jubilacion_conyuge = $ano_jubilacion_conyuge;
    $brujulaDatosBasicos->porcentaje_renta_jubilacion_conyuge = $porcentaje_renta_conyuge;
    $brujulaDatosBasicos->update();
}
