<?php

$tipo = 2;

list($egreso_categoria_label, $egreso_categoria_data) = total_egreso_categoria_mes($fecha_actual, $tipo, $comercial);

$data_egreso_categoria_label = json_encode($egreso_categoria_label);
$data_egreso_categoria_data = json_encode($egreso_categoria_data);
