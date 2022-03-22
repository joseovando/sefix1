@extends('layouts.app', ['activePage' => 'presupuestosprogramados', 'titlePage' => __( $titulo )])

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="{{ route('presupuestosprogramados.store') }}" autocomplete="off"
                        class="form-horizontal">

                        @csrf

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
                                                        @if ($id_categoria == $vistaCategoriaPadre->id) selected @endif>
                                                        {{ $vistaCategoriaPadre->categoria }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" value="{{ $menu }}" name="menu">
                                        </div>
                                    </div>

                                    <div class="col-sm">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">SubCategoria</label>
                                            <select class="form-control" id="_subcategoria" name="subcategoria">
                                                <option>Seleccione Subcategoria</option>
                                                @foreach ($vistaCategorias as $vistaCategoria)
                                                    <option value="{{ $vistaCategoria->id }}">
                                                        {{ $vistaCategoria->categoria }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Monto') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('monto') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('monto') ? ' is-invalid' : '' }}"
                                                name="monto" id="input-monto" type="text" placeholder="{{ __('monto') }}"
                                                value="{{ old('monto', auth()->user()->monto) }}" required />
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
                                                    <option value="{{ $frecuencia->id }}">
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
                                                    value="1" name="sin_caducidad"> Sin Caducidad
                                                <span class="form-check-sign">
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
                                            <input id="inicio" width="276" name="inicio" />
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
                                            <input id="fin" width="276" name="fin" />
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
                                <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/select-categoria.js') }}"></script>
@endsection
