<?php

if ($ano == 1 and $mes == 1) {
    $ano = date("Y");
    $mes = date("m");
}

if (request('llave_form') == 1) {
    $ano_actual = request('ano_actual');
    $ano_actual_inicio = $ano_actual - 20;
    $ano_actual_fin = $ano_actual + 20;
    $mes_actual = request('mes_actual');
    $fecha_actual = $ano_actual . "-" . $mes_actual . "-01";
    $meses = meses();
} else {
    $ano_actual = $ano;
    $ano_actual_inicio = $ano_actual - 20;
    $ano_actual_fin = $ano_actual + 20;
    $mes_actual = $mes;
    $fecha_actual = $ano_actual . "-" . $mes_actual . "-01";
    $meses = meses();
}

$date_future = strtotime('-0 day', strtotime($fecha_actual));
$mes_actual_text = date("F Y", $date_future);
