@extends('layouts.app', ['activePage' => 'brujula', 'titlePage' => __('Brujula Financiera')])

<link rel="stylesheet" href="{{ asset('css/autoComplete.min.css') }}">
{{-- <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script> --}}
<link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
@include('brujula.datepicker_regional_es')
{{-- <script src="{{ asset('js/gijgo.min.js') }}" type="text/javascript"></script>
<link href="{{ asset('css/gijgo.min.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('js/messages.es-es.js') }}" type="text/javascript"></script> --}}
<link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.dataTables.min.css') }}">
<script type="text/javascript" language="javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('css/presupuestosprogramados.create.css') }}">
<script src="{{ asset('js/moment.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/bootstrap-select.min.css') }}">

@section('content')
    <div class="content">
        <div class="card card-nav-tabs card-plain">
            <div class="card-header card-header-primary">
                <!-- colors: "header-primary", "header-info", "header-success", "header-warning", "header-danger" -->
                <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                        <ul class="nav nav-tabs" data-tabs="tabs">
                            <li class="nav-item">
                                <a class="nav-link active" href="#datos_basicos" data-toggle="tab">
                                    <i class="fa fa-users" aria-hidden="true"></i>&nbsp;&nbsp;Datos Básicos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#ingresos_corrientes" data-toggle="tab">
                                    <i class="fa fa-object-group" aria-hidden="true"></i>&nbsp;&nbsp;Ingresos
                                    Corrientes&nbsp;

                                    <span id="span_ingresos_corrientes"
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                                        {{ $contador_ingresos_corrientes }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#ingresos_inversiones" data-toggle="tab">
                                    <i class="fa fa-object-group" aria-hidden="true"></i>&nbsp;&nbsp;Ingresos
                                    Inversiones&nbsp;

                                    <span id="span_ingresos_inversiones"
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                                        {{ $contador_ingresos_inversiones }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#egresos_corrientes" data-toggle="tab">
                                    <i class="fa fa-object-ungroup" aria-hidden="true"></i>&nbsp;&nbsp;Egresos
                                    Corrientes&nbsp;

                                    <span id="span_egresos_corrientes"
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                                        {{ $contador_egresos_corrientes }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#prestamos" data-toggle="tab">
                                    <i class="fa fa-building" aria-hidden="true"></i>&nbsp;&nbsp;Préstamos&nbsp;

                                    <span id="span_prestamos"
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                                        {{ $contador_prestamos }}

                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#coeficientes" data-toggle="tab">
                                    <i class="fa fa-cogs" aria-hidden="true"></i>&nbsp;&nbsp;Coeficientes</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body ">
                <div class="tab-content">
                    <div class="tab-pane active" id="datos_basicos">
                        <div class="row">
                            @include('brujula.datos_basicos')
                        </div>
                    </div>
                    <div class="tab-pane" id="ingresos_corrientes">
                        <div class="row">
                            @include('brujula.ingresos_corrientes')
                            @include('brujula.ingresos_corrientes_modal')
                        </div>
                    </div>
                    <div class="tab-pane" id="ingresos_inversiones">
                        {{-- <p>Ingresos Inversiones</p>
                        <input type="text" id="datepicker" class="form-control" style="font-family: FontAwesome"
                            placeholder="&#xf073;">
                        <script>
                            $.datepicker.setDefaults($.datepicker.regional['es']);
                            $("#datepicker").datepicker({
                                changeMonth: true,
                                changeYear: true,
                            });
                        </script> --}}
                        @include('brujula.ingresos_inversiones')
                        @include('brujula.ingresos_inversiones_modal')
                    </div>
                    <div class="tab-pane" id="egresos_corrientes">
                        @include('brujula.egresos_corrientes')
                        @include('brujula.egresos_corrientes_modal')
                    </div>
                    <div class="tab-pane" id="prestamos">
                        @include('brujula.prestamos')
                        @include('brujula.prestamos_modal')
                    </div>
                    <div class="tab-pane" id="coeficientes">
                        @include('brujula.coeficientes')
                        @include('brujula.coeficientes_modal')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    @include('brujula.scripts')
@endpush
