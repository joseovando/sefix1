<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Categoria;
use App\Models\CategoriaFavorita;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id, $comercial, $search_result)
    {
        switch ($id) {
            case 1:
                $tipo = 1;
                break;
            case 2:
                $tipo = 1;
                break;
            case 3:
                $tipo = 2;
                break;
            case 4:
                $tipo = 2;
                break;
        }

        $menu = $id;
        $fecha_actual = date("Y-m-d");
        $fecha_actual2 = strtotime($fecha_actual);
        $ano_actual = date("Y", $fecha_actual2);
        $mes_actual = date("m", $fecha_actual2);

        $vistaCategoriaPadres = DB::table('vista_categoria_padres')
            ->where('tipo', '=', $tipo)
            ->where('estado', '=', 1)
            ->where('comercial', '=', $comercial)
            ->orderBy('categoria', 'ASC')
            ->get();

        $vistaCategoriaFavoritas = DB::table('vista_categoria_favoritas')
            ->where('tipo', '=', $tipo)
            ->where('estado', '=', 1)
            ->where('comercial', '=', $comercial)
            ->where('id_user', '=', auth()->id())
            ->orderBy('orden', 'ASC')
            ->get();

        $categoriaTipos = DB::table('categoria_tipo')
            ->where('estado', '=', 1)
            ->orderBy('orden', 'ASC')
            ->get();

        $categoriaLogos = DB::table('categoria_logo')
            ->where('estado', '=', 1)
            ->orderBy('label', 'ASC')
            ->get();

        include('IncludeCategoria/CategoriasFavoritasPlatillaInclude.php');
        include('IncludeCategoria/BuscadorCategoriasInclude.php');
        include('IncludeCategoria/ArrayCategoriasFavoritasInclude.php');

        return view('categorias.index', compact(
            'vistaCategoriaFavoritas',
            'arrayIdCategoria',
            'arrayCategoria',
            'arrayCheckCategoria',
            'categoriaTipos',
            'categoriaLogos',
            'json',
            'menu',
            'tipo',
            'ano_actual',
            'mes_actual',
            'fecha_actual',
            'estado',
            'comercial',
            'search_result'
        ));
    }

    public function search(Request $request)
    {
        $menu = request('menu');
        $ano_actual = request('ano_actual');
        $mes_actual = request('mes_actual');
        $estado = request('estado');
        $fecha_actual = request('fecha_actual');
        $comercial = request('comercial');
        $search =  request('search');
        $entrada = explode(' | ', $search);

        include('IncludeCategoria/SearchVerificadorInputInclude.php');

        if (!isset($vistaCategoria)) {
            $search_result = 1;

            return redirect()->route('categorias.index', [
                'id' => $menu,
                'comercial' => $comercial,
                'search_result' => $search_result,
            ]);
        } else {
            switch ($menu) {
                case 1:
                    return redirect()->route('presupuestosprogramados.create', [
                        'id' => $vistaCategoria->id_padre,
                        'menu' => $menu,
                        'ano' => $ano_actual,
                        'mes' => $mes_actual,
                        'estado' => $estado,
                    ]);
                    break;
                case 2:
                    return redirect()->route('presupuestosejecutados.create', [
                        'id' => $vistaCategoria->id_padre,
                        'menu' => $menu,
                        'date' => $fecha_actual,
                        'estado' => $estado,
                    ]);
                    break;
                case 3:
                    return redirect()->route('presupuestosprogramados.create', [
                        'id' => $vistaCategoria->id_padre,
                        'menu' => $menu,
                        'ano' => $ano_actual,
                        'mes' => $mes_actual,
                        'estado' => $estado,
                    ]);
                    break;
                case 4:
                    return redirect()->route('presupuestosejecutados.create', [
                        'id' => $vistaCategoria->id_padre,
                        'menu' => $menu,
                        'date' => $fecha_actual,
                        'estado' => $estado,
                    ]);
                    break;
            }
        }
    }

    public function getVistaCategoriaFavorita($tipo, $comercial)
    {
        $vistaCategoriaFavoritas = DB::table('vista_categoria_favoritas')
            ->where('tipo', '=', $tipo)
            ->where('estado', '=', 1)
            ->where('comercial', '=', $comercial)
            ->where('id_user', '=', auth()->id())
            ->orderBy('orden', 'ASC')
            ->get();

        return response()->json([
            'vistaCategoriaFavoritas' => $vistaCategoriaFavoritas,
        ], 200);
    }

    public function tablero($comercial)
    {
        $vistaCategorias = DB::table('vista_categorias')
            ->where('estado', '=', 1)
            ->where('comercial', '=', $comercial)
            ->where('id_user', '=', auth()->id())
            ->orderBy('tipo_orden', 'ASC')
            ->orderBy('orden_padre', 'ASC')
            ->orderBy('orden', 'ASC')
            ->get();

        return view('categorias.tablero', compact(
            'vistaCategorias',
            'comercial'
        ));
    }

    public function tablero_categoria($comercial)
    {
        $vistaCategoriaPadres = DB::table('vista_categoria_padres')
            ->where('estado', '=', 1)
            ->where('comercial', '=', $comercial)
            ->where('id_user', '=', auth()->id())
            ->orderBy('orden_tipo', 'ASC')
            ->orderBy('orden', 'ASC')
            ->get();

        return view('categorias.tablero_categoria', compact(
            'vistaCategoriaPadres',
            'comercial'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($comercial)
    {
        $vistaCategoriaIngresos = DB::table('vista_categoria_padres')
            ->where('estado', '=', 1)
            ->where('tipo', '=', 1)
            ->where('comercial', '=', $comercial)
            ->orderBy('orden', 'ASC')
            ->get();

        $vistaCategoriaEgresos = DB::table('vista_categoria_padres')
            ->where('estado', '=', 1)
            ->where('tipo', '=', 2)
            ->where('comercial', '=', $comercial)
            ->orderBy('orden', 'ASC')
            ->get();

        return view('categorias.create', compact(
            'vistaCategoriaIngresos',
            'vistaCategoriaEgresos',
            'comercial'
        ));
    }

    public function create_categoria($comercial)
    {
        $categoriaTipos = DB::table('categoria_tipo')
            ->where('estado', '=', 1)
            ->orderBy('orden', 'ASC')
            ->get();

        $categoriaLogos = DB::table('categoria_logo')
            ->where('estado', '=', 1)
            ->orderBy('label', 'ASC')
            ->get();

        return view('categorias.create_categoria', compact(
            'categoriaTipos',
            'categoriaLogos',
            'comercial'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vistaUserRol = DB::table('vista_user_rol')
            ->where('user_id', '=', auth()->id())
            ->first();

        if ($vistaUserRol->rol_name == "administrator") {
            $plantilla = 1;
        } else {
            $plantilla = 0;
        }

        $vistaCategoriaPadres = DB::table('vista_categorias')
            ->where('id_padre', '=', request('categoria'))
            ->orderBy('orden', 'DESC')
            ->first();

        $orden = $vistaCategoriaPadres->orden;
        $orden = $orden + 1;

        $categoria = new Categoria();
        $categoria->categoria = request('subcategoria');
        $categoria->id_padre =  request('categoria');
        $categoria->orden =  $orden;
        $categoria->icono =  $vistaCategoriaPadres->icono;
        $categoria->fondo =  $vistaCategoriaPadres->fondo;
        $categoria->plantilla =  $plantilla;
        $categoria->estado = 1;
        $categoria->id_user = auth()->id();
        $categoria->tipo = $vistaCategoriaPadres->tipo;
        $categoria->save();

        return redirect()->route('categorias.tablero', request('comercial'));
    }

    public function store_categoria(Request $request)
    {
        include('IncludeCategoria/StoreCategoriaInclude.php');
        return redirect()->route('categorias.tablero_categoria', request('comercial'));
    }

    public function store_ajax_categoria(Request $request)
    {
        include('IncludeCategoria/StoreCategoriaInclude.php');

        $favorita = new CategoriaFavorita();
        $favorita->id_categoria = $categoria->id;
        $favorita->orden =  0;
        $favorita->plantilla =  0;
        $favorita->estado = 1;
        $favorita->id_user = auth()->id();
        $favorita->save();

        return response()->json(['success' => 'Registro Guardado Correctamente.']);
    }

    public function store_favorita(Request $request)
    {
        $arrayIdCategoria = request('arrayIdCategoria');
        $arrayCheck = request('arrayCheck');
        $sortable = request('sortable');
        $entrada = explode('|', $sortable);
        $orden = 0;

        include('IncludeCategoria/StoreFavoritaCrudInclude.php');

        return response()->json(['success' => 'Sortable Guardado Correctamente, Información Actualizada']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vistaCategoria = DB::table('vista_categorias')
            ->where('id', '=', $id)
            ->where('id_user', '=', auth()->id())
            ->first();

        $vistaCategoriaIngresos = DB::table('vista_categoria_padres')
            ->where('estado', '=', 1)
            ->where('tipo', '=', 1)
            ->orderBy('orden', 'ASC')
            ->get();

        $vistaCategoriaEgresos = DB::table('vista_categoria_padres')
            ->where('estado', '=', 1)
            ->where('tipo', '=', 2)

            ->orderBy('orden', 'ASC')
            ->get();

        return view('categorias.edit', compact(
            'vistaCategoriaIngresos',
            'vistaCategoriaEgresos',
            'vistaCategoria'
        ));
    }

    public function edit_categoria($id)
    {
        $vistaCategoriaPadre = DB::table('vista_categoria_padres')
            ->where('id', '=', $id)
            ->where('id_user', '=', auth()->id())
            ->where('estado', '=', 1)
            ->first();

        $categoriaTipos = DB::table('categoria_tipo')
            ->where('estado', '=', 1)
            ->orderBy('orden', 'ASC')
            ->get();

        $categoriaLogos = DB::table('categoria_logo')
            ->where('estado', '=', 1)
            ->orderBy('label', 'ASC')
            ->get();

        return view('categorias.edit_categoria', compact(
            'vistaCategoriaPadre',
            'categoriaTipos',
            'categoriaLogos'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $vistaUserRol = DB::table('vista_user_rol')
            ->where('user_id', '=', auth()->id())
            ->first();

        if ($vistaUserRol->rol_name == "Adminsitrador") {
            $plantilla = 1;
        } else {
            $plantilla = 0;
        }

        $vistaCategoriaPadres = DB::table('vista_categoria_padres')
            ->where('id', '=', request('categoria'))
            ->orderBy('orden', 'DESC')
            ->first();

        $orden = $vistaCategoriaPadres->orden;
        $orden = $orden + 1;

        $categoria = Categoria::where([
            ['id', request('id_subcategoria')],
            ['id_user', auth()->id()],
        ])->first();

        $categoria->categoria = request('subcategoria');
        $categoria->id_padre =  request('categoria');
        $categoria->orden =  $orden;
        $categoria->icono =  $vistaCategoriaPadres->icono;
        $categoria->fondo =  $vistaCategoriaPadres->fondo;
        $categoria->plantilla =  $plantilla;
        $categoria->tipo = $vistaCategoriaPadres->tipo;
        $categoria->update();

        return redirect()->route('categorias.tablero');
    }

    public function update_categoria(Request $request)
    {
        $vistaUserRol = DB::table('vista_user_rol')
            ->where('user_id', '=', auth()->id())
            ->first();

        if ($vistaUserRol->rol_name == "Adminsitrador") {
            $plantilla = 1;
        } else {
            $plantilla = 0;
        }

        $vistaCategoriaPadres = DB::table('vista_categoria_padres')
            ->where('orden_tipo', '=', request('tipo_categoria'))
            ->orderBy('orden', 'DESC')
            ->first();

        $orden = $vistaCategoriaPadres->orden;
        $orden = $orden + 1;

        $categoria = Categoria::where([
            ['id', request('id_categoria')],
            ['id_user', auth()->id()],
        ])->first();

        $categoria->categoria = request('categoria');
        $categoria->id_padre =  0;
        $categoria->orden =  $orden;
        $categoria->icono =  request('logo_categoria');
        $categoria->fondo =  request('fondo_categoria');
        $categoria->plantilla =  $plantilla;
        $categoria->tipo =  request('tipo_categoria');
        $categoria->update();

        return redirect()->route('categorias.tablero_categoria');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function delete($id)
    {
        $categoria = Categoria::where([
            ['id', $id],
            ['id_user', auth()->id()],
        ])->first();

        $categoria->estado = 0;
        $categoria->update();

        return redirect()->route('categorias.tablero');
    }

    public function delete_categoria($id)
    {
        $categoria = Categoria::where([
            ['id', $id],
            ['id_user', auth()->id()],
        ])->first();

        $categoria->estado = 0;
        $categoria->update();

        return redirect()->route('categorias.tablero_categoria');
    }
}
