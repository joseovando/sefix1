@extends('layouts.app', ['activePage' => 'subcategorias', 'titlePage' => __('Editar Subcategoria')])
@section('content')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('js/defaults-es_ES.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/bootstrap-select.min.css') }}">

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="{{ route('categorias.update') }}" autocomplete="off"
                        class="form-horizontal">

                        @csrf
                        @method('put')

                        <div class="card ">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">{{ __('Editar Subcategoria') }}</h4>
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

                                            <label for="exampleFormControlSelect1">Categoria</label><br>

                                            <select class="form-control selectpicker show-tick" data-live-search="true"
                                                id="_categoria" name="categoria" required>
                                                <option value="">Seleccione Categoria</option>
                                                <optgroup label="Tipo Ingreso">
                                                    @foreach ($vistaCategoriaIngresos as $vistaCategoriaIngreso)
                                                        <option value="{{ $vistaCategoriaIngreso->id }}"
                                                            @if ($vistaCategoriaIngreso->id == $vistaCategoria->id_padre) selected @endif>
                                                            {{ $vistaCategoriaIngreso->categoria }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                                <optgroup label="Tipo Egreso">
                                                    @foreach ($vistaCategoriaEgresos as $vistaCategoriaEgreso)
                                                        <option value="{{ $vistaCategoriaEgreso->id }}"
                                                            @if ($vistaCategoriaEgreso->id == $vistaCategoria->id_padre) selected @endif>
                                                            {{ $vistaCategoriaEgreso->categoria }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                            <input type="hidden" value="{{ $vistaCategoria->id }}"
                                                name="id_subcategoria">
                                        </div>
                                    </div>

                                    <div class="col-sm">
                                        <label for="exampleFormControlSelect1">Subcategoria</label>
                                        <div class="col-sm-7">
                                            <div
                                                class="form-group{{ $errors->has('subcategoria') ? ' has-danger' : '' }}">
                                                <input
                                                    class="form-control{{ $errors->has('subcategoria') ? ' is-invalid' : '' }}"
                                                    name="subcategoria" id="subcategoria" type="text"
                                                    placeholder="{{ __('subcategoria') }}"
                                                    value="{{ $vistaCategoria->categoria }}" required />
                                                @if ($errors->has('subcategoria'))
                                                @endif
                                            </div>
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
@endsection
