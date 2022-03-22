@extends('layouts.app', ['activePage' => 'categorias', 'titlePage' => __('Nueva Categoria')])
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="{{ route('categorias.update_categoria') }}" autocomplete="off"
                        class="form-horizontal">

                        @csrf
                        @method('put')

                        <div class="card ">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">{{ __('Nueva Categoria') }}</h4>
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
                                            <label for="exampleFormControlSelect1">Tipo de Categoria</label>
                                            <select class="form-control" id="_tipo_categoria" name="tipo_categoria">
                                                <option>Seleccione Tipo de Categoria</option>
                                                @foreach ($categoriaTipos as $categoriaTipo)
                                                    <option value="{{ $categoriaTipo->id }}"
                                                        @if ($categoriaTipo->id == $vistaCategoriaPadre->orden_tipo) selected @endif>
                                                        {{ $categoriaTipo->tipo_categoria }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" value="{{ $vistaCategoriaPadre->id }}" name="id_categoria">
                                        </div>
                                    </div>

                                    <div class="col-sm">
                                        <label for="exampleFormControlSelect1">Nombre Categoria</label>
                                        <div class="col-sm-7">
                                            <div class="form-group{{ $errors->has('categoria') ? ' has-danger' : '' }}">
                                                <input
                                                    class="form-control{{ $errors->has('categoria') ? ' is-invalid' : '' }}"
                                                    name="categoria" id="categoria" type="text"
                                                    placeholder="{{ __('Categoria') }}"
                                                    value="{{ $vistaCategoriaPadre->categoria }}" required />
                                                @if ($errors->has('categoria'))
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-sm">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Logo Categoria</label>
                                            <select class="form-control selectpicker" id="_logo_categoria"
                                                name="logo_categoria">
                                                <option>Seleccione Logo</option>
                                                @foreach ($categoriaLogos as $categoriaLogo)
                                                    <option
                                                        value="{{ $categoriaLogo->icono }} {{ $categoriaLogo->tamano }}"
                                                        data-icon="{{ $categoriaLogo->icono }}"
                                                        @if ($categoriaLogo->icono == $vistaCategoriaPadre->icono) selected @endif>
                                                        - {{ $categoriaLogo->label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Fondo Categoria</label>
                                            <select class="form-control selectpicker" id="_fondo_categoria"
                                                name="fondo_categoria">
                                                <option>Seleccione Fondo Categoria</option>
                                                <option value="bg-secondary" class="bg-secondary"
                                                    @if ($vistaCategoriaPadre->fondo == 'bg-secondary') selected @endif>
                                                    Plomo</option>
                                                <option value="bg-primary" class="bg-primary"
                                                    @if ($vistaCategoriaPadre->fondo == 'bg-primary') selected @endif>
                                                    Azul</option>
                                                <option value="bg-danger" class="bg-danger"
                                                    @if ($vistaCategoriaPadre->fondo == 'bg-danger') selected @endif>
                                                    Rojo</option>
                                                <option value="bg-warning" class="bg-warning"
                                                    @if ($vistaCategoriaPadre->fondo == 'bg-warning') selected @endif>
                                                    Amarillo</option>
                                                <option value="bg-info" class="bg-info"
                                                    @if ($vistaCategoriaPadre->fondo == 'bg-info') selected @endif>
                                                    Celeste</option>
                                                <option value="bg-dark" class="bg-dark" style="color: #fff"
                                                    @if ($vistaCategoriaPadre->fondo == 'bg-dark') selected @endif>
                                                    Negro</option>
                                            </select>
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