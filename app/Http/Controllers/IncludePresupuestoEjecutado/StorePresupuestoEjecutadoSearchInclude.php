<?php

use App\Models\Egreso;
use App\Models\EgresoSetting;
use App\Models\Ingreso;
use App\Models\IngresoSetting;

$date = request('date');
$input_monto = explode('.|||', request('monto_search'));
$egreso_dia_search = array();

for ($i = 0; $i < count($input_monto); $i++) {

    if (strlen($input_monto[$i]) > 10) {
        $data_monto = explode('.||', $input_monto[$i]);
        $fecha = str_replace("_", "-", $data_monto[2]);
        $monto_egreso = $data_monto[0];
        $egreso_dia_search[$i] = $monto_egreso;
        $llave_categoria = $data_monto[1];

        if ($data_monto[1] > 0) {

            if ($monto_egreso > 0) {

                if (request('tipo') == 2) {

                    $egreso_montos = DB::table('egreso')
                        ->where('id_categoria', '=', $data_monto[1])
                        ->where('estado', '=', 1)
                        ->where('id_user', '=', auth()->id())
                        ->where('fecha', '=', $fecha)
                        ->get();

                    $egresoMonto = 0;
                    $egresoId = 0;

                    foreach ($egreso_montos as $egreso_monto) {
                        $egresoMonto = $egreso_monto->monto_ejecutado + 0;
                        $egresoId = $egreso_monto->id;
                    }

                    if ($egresoMonto > 0) {
                        $egreso = Egreso::find($egresoId);
                        $egreso->detalle = $data_monto[3];
                        $egreso->monto_ejecutado = $monto_egreso;
                        $egreso->update();
                    } else {
                        $egreso = new Egreso();
                        $egreso->id_categoria = $data_monto[1];
                        $egreso->detalle = $data_monto[3];
                        $egreso->fecha = $fecha;
                        $egreso->monto_ejecutado = $monto_egreso;
                        $egreso->estado = 1;
                        $egreso->id_user = auth()->id();
                        $egreso->save();

                        $egresoSetting = new EgresoSetting();
                        $egresoSetting->id_egreso = $egreso->id;
                        $egresoSetting->id_frecuencia = 1;
                        $egresoSetting->fecha_inicio = $fecha;
                        $egresoSetting->estado = 1;
                        $egresoSetting->id_user = auth()->id();
                        $egresoSetting->save();
                    }
                } else {

                    $ingreso_montos = DB::table('ingreso')
                        ->where('id_categoria', '=', $data_monto[1])
                        ->where('fecha', '=', $fecha)
                        ->where('estado', '=', 1)
                        ->where('id_user', '=', auth()->id())
                        ->get();

                    $ingresoMonto = 0;
                    $ingresoId = 0;

                    foreach ($ingreso_montos as $ingreso_monto) {
                        $ingresoMonto = $ingreso_monto->monto_ejecutado + 0;
                        $ingresoId = $ingreso_monto->id;
                    }

                    if ($ingresoMonto > 0) {
                        $ingreso = Ingreso::find($ingresoId);
                        $ingreso->detalle = $data_monto[3];
                        $ingreso->monto_ejecutado = $monto_egreso;
                        $ingreso->update();
                    } else {
                        $ingreso = new Ingreso();
                        $ingreso->id_categoria = $data_monto[1];
                        $ingreso->detalle = $data_monto[3];
                        $ingreso->fecha = $fecha;
                        $ingreso->monto_ejecutado = $monto_egreso;
                        $ingreso->estado = 1;
                        $ingreso->id_user = auth()->id();
                        $ingreso->save();

                        $ingresoSetting = new IngresoSetting();
                        $ingresoSetting->id_ingreso = $ingreso->id;
                        $ingresoSetting->id_frecuencia = 1;
                        $ingresoSetting->fecha_inicio = $fecha;
                        $ingresoSetting->estado = 1;
                        $ingresoSetting->id_user = auth()->id();
                        $ingresoSetting->save();
                    }
                }

                list(
                    $total_ejecutado_mes,
                    $total_programado_mes,
                ) = total_subcategoria_mes($date, $data_monto[1], request('tipo'), $comercial);

                $diferencia_mes = $total_ejecutado_mes - $total_programado_mes;

                if ($total_programado_mes > 0) {
                    $porcentaje_mes = $total_ejecutado_mes - $total_programado_mes;
                } else {
                    $porcentaje_mes = 0;
                }
            }
        } else {
            $total_ejecutado_mes_search = 0;
            $total_programado_mes_search = 0;
            $diferencia_mes_search = 0;
            $porcentaje_mes_search = 0;
            $llave_categoria = 0;
        }
    }
}
