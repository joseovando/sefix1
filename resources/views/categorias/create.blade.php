@extends('layouts.app', ['activePage' => 'categorias', 'titlePage' => __('Categoria y Subcategorias')])

@section('content')

<link rel="stylesheet" href="{{ asset('css/colorPick.css') }}">
<link rel="stylesheet" href="{{ asset('css/colorPick.dark.theme.css') }}">

<style>
    .picker {
        border-radius: 5px;
        width: 36px;
        height: 36px;
        cursor: pointer;
        -webkit-transition: all linear .2s;
        -moz-transition: all linear .2s;
        -ms-transition: all linear .2s;
        -o-transition: all linear .2s;
        transition: all linear .2s;
        border: thin solid #eee;
    }

    .picker:hover {
        transform: scale(1.1);
    }
</style>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="{{ route('posts.store') }}" autocomplete="off" class="form-horizontal">

                    @csrf

                    <div class="card ">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Categoria y Subcategorias') }}</h4>
                            <p class="card-category">{{ __('') }}</p>
                        </div>
                        <div class="card-body ">
                            @if (session('status'))
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="alert alert-success">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <i class="material-icons">close</i>
                                        </button>
                                        <span>{{ session('status') }}</span>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Nombre') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('monto') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('monto') ? ' is-invalid' : '' }}" name="monto" id="input-monto" type="text" placeholder="{{ __('monto') }}" value="{{ old('monto', auth()->user()->monto) }}" required />
                                        @if ($errors->has('monto'))
                                        <span id="monto-error" class="error text-danger" for="input-monto">{{
                                            $errors->first('monto') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-9">
                                    <div class="form-group{{ $errors->has('titulo') ? ' has-danger' : '' }}">
                                        <select class="form-control" id="exampleFormControlSelect1">
                                            <option>Seleccione una Categoria</option>
                                            <option>Categoria 1</option>
                                            <option>Categoria 2</option>
                                            <option>Categoria 3</option>
                                            <option>Categoria 4</option>
                                        </select>
                                        @if ($errors->has('titulo'))

                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Color de Fondo') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('monto') ? ' has-danger' : '' }}">
                                        <div class="card">
                                            <div class="card-body text-center d-flex justify-content-center align-items-center flex-column">
                                                <div class="picker" id="picker1"></div>
                                                <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
                                                <script src="{{ asset('js/colorPick.js') }}"></script>
                                                <script>
                                                    $("#picker1").colorPick({
                                                        'initialColor': '#8e44ad',
                                                        'palette': ["#1abc9c", "#16a085", "#2ecc71", "#27ae60", "#3498db", "#2980b9", "#9b59b6", "#8e44ad", "#34495e", "#2c3e50", "#f1c40f", "#f39c12", "#e67e22", "#d35400", "#e74c3c", "#c0392b", "#ecf0f1"],
                                                        'onColorSelected': function() {
                                                            console.log("The user has selected the color: " + this.color)
                                                            this.element.css({
                                                                'backgroundColor': this.color,
                                                                'color': this.color
                                                            });
                                                        }
                                                    });
                                                </script>
                                            </div>
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