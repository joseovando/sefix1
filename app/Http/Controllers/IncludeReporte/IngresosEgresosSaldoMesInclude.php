<?php

list(
    $data_ingresos_egresos_mes_labels,
    $data_ingresos_egresos_mes_values,
    $total_ingreso_bar,
    $total_ingreso_programado_bar,
    $total_egreso_bar,
    $total_egreso_programado_bar,
    $saldo_ejecutado_bar,
    $saldo_programado_bar
) = total_ingresos_egresos_saldo_mes($fecha_actual, $comercial);

$diferencia_ingreso_bar = $total_ingreso_bar - $total_ingreso_programado_bar;
$diferencia_egreso_bar = $total_egreso_bar - $total_egreso_programado_bar;

if ($total_ingreso_programado_bar != 0) {
    $porcentaje_ingreso_bar = ($total_ingreso_bar / $total_ingreso_programado_bar) * 100;
} else {
    $porcentaje_ingreso_bar = 0;
}

if ($total_egreso_programado_bar != 0) {
    $porcentaje_egreso_bar = ($total_egreso_bar / $total_egreso_programado_bar) * 100;
} else {
    $porcentaje_egreso_bar = 0;
}
