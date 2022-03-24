@extends('layouts.app', ['activePage' => 'Permisos', 'titlePage' => __('Permisos')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="{{ route('permissions.update', $permission) }}" autocomplete="off"
                        class="form-horizontal">

                        @csrf
                        @method('PUT')

                        <div class="card ">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">{{ __('Editar Permiso') }}</h4>
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
                                    <input type="hidden" value="{{ $permission->id }}" name="permission_id">
                                    <label class="col-sm-2 col-form-label">{{ __('Nombre del Permiso') }}</label>
                                    <div class="col-sm-7">
                                        <input class="form-control" type="text" name="name"
                                            placeholder="Nombre del Permiso" value="{{ old('name', $permission->name) }}"
                                            required="true">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer ml-auto mr-auto">
                                <button type="submit" class="btn btn-primary">{{ __('Editar') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
