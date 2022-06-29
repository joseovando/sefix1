@extends('layouts.app', ['activePage' => 'presupuestosejecutados', 'titlePage' => __($titulo)])

<link rel="stylesheet" href="{{ asset('css/autoComplete.min.css') }}">
<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('js/gijgo.min.js') }}" type="text/javascript"></script>
<link href="{{ asset('css/gijgo.min.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('js/messages.es-es.js') }}" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.dataTables.min.css') }}">
<script type="text/javascript" language="javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('css/presupuestosprogramados.create.css') }}">
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/moment.min.js') }}"></script>

<style>
    textarea,
    input {
        padding: 10px;
        font-family: FontAwesome, "Open Sans", Verdana, sans-serif;
        font-style: normal;
        font-weight: normal;
        text-decoration: inherit;
    }

</style>

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __($titulo) }}</h4>
                            <p class="card-category">{{ __('') }}</p>
                        </div>
                        <div class="card-body table-responsive">
                            @include(
                                'presupuestosejecutados.buscador_categoria'
                            )

                            <br>

                            @include('presupuestosejecutados.cambiar_fecha')
                            @include(
                                'presupuestosejecutados.ejecutar_presupuesto'
                            )
                        </div>
                    </div>
                    @include('presupuestosejecutados.reporte')
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    @include('presupuestosejecutados.scripts')
@endpush
