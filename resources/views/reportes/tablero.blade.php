@extends('layouts.app', ['activePage' => 'categorias', 'titlePage' => __('Categorias')])
@section('content')
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="card card-nav-tabs card-plain">
                    <div class="card-header card-header-primary">
                        <!-- colors: "header-primary", "header-info", "header-success", "header-warning", "header-danger" -->
                        <div class="nav-tabs-navigation">
                            <div class="nav-tabs-wrapper">
                                <ul class="nav nav-tabs" data-tabs="tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#home" data-toggle="tab">Categorias Ingreso</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#updates" data-toggle="tab">Categorias Egreso</a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body ">
                        <div class="tab-content text-center">
                            <div class="tab-pane active" id="home">
                                <div class="row">
                                    @foreach ($vistaCategoriaIngresos as $vistaCategoriaIngreso)
                                        @if ($vistaCategoriaIngreso->plantilla == 1)
                                            <div class="col-md-3">
                                                <div class="card text-white {{ $vistaCategoriaIngreso->fondo }} mb-3 text-center"
                                                    style="max-width: 18rem;">
                                                    <div class="card-header"><i
                                                            class="{{ $vistaCategoriaIngreso->icono }}"></i></div>
                                                    <div class="card-body">
                                                        <h5 class="card-title">
                                                            <a
                                                                href="{{ route('reportes.subcategoria', [
                                                                    'ano' => $ano_actual,
                                                                    'mes' => $mes_actual,
                                                                    'categoria' => $vistaCategoriaIngreso->id,
                                                                ]) }}">{{ $vistaCategoriaIngreso->categoria }}</a>
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            @if ($vistaCategoriaIngreso->id_user == auth()->id())
                                                <div class="col-md-3">
                                                    <div class="card text-white {{ $vistaCategoriaIngreso->fondo }} mb-3 text-center"
                                                        style="max-width: 18rem;">
                                                        <div class="card-header"><i
                                                                class="{{ $vistaCategoriaIngreso->icono }}"></i></div>
                                                        <div class="card-body">
                                                            <h5 class="card-title">
                                                                <a
                                                                    href="{{ route('reportes.subcategoria', [
                                                                        'ano' => $ano_actual,
                                                                        'mes' => $mes_actual,
                                                                        'categoria' => $vistaCategoriaIngreso->id,
                                                                    ]) }}">{{ $vistaCategoriaIngreso->categoria }}</a>
                                                            </h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="tab-pane" id="updates">
                                <div class="row">
                                    @foreach ($vistaCategoriaEgresos as $vistaCategoriaEgreso)
                                        @if ($vistaCategoriaEgreso->plantilla == 1)
                                            <div class="col-md-3">
                                                <div class="card text-white {{ $vistaCategoriaEgreso->fondo }} mb-3 text-center"
                                                    style="max-width: 18rem;">
                                                    <div class="card-header"><i
                                                            class="{{ $vistaCategoriaEgreso->icono }}"></i></div>
                                                    <div class="card-body">
                                                        <h5 class="card-title">
                                                            <a
                                                                href="{{ route('reportes.subcategoria', [
                                                                    'ano' => $ano_actual,
                                                                    'mes' => $mes_actual,
                                                                    'categoria' => $vistaCategoriaEgreso->id,
                                                                ]) }}">{{ $vistaCategoriaEgreso->categoria }}</a>
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            @if ($vistaCategoriaEgreso->id_user == auth()->id())
                                                <div class="col-md-3">
                                                    <div class="card text-white {{ $vistaCategoriaEgreso->fondo }} mb-3 text-center"
                                                        style="max-width: 18rem;">
                                                        <div class="card-header"><i
                                                                class="{{ $vistaCategoriaEgreso->icono }}"></i></div>
                                                        <div class="card-body">
                                                            <h5 class="card-title">
                                                                <a
                                                                    href="{{ route('reportes.subcategoria', [
                                                                        'ano' => $ano_actual,
                                                                        'mes' => $mes_actual,
                                                                        'categoria' => $vistaCategoriaEgreso->id,
                                                                    ]) }}">{{ $vistaCategoriaEgreso->categoria }}</a>
                                                            </h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">


            </div>
        </div>
    </div>
@endsection
