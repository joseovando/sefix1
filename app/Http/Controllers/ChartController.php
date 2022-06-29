<?php

namespace App\Http\Controllers;

use App\Models\Envio;
use App\Models\EnviosGroupBar;
use App\Models\EnviosPie;
use App\Models\GastoCategoria;

use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function ejemplo()
    {
        $envios = Envio::all();
        $data = [];
        foreach ($envios as $envio) {
            $data['label'][] = $envio->mes;
            $data['data'][] = $envio->cantidad;
        }
        $data['data'] = json_encode($data);
        return view('charts.ejemplo', $data);
    }

    public function gasto_categoria()
    {
        $gastoCategorias = GastoCategoria::all();
        $data = [];
        foreach ($gastoCategorias as $gastoCategoria) {
            $data['label'][] = $gastoCategoria->categoria;
            $data['data'][] = $gastoCategoria->gasto;
        }
        $data['data'] = json_encode($data);
        return view('charts.categoria_gasto', $data);
    }

    public function ejemplo_pie()
    {
        $enviosPies = EnviosPie::all();
        $data = [];
        foreach ($enviosPies as $envioPie) {
            $data['label'][] = $envioPie->categoria;
            $data['data'][] = $envioPie->porcentaje;
        }
        $data['data'] = json_encode($data);
        return view('charts.ejemplo_pie', $data);
    }

    public function ejemplo_group_bar()
    {
        $enviosGroupBars = EnviosGroupBar::all();
        $data = [];
        foreach ($enviosGroupBars as $enviosGroupBar) {
            $data['label'][] = $enviosGroupBar->mes;
            $data['programado'][] = $enviosGroupBar->programado;
            $data['ejecutado'][] = $enviosGroupBar->ejecutado;
        }
        $data['data'] = json_encode($data);
        return view('charts.ejemplo_group_bar', $data);
    }
}
