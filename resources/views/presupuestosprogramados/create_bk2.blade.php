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

                            <form method="post" action="{{ route('presupuestosprogramados.store') }}" autocomplete="off"
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
                                                                        @if ($id == $vistaCategoriaPadre->id) selected @endif>
                                                                        {{ $vistaCategoriaPadre->categoria }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <input type="hidden" name="id_categoria"
                                                                value="{{ $id }}">
                                                        </div>
                                                    </th>
                                                    <th>Monto</th>
                                                    <th>Frecuencia</th>
                                                    <th>Sin Caducidad</th>
                                                    <th>Desde Fecha</th>
                                                    <th>Hasta Fecha</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($vistaCategorias as $vistaCategoria)
                                                    <tr>
                                                        <th scope="row">{{ $vistaCategoria->categoria }}</th>
                                                        <td>
                                                            <div class="col-sm">
                                                                <div
                                                                    class="form-group{{ $errors->has('monto') ? ' has-danger' : '' }}">
                                                                    <input
                                                                        class="form-control{{ $errors->has('monto') ? ' is-invalid' : '' }}"
                                                                        name="monto_{{ $vistaCategoria->id }}"
                                                                        id="monto_{{ $vistaCategoria->id }}" type="text"
                                                                        placeholder="{{ __('monto') }}"
                                                                        value="{{ old('monto', auth()->user()->monto) }}"
                                                                        style="width: 50px"
                                                                        onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" />
                                                                    <span id="result"></span>
                                                                    <script>
                                                                        var inival = $("#monto_{{ $vistaCategoria->id }}").val();
                                                                        $("#monto_{{ $vistaCategoria->id }}").change(function() {
                                                                            if ($("#monto_{{ $vistaCategoria->id }}").val() > 0) {
                                                                                inicio_{{ $vistaCategoria->id }}.setAttribute("required", "")
                                                                                frecuencia_{{ $vistaCategoria->id }}.setAttribute("required", "")
                                                                            }
                                                                        });
                                                                    </script>
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="col-sm">
                                                                <div class="form-group">
                                                                    <select class="form-control"
                                                                        id="frecuencia_{{ $vistaCategoria->id }}"
                                                                        name="frecuencia_{{ $vistaCategoria->id }}">
                                                                        <option value="0">Frecuencia</option>
                                                                        @foreach ($frecuencias as $frecuencia)
                                                                            <option value="{{ $frecuencia->id }}">
                                                                                {{ $frecuencia->frecuencia }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <script>
                                                                        document.getElementById('frecuencia_' + '{!! $vistaCategoria->id !!}').addEventListener('change', function(event) {
                                                                            if (this.options.selectedIndex === 1) {
                                                                                div_{{ $vistaCategoria->id }}.style.display = 'none';
                                                                                fin_{{ $vistaCategoria->id }}.removeAttribute("required");

                                                                            } else {
                                                                                div_{{ $vistaCategoria->id }}.style.display = 'initial';
                                                                                fin_{{ $vistaCategoria->id }}.setAttribute("required", "");
                                                                            }
                                                                        });
                                                                    </script>
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td align="center">
                                                            <div class="col-sm">
                                                                <div class="form-check form-check-inline">
                                                                    <label class="form-check-label">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            id="sin_caducidad_{{ $vistaCategoria->id }}"
                                                                            value="1"
                                                                            name="sin_caducidad_{{ $vistaCategoria->id }}"
                                                                            onchange="javascript:showContent_{{ $vistaCategoria->id }}()">
                                                                        <span class="form-check-sign">
                                                                            <span class="check"></span>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <script type="text/javascript">
                                                                function showContent_{{ $vistaCategoria->id }}() {
                                                                    if (document.getElementById('sin_caducidad_' + '{!! $vistaCategoria->id !!}').checked === true) {
                                                                        div_{{ $vistaCategoria->id }}.style.display = 'none';
                                                                        fin_{{ $vistaCategoria->id }}.removeAttribute("required");
                                                                    } else {
                                                                        div_{{ $vistaCategoria->id }}.style.display = 'initial';
                                                                        fin_{{ $vistaCategoria->id }}.setAttribute("required", "");

                                                                    }
                                                                }
                                                            </script>
                                                        </td>

                                                        <td>
                                                            <div class="col-sm">
                                                                <div class="form-group">
                                                                    <input id="inicio_{{ $vistaCategoria->id }}"
                                                                        width="110"
                                                                        name="inicio_{{ $vistaCategoria->id }}" />
                                                                    <script>
                                                                        var html = '#inicio_' + '{!! $vistaCategoria->id !!}';
                                                                        $(html).datepicker({
                                                                            showOtherMonths: true,
                                                                            format: 'yyyy-mm-dd'
                                                                        });
                                                                    </script>
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="col-sm"
                                                                id="div_{{ $vistaCategoria->id }}" style="initial">
                                                                <div class="form-group">
                                                                    <input id="fin_{{ $vistaCategoria->id }}" width="110"
                                                                        name="fin_{{ $vistaCategoria->id }}" />
                                                                    <script>
                                                                        var html = '#fin_' + '{!! $vistaCategoria->id !!}';
                                                                        $(html).datepicker({
                                                                            showOtherMonths: true,
                                                                            format: 'yyyy-mm-dd'
                                                                        });
                                                                    </script>
                                                                </div>
                                                            </div>
                                                        </td>
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
