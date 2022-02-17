@extends('layouts.app', ['activePage' => 'presupuestosprogramados', 'titlePage' => __('Presuspuesto Programado')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="{{ route('posts.store') }}" autocomplete="off" class="form-horizontal">

                    @csrf

                    <div class="card ">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Presupuesto Programado') }}</h4>
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
                                <div class="col-sm-9">
                                    <div class="form-group{{ $errors->has('titulo') ? ' has-danger' : '' }}">
                                        <select class="form-control" id="exampleFormControlSelect1">
                                            <option>Seleccione Subcategoria</option>
                                            <option>Subcategoria 1</option>
                                            <option>Subcategoria 2</option>
                                            <option>Subcategoria 3</option>
                                            <option>Subcategoria 4</option>
                                        </select>
                                        @if ($errors->has('titulo'))

                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Monto') }}</label>
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
                                            <option>Frecuencia</option>
                                            <option>Mensual</option>
                                            <option>Único</option>
                                            <option>Mensual</option>
                                            <option>Anual</option>
                                        </select>
                                        @if ($errors->has('titulo'))

                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Inicio') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('monto') ? ' has-danger' : '' }}">
                                        <input type="date" id="inicio" name="inicio">
                                        @if ($errors->has('monto'))
                                        <span id="monto-error" class="error text-danger" for="input-monto">{{
                                            $errors->first('monto') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Fin') }}</label>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('monto') ? ' has-danger' : '' }}">
                                        <input type="date" id="fin" name="fin">
                                        @if ($errors->has('monto'))
                                        <span id="monto-error" class="error text-danger" for="input-monto">{{
                                            $errors->first('monto') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('monto') ? ' has-danger' : '' }}">
                                        <input class="form-check-input" type="checkbox"> Sin Caducidad
                                        @if ($errors->has('monto'))
                                        <span id="monto-error" class="error text-danger" for="input-monto">{{
                                            $errors->first('monto') }}</span>
                                        @endif
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