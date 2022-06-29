<?php

$total_ingreso_mes = array();
$total_ingreso_programado_mes = array();
$total_egreso_mes = array();
$total_egreso_programado_mes = array();

for ($i = 0; $i < 12; $i++) {

    $fecha = strtotime($fecha_actual);
    $ano_actual = date("Y", $fecha);
    $fecha_inicial = $ano_actual . "-01-01";
    $frecuencia_texto = "+" . $i . " month";
    $date_future = strtotime($frecuencia_texto, strtotime($fecha_inicial));
    $fecha = date('Y-m-d', $date_future);

    list(
        $data_labels,
        $data_values,
        $total_ingreso_mes[$i],
        $total_ingreso_programado_mes[$i],
        $total_egreso_mes[$i],
        $total_egreso_programado_mes[$i],
        $saldo_ejecutado_mes,
        $saldo_programado_mes
    ) = total_ingresos_egresos_saldo_mes($fecha, $comercial);
}

$data_total_ingreso_mes = json_encode($total_ingreso_mes);
$data_total_ingreso_programado_mes = json_encode($total_ingreso_programado_mes);
$data_total_egreso_mes = json_encode($total_egreso_mes);
$data_total_egreso_programado_mes = json_encode($total_egreso_programado_mes);
