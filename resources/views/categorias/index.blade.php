@extends('layouts.app', ['activePage' => 'categorias', 'titlePage' => __('Categorias')])

@section('content')
    <div class="content">

        <div class="row">
            <a class="btn btn-primary" href="{{ route('categorias.create') }}" role="button">
                + Nueva Categoria
            </a>
        </div>

        <div class="row">

            @foreach ($vistaCategoriaPadres as $vistaCategoriaPadre)
                <div class="col-md-3">
                    <div class="card text-white {{ $vistaCategoriaPadre->fondo }} mb-3 text-center"
                        style="max-width: 18rem;">
                        <div class="card-header"><i class="{{ $vistaCategoriaPadre->icono }}"></i></div>
                        <div class="card-body">
                            <h5 class="card-title">

                                @switch($menu)
                                    @case(1)
                                        <a
                                            href="{{ route('presupuestosprogramados.create', ['id' => $vistaCategoriaPadre->id, 'menu' => $menu]) }}">{{ $vistaCategoriaPadre->categoria }}</a>
                                    @break

                                    @case(2)
                                        <a
                                            href="{{ route('presupuestosejecutados.create', ['id' => $vistaCategoriaPadre->id]) }}">{{ $vistaCategoriaPadre->categoria }}</a>
                                    @break

                                    @case(3)
                                        <a
                                            href="{{ route('presupuestosprogramados.create', ['id' => $vistaCategoriaPadre->id, 'menu' => $menu]) }}">{{ $vistaCategoriaPadre->categoria }}</a>
                                    @break

                                    @case(4)
                                        <a
                                            href="{{ route('presupuestosejecutados.create', ['id' => $vistaCategoriaPadre->id]) }}">{{ $vistaCategoriaPadre->categoria }}</a>
                                    @break
                                @endswitch

                            </h5>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection
