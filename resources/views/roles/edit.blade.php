@extends('layouts.app', ['activePage' => 'Roles', 'titlePage' => __('Roles')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="{{ route('roles.update', $role) }}" autocomplete="off"
                        class="form-horizontal">

                        @csrf
                        @method('PUT')

                        <div class="card ">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">{{ __('Editar Rol') }}</h4>
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
                                    <input type="hidden" value="{{ $role->id }}" name="role_id">
                                    <label class="col-sm-2 col-form-label">{{ __('Nombre del Permiso') }}</label>
                                    <div class="col-sm-7">
                                        <input class="form-control" type="text" name="name"
                                            placeholder="Nombre del Permiso" value="{{ old('name', $role->name) }}"
                                            required="true">
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Asignar Permisos') }}</label>
                                    <div class="tab-pane active" id="profile">
                                        <table class="table">
                                            <tbody>
                                                @foreach ($permissions as $id => $permission)
                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <label class="form-check-label">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="permissions[]" value="{{ $id }}"
                                                                        {{ $role->permissions->contains($id) ? 'checked' : '' }}>
                                                                    <span class="form-check-sign">
                                                                        <span class="check"></span>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td>{{ $permission }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
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
