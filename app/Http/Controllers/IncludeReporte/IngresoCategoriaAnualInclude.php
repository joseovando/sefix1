<?php

$tipo = 1;
$ingreso_categoria_anual_corriente = array();
$ingreso_programado_categoria_anual_corriente = array();
$ingreso_categoria_anual_tasa_fija = array();
$ingreso_programado_categoria_anual_tasa_fija = array();
$ingreso_categoria_anual_retorno = array();
$ingreso_programado_categoria_anual_retorno = array();
$categoria_corriente = 19; // Ingresos Corrientes
$categoria_tasa_fija = 24; // Inversiones Tasa Fija Retorno
$categoria_retorno = 35; // Inversiones Retorno Fluctuante

list(
    $ingreso_categoria_anual_corriente,
    $ingreso_programado_categoria_anual_corriente
) = total_categoria_anual($fecha_actual, $categoria_corriente, $tipo, $comercial);

$data_ingreso_categoria_anual_corriente = json_encode($ingreso_categoria_anual_corriente);
$data_ingreso_programado_categoria_anual_corriente = json_encode($ingreso_programado_categoria_anual_corriente);

list(
    $ingreso_categoria_anual_tasa_fija,
    $ingreso_programado_categoria_anual_tasa_fija
) = total_categoria_anual($fecha_actual, $categoria_tasa_fija, $tipo, $comercial);

$data_ingreso_categoria_anual_tasa_fija = json_encode($ingreso_categoria_anual_tasa_fija);
$data_ingreso_programado_categoria_anual_tasa_fija = json_encode($ingreso_programado_categoria_anual_tasa_fija);

list(
    $ingreso_categoria_anual_retorno,
    $ingreso_programado_categoria_anual_retorno
) = total_categoria_anual($fecha_actual, $categoria_retorno, $tipo, $comercial);

$data_ingreso_categoria_anual_retorno = json_encode($ingreso_categoria_anual_retorno);
$data_ingreso_programado_categoria_anual_retorno = json_encode($ingreso_programado_categoria_anual_retorno);
