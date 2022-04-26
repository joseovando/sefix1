<?php

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
