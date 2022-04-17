@extends('layouts.app', ['activePage' => 'subcategorias', 'titlePage' => __('Nueva Subcategoria')])
@section('content')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('js/defaults-es_ES.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/bootstrap-select.min.css') }}">

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="{{ route('categorias.store') }}" autocomplete="off"
                        class="form-horizontal">

                        @csrf

                        <div class="card ">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">{{ __('Nueva Subcategoria') }}</h4>
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
                                                        @if ($vistaCategoriaIngreso->plantilla == 1)
                                                            <option value="{{ $vistaCategoriaIngreso->id }}">
                                                                {{ $vistaCategoriaIngreso->categoria }}
                                                            </option>
                                                        @else
                                                            @if ($vistaCategoriaIngreso->id_user == auth()->id())
                                                                <option value="{{ $vistaCategoriaIngreso->id }}">
                                                                    {{ $vistaCategoriaIngreso->categoria }}
                                                                </option>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </optgroup>
                                                <optgroup label="Tipo Egreso">
                                                    @foreach ($vistaCategoriaEgresos as $vistaCategoriaEgreso)
                                                        @if ($vistaCategoriaEgreso->plantilla == 1)
                                                            <option value="{{ $vistaCategoriaEgreso->id }}">
                                                                {{ $vistaCategoriaEgreso->categoria }}
                                                            </option>
                                                        @else
                                                            @if ($vistaCategoriaEgreso->id_user == auth()->id())
                                                                <option value="{{ $vistaCategoriaEgreso->id }}">
                                                                    {{ $vistaCategoriaEgreso->categoria }}
                                                                </option>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </optgroup>
                                            </select>
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
                                                    value="{{ old('subcategoria', auth()->user()->subcategoria) }}"
                                                    required />
                                                @if ($errors->has('subcategoria'))
                                                @endif
                                            </div>
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
@endsection
