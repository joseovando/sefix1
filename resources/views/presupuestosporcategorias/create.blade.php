@extends('layouts.app', ['activePage' => 'presupuestosprogramados', 'titlePage' => __('Presuspuesto Programado por Categoria')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="{{ route('posts.store') }}" autocomplete="off" class="form-horizontal">

                    @csrf

                    <div class="card ">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Presupuesto Programado por Categoria') }}</h4>
                            <p class="card-category">{{ __('Definir Tiempo ???????????') }}</p>
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
                                <label class="col-sm-2 col-form-label">{{ __('Servicios Basicos') }}</label>
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
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item active" aria-current="page">Subcategorias</li>
                                </ol>
                            </nav>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Celular') }}</label>
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
                                <label class="col-sm-2 col-form-label">{{ __('Agua') }}</label>
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
                                <label class="col-sm-2 col-form-label">{{ __('Energía Eléctrica') }}</label>
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
                                <label class="col-sm-2 col-form-label">{{ __('Gas') }}</label>
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
                                <label class="col-sm-2 col-form-label">{{ __('Cable') }}</label>
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