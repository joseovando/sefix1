@extends('layouts.app', ['activePage' => 'presupuestosejecutados', 'titlePage' => __($titulo)])

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

<script>
    function nav(value) {
        if (value != "") {
            location.href = value;
        }
    }
</script>

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __($titulo) }}</h4>
                            <p class="card-category">{{ __('') }}</p>
                        </div>
                        <div class="card-body">

                            <form method="get" action="{{ route('presupuestosejecutados.create', $id_categoria) }}"
                                autocomplete="off" class="form-horizontal">
                                <div class="row">

                                    <div class="col-sm">
                                        <div class="form-group">
                                            <input id="date" width="276" name="date" value="{{ $date }}" />
                                            <script>
                                                $('#date').datepicker({
                                                    showOtherMonths: true,
                                                    format: 'yyyy-mm-dd'
                                                });
                                            </script>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <button type="submit"
                                            class="btn btn-primary">{{ __('Cambiar Rango de Fechas') }}</button>
                                    </div>
                                    <div class="col-sm">
                                        <input type="hidden" name="id_categoria" value="{{ $id_categoria }}">
                                        <input type="hidden" name="date_original" value="{{ $date }}">
                                        <input type="hidden" name="llave_form" value="1">
                                    </div>
                                </div>
                            </form>

                            <br>

                            <form method="post" action="{{ route('presupuestosejecutados.store') }}" autocomplete="off"
                                class="form-horizontal">

                                @csrf

                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">
                                                        <div class="form-group">
                                                            <select onChange=nav(this.value) class="form-control"
                                                                id="categoria" name="categoria">
                                                                @foreach ($vistaCategoriaPadres as $vistaCategoriaPadre)
                                                                    <option
                                                                        value="{{ route('presupuestosejecutados.create', $vistaCategoriaPadre->id) }}"
                                                                        @if ($id_categoria == $vistaCategoriaPadre->id) selected @endif>
                                                                        {{ $vistaCategoriaPadre->categoria }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <input type="hidden" name="id_categoria"
                                                                value="{{ $id_categoria }}">
                                                            <input type="hidden" name="date_original"
                                                                value="{{ $date }}">
                                                        </div>
                                                    </th>
                                                    @for ($i = 0; $i <= $n_inputs; $i++)
                                                        <th scope="col">{{ $calendario[$i] }}</th>
                                                    @endfor
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($vistaCategorias as $vistaCategoria)
                                                    <tr>
                                                        <th scope="row">{{ $vistaCategoria->categoria }}</th>
                                                        @for ($i = 0; $i <= $n_inputs; $i++)
                                                            <td>
                                                                <div class="input-group mb-3">
                                                                    <input type="text" class="form-control"
                                                                        name="{{ $vistaCategoria->id }}_{{ $fechas[$i] }}"
                                                                        @if (isset($egreso[$i][$vistaCategoria->id])) value="{{ $egreso[$i][$vistaCategoria->id] }}"> @endif
                                                                        </div>
                                                            </td>
                                                        @endfor
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="card-footer ml-auto mr-auto">
                                        <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
