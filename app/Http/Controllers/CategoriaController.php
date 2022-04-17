<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
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
            ->orderBy('orden', 'ASC')
            ->get();

        $estado = 0;

        return view('categorias.index', compact(
            'vistaCategoriaPadres',
            'menu',
            'ano_actual',
            'mes_actual',
            'fecha_actual',
            'estado'
        ));
    }

    public function tablero()
    {
        $vistaCategorias = DB::table('vista_categorias')
            ->where('estado', '=', 1)
            ->where('id_user', '=', auth()->id())
            ->orderBy('tipo_orden', 'ASC')
            ->orderBy('orden_padre', 'ASC')
            ->orderBy('orden', 'ASC')
            ->get();

        return view('categorias.tablero', compact('vistaCategorias'));
    }

    public function tablero_categoria()
    {
        $vistaCategoriaPadres = DB::table('vista_categoria_padres')
            ->where('estado', '=', 1)
            ->where('id_user', '=', auth()->id())
            ->orderBy('orden_tipo', 'ASC')
            ->orderBy('orden', 'ASC')
            ->get();

        return view('categorias.tablero_categoria', compact('vistaCategoriaPadres'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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

        return view('categorias.create', compact(
            'vistaCategoriaIngresos',
            'vistaCategoriaEgresos'
        ));
    }

    public function create_categoria()
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
            'categoriaLogos'
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

        return redirect()->route('categorias.tablero');
    }

    public function store_categoria(Request $request)
    {
        $vistaUserRol = DB::table('vista_user_rol')
            ->where('user_id', '=', auth()->id())
            ->first();

        if ($vistaUserRol->rol_name == "administrator") {
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

        $categoria = new Categoria();
        $categoria->categoria = request('categoria');
        $categoria->id_padre =  0;
        $categoria->orden =  $orden;
        $categoria->icono =  request('logo_categoria');
        $categoria->fondo =  request('fondo_categoria');
        $categoria->plantilla =  $plantilla;
        $categoria->estado = 1;
        $categoria->id_user = auth()->id();
        $categoria->tipo =  request('tipo_categoria');
        $categoria->save();

        return redirect()->route('categorias.tablero_categoria');
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
