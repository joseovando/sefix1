@extends('layouts.app', ['activePage' => 'presupuestosejecutados', 'titlePage' => __($titulo)])

<link rel="stylesheet" href="{{ asset('css/autoComplete.min.css') }}">
{{-- <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script> --}}
<link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet">
<script src="{{ asset('js/jquery-3.6.0.js') }}"></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>
@include('brujula.datepicker_regional_es')
{{-- <script src="{{ asset('js/gijgo.min.js') }}" type="text/javascript"></script>
<link href="{{ asset('css/gijgo.min.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('js/messages.es-es.js') }}" type="text/javascript"></script> --}}
<link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.dataTables.min.css') }}">
<script type="text/javascript" language="javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('css/presupuestosprogramados.create.css') }}">
<script src="{{ asset('js/moment.min.js') }}"></script>

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
                            @include('presupuestosprogramados.buscador_categoria')
                            @include('presupuestosprogramados.cambiar_fecha')
                            @include('presupuestosprogramados.programar_presupuesto')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    @include('presupuestosprogramados.scripts')
@endpush
