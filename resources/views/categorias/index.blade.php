@extends('layouts.app', ['activePage' => 'categorias', 'titlePage' => __('Categorias')])

@section('content')
    <div class="content">

        <div class="row">
            <a class="btn btn-primary" href="{{ route('categorias.create') }}" role="button">
                + Nueva Categoria
            </a>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3 text-center" style="max-width: 18rem;">
                    <div class="card-header"><i class="fa fa-cutlery fa-2x"></i></div>
                    <div class="card-body">
                        <h5 class="card-title"><a href="{{ route('presupuestosprogramados.create') }}">Comida</a></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-secondary mb-3 text-center" style="max-width: 18rem;">
                    <div class="card-header"><i class="fa fa-home fa-2x"></i></div>
                    <div class="card-body">
                        <h5 class="card-title"><a href="{{ route('presupuestosejecutados.create', 12) }}">Vivienda</a>
                        </h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success mb-3 text-center" style="max-width: 18rem;">
                    <div class="card-header"><i class="fa fa-car fa-2x"></i></div>
                    <div class="card-body">
                        <h5 class="card-title"><a href="">Transporte</a></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-danger mb-3 text-center" style="max-width: 18rem;">
                    <div class="card-header"><i class="fa fa-hand-peace-o fa-2x"></i></div>
                    <div class="card-body">
                        <h5 class="card-title"><a href="">Ropa</a></h5>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="card text-white bg-warning mb-3 text-center" style="max-width: 18rem;">
                    <div class="card-header"><i class="fa fa-paw fa-2x"></i></div>
                    <div class="card-body">
                        <h5 class="card-title"><a href="">Mascotas</a></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-info mb-3 text-center" style="max-width: 18rem;">
                    <div class="card-header"><i class="fa fa-heartbeat fa-2x"></i></div>
                    <div class="card-body">
                        <h5 class="card-title"><a href="">Salud</a></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3 text-center" style="max-width: 18rem;">
                    <div class="card-header"><i class="fa fa-university fa-2x"></i></div>
                    <div class="card-body">
                        <h5 class="card-title"><a href="">Impuestos</a></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-secondary mb-3 text-center" style="max-width: 18rem;">
                    <div class="card-header"><i class="fa fa-bolt fa-2x"></i></div>
                    <div class="card-body">
                        <h5 class="card-title"><a href="{{ route('presupuestosporcategorias.create') }}">Servicios</a>
                        </h5>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
