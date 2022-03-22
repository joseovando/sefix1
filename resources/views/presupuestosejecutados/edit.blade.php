@extends('layouts.app', ['activePage' => 'presupuestosprogramados', 'titlePage' => __( $titulo )])

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="{{ route('presupuestosejecutados.update') }}" autocomplete="off"
                        class="form-horizontal">

                        @csrf
                        @method('put')

                        <div class="card ">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">{{ __($titulo) }}</h4>
                                <p class="card-category">{{ __('') }}</p>
                            </div>
                            <div class="card-body ">
                                @if (session('status'))
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="alert alert-success">
                                                <button type="button" class="close" data-dismiss="alert"
                                                    aria-label="Close">
                                                    <i class="material-icons">close</i>
                                                </button>
                                                <span>{{ session('status') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-sm">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Categoria</label>
                                            <select class="form-control" id="_categoria" name="categoria">
                                                @foreach ($vistaCategoriaPadres as $vistaCategoriaPadre)
                                                    <option value="{{ $vistaCategoriaPadre->id }}"
                                                        @if ($id_categoria_padre == $vistaCategoriaPadre->id) selected @endif>
                                                        {{ $vistaCategoriaPadre->categoria }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" value="{{ $menu }}" name="menu">
                                            <input type="hidden" value="{{ $egreso->id }}" name="id">

                                        </div>
                                    </div>

                                    <div class="col-sm">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">SubCategoria</label>
                                            <select class="form-control" id="_subcategoria" name="subcategoria">
                                                <option>Seleccione Subcategoria</option>
                                                @foreach ($vistaCategorias as $vistaCategoria)
                                                    <option value="{{ $vistaCategoria->id }}"
                                                        @if ($egreso->id_categoria == $vistaCategoria->id) selected @endif>
                                                        {{ $vistaCategoria->categoria }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm">
                                        <label for="exampleFormControlSelect1">{{ __('Monto Programado') }}</label>
                                        <div class="col-sm-7">
                                            <div
                                                class="form-group{{ $errors->has('monto_programado') ? ' has-danger' : '' }}">
                                                <input
                                                    class="form-control{{ $errors->has('monto_programado') ? ' is-invalid' : '' }}"
                                                    name="monto_programado" id="monto_programado" type="text"
                                                    placeholder="{{ __('Monto Programado') }}"
                                                    value="{{ old('monto_programado', $egreso->monto_programado) }}"
                                                    required />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm">
                                        <label for="exampleFormControlSelect1">{{ __('Monto Ejecutado') }}</label>
                                        <div class="col-sm-7">
                                            <div
                                                class="form-group{{ $errors->has('monto_ejecutado') ? ' has-danger' : '' }}">
                                                <input
                                                    class="form-control{{ $errors->has('monto_ejecutado') ? ' is-invalid' : '' }}"
                                                    name="monto_ejecutado" id="monto_ejecutado" type="text"
                                                    placeholder="{{ __('Monto Ejecutado') }}"
                                                    value="{{ old('monto_ejecutado', $egreso->monto_ejecutado) }}"
                                                    required />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Frecuencia</label>
                                            <select class="form-control" id="_frecuencia" name="frecuencia">
                                                <option>Seleccione Frecuencia</option>
                                                @foreach ($frecuencias as $frecuencia)
                                                    <option value="{{ $frecuencia->id }}"
                                                        @if ($egresoSetting->id_frecuencia == $frecuencia->id) selected @endif>
                                                        {{ $frecuencia->frecuencia }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm">
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1"
                                                    name="sin_caducidad"
                                                    @if ($egresoSetting->sin_caducidad == 1) value="1" checked>
                                                @else
                                                value="1"> @endif
                                                    Sin Caducidad <span class="form-check-sign">
                                                <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Desde Fecha</label>
                                            <input id="inicio" width="276" name="inicio" value="{{ $egreso->fecha }}" />
                                            <script>
                                                $('#inicio').datepicker({
                                                    showOtherMonths: true,
                                                    format: 'yyyy-mm-dd'
                                                });
                                            </script>
                                        </div>
                                    </div>

                                    <div class="col-sm">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Hasta Fecha</label>
                                            <input id="fin" width="276" name="fin"
                                                value="{{ $egresoSetting->fecha_fin }}" />
                                            <script>
                                                $('#fin').datepicker({
                                                    showOtherMonths: true,
                                                    format: 'yyyy-mm-dd'
                                                });
                                            </script>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="card-footer ml-auto mr-auto">
                                <button type="submit" class="btn btn-primary">{{ __('Actualizar') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/select-categoria.js') }}"></script>
@endsection
