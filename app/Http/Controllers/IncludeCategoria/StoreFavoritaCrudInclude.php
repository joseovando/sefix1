<?php

use App\Models\CategoriaFavorita;

if (strlen($sortable) == 1) {
    for ($i = 0; $i < sizeof($arrayIdCategoria); $i++) {
        $vistaCategoriaFavoritas = DB::table('categoria_favorita')
            ->where('id_categoria', '=', $arrayIdCategoria[$i])
            ->where('estado', '=', 1)
            ->where('id_user', '=', auth()->id())
            ->orderBy('orden', 'ASC')
            ->get();

        $contador = 0;

        foreach ($vistaCategoriaFavoritas as $vistaCategoriaFavorita) {
            $contador++;
            $id_favorita = $vistaCategoriaFavorita->id;
        }

        if ($contador == 0) {

            if ($arrayCheck[$i] == "true") {
                $favorita = new CategoriaFavorita();
                $favorita->id_categoria = $arrayIdCategoria[$i];
                $favorita->orden =  0;
                $favorita->plantilla =  0;
                $favorita->estado = 1;
                $favorita->id_user = auth()->id();
                $favorita->save();
            }
        } else {

            if ($arrayCheck[$i] == "true") {
            } else {
                DB::table('categoria_favorita')->delete($id_favorita);
            }
        }
    }
} else {
    for ($i = 1; $i < sizeof($entrada); $i = $i + 2) {
        $orden++;
        $id_categoria = $entrada[$i] + 0;

        if ($id_categoria > 0) {

            $vistaCategoriaFavoritas = DB::table('categoria_favorita')
                ->where('id_categoria', '=', $id_categoria)
                ->where('estado', '=', 1)
                ->where('id_user', '=', auth()->id())
                ->orderBy('orden', 'ASC')
                ->get();

            $contador = 0;

            foreach ($vistaCategoriaFavoritas as $vistaCategoriaFavorita) {
                $contador++;
                $id_favorita = $vistaCategoriaFavorita->id;
            }

            if ($contador == 0) {

                for ($j = 0; $j < sizeof($arrayIdCategoria); $j++) {
                    if ($arrayIdCategoria[$j] == $id_categoria) {
                        $check = $arrayCheck[$j];
                    }
                }

                if ($check == "true") {
                    $favorita = new CategoriaFavorita();
                    $favorita->id_categoria = $id_categoria;
                    $favorita->orden =  $orden;
                    $favorita->plantilla =  0;
                    $favorita->estado = 1;
                    $favorita->id_user = auth()->id();
                    $favorita->save();
                }
            } else {

                for ($j = 0; $j < sizeof($arrayIdCategoria); $j++) {
                    if ($arrayIdCategoria[$j] == $id_categoria) {
                        $check = $arrayCheck[$j];
                    }
                }

                if ($check == "true") {
                    $favorita = CategoriaFavorita::where([
                        ['id', $id_favorita],
                        ['id_user', auth()->id()],
                    ])->first();
                    $favorita->orden = $orden;
                    $favorita->update();
                } else {
                    DB::table('categoria_favorita')->delete($id_favorita);
                }
            }
        }
    }
}
