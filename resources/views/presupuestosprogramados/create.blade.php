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

                            <form method="get"
                                action="{{ route('presupuestosprogramados.create', [
                                    'id' => $id,
                                    'menu' => $menu,
                                    'ano' => $ano_actual,
                                    'mes' => $mes_actual,
                                ]) }}"
                                autocomplete="off" class="form-horizontal">

                                <div class="row">
                                    <div class="col-sm">
                                        <label for="exampleFormControlSelect1">Mes Programado</label>
                                    </div>
                                    <div class="col-sm">
                                        <div class="form-group">

                                            <select class="form-control" id="ano_actual" name="ano_actual">
                                                @for ($i = $ano_actual_inicio; $i <= $ano_actual_fin; $i++)
                                                    <option value="{{ $i }}"
                                                        @if ($i == $ano_actual) selected @endif>
                                                        {{ $i }}
                                                    </option>
                                                @endfor
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="form-group">

                                            <select class="form-control" id="mes_actual" name="mes_actual">
                                                @for ($i = 1; $i <= 12; $i++)
                                                    <option value="{{ $i }}"
                                                        @if ($i == $mes_actual) selected @endif>
                                                        {{ $meses[$i] }}
                                                    </option>
                                                @endfor
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <button type="submit"
                                            class="btn btn-primary">{{ __('Cambiar Mes Programado') }}</button>
                                    </div>
                                    <div class="col-sm">
                                        <input type="hidden" name="llave_form" value="1">
                                    </div>
                                </div>

                            </form>

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
                                                                        value="{{ route('presupuestosprogramados.create', [
                                                                            'id' => $vistaCategoriaPadre->id,
                                                                            'menu' => $menu,
                                                                            'ano' => $ano_actual,
                                                                            'mes' => $mes_actual,
                                                                        ]) }}"
                                                                        @if ($id == $vistaCategoriaPadre->id) selected @endif>
                                                                        {{ $vistaCategoriaPadre->categoria }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <input type="hidden" name="id_categoria"
                                                                value="{{ $id }}">
                                                            <input type="hidden" name="tipo" value="{{ $tipo }}">
                                                            <input type="hidden" name="menu" value="{{ $menu }}">
                                                            <input type="hidden" name="mes_actual"
                                                                value="{{ $mes_actual }}">
                                                            <input type="hidden" name="ano_actual"
                                                                value="{{ $ano_actual }}">
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

                                                        <script>
                                                            $(function() {
                                                                if ($("#monto_{{ $vistaCategoria->id }}").val() > 0) {

                                                                    if ($("#frecuencia_{{ $vistaCategoria->id }}").val() == 1) {
                                                                        div_{{ $vistaCategoria->id }}.style.display = 'none';
                                                                        fin_{{ $vistaCategoria->id }}.removeAttribute("required");
                                                                        div2_{{ $vistaCategoria->id }}.style.display = 'none';
                                                                        sin_caducidad_{{ $vistaCategoria->id }}.removeAttribute("required");
                                                                    }

                                                                    if ($("#sin_caducidad_{{ $vistaCategoria->id }}").is(":checked") == true) {
                                                                        div_{{ $vistaCategoria->id }}.style.display = 'none';
                                                                        fin_{{ $vistaCategoria->id }}.removeAttribute("required");
                                                                    }
                                                                }
                                                            });
                                                        </script>

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
                                                                        @if (isset($monto[$vistaCategoria->id])) value="{{ $monto[$vistaCategoria->id] }}" @endif
                                                                        style="width: 50px"
                                                                        onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" />
                                                                    <span id="result"></span>
                                                                    <script>
                                                                        $("#monto_{{ $vistaCategoria->id }}").change(function() {
                                                                            if ($("#monto_{{ $vistaCategoria->id }}").val() > 0) {
                                                                                frecuencia_{{ $vistaCategoria->id }}.setAttribute("required", "")
                                                                            } else {
                                                                                frecuencia_{{ $vistaCategoria->id }}.removeAttribute("required");
                                                                                inicio_{{ $vistaCategoria->id }}.removeAttribute("required");
                                                                                div_{{ $vistaCategoria->id }}.style.display = 'initial';
                                                                                fin_{{ $vistaCategoria->id }}.removeAttribute("required");
                                                                                div2_{{ $vistaCategoria->id }}.style.display = 'initial';
                                                                            }
                                                                        });
                                                                    </script>
                                                                </div>
                                                            </div>

                                                            <input type="hidden" name="id_{{ $vistaCategoria->id }}"
                                                                @if (isset($id_ingreso_programado[$vistaCategoria->id])) value="{{ $id_ingreso_programado[$vistaCategoria->id] }}" @endif>
                                                        </td>

                                                        <td>
                                                            <div class="col-sm">
                                                                <div class="form-group">
                                                                    <select class="form-control"
                                                                        id="frecuencia_{{ $vistaCategoria->id }}"
                                                                        name="frecuencia_{{ $vistaCategoria->id }}">
                                                                        <option value="">Frecuencia</option>
                                                                        @foreach ($frecuencias as $frecuencia)
                                                                            <option value="{{ $frecuencia->id }}"
                                                                                @if (isset($id_frecuencia[$vistaCategoria->id])) @if ($id_frecuencia[$vistaCategoria->id] == $frecuencia->id) 
                                                                                    selected @endif
                                                                                @endif
                                                                                >
                                                                                {{ $frecuencia->frecuencia }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <script>
                                                                        document.getElementById('frecuencia_' + '{!! $vistaCategoria->id !!}').addEventListener('change', function(
                                                                            event) {

                                                                            if ($("#monto_{{ $vistaCategoria->id }}").val() > 0) {
                                                                                if ($("#frecuencia_{{ $vistaCategoria->id }}").val() == 1) {
                                                                                    inicio_{{ $vistaCategoria->id }}.setAttribute("required", "");
                                                                                    div_{{ $vistaCategoria->id }}.style.display = 'none';
                                                                                    fin_{{ $vistaCategoria->id }}.removeAttribute("required");
                                                                                    div2_{{ $vistaCategoria->id }}.style.display = 'none';
                                                                                    sin_caducidad_{{ $vistaCategoria->id }}.removeAttribute("required");
                                                                                }

                                                                                if ($("#frecuencia_{{ $vistaCategoria->id }}").val() > 1) {
                                                                                    inicio_{{ $vistaCategoria->id }}.setAttribute("required", "");
                                                                                    div_{{ $vistaCategoria->id }}.style.display = 'initial';
                                                                                    fin_{{ $vistaCategoria->id }}.setAttribute("required", "");
                                                                                    div2_{{ $vistaCategoria->id }}.style.display = 'initial';
                                                                                }
                                                                            }
                                                                        });
                                                                    </script>
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td align="center">
                                                            <div class="col-sm">
                                                                <div class="form-check form-check-inline"
                                                                    id="div2_{{ $vistaCategoria->id }}">
                                                                    <label class="form-check-label">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            id="sin_caducidad_{{ $vistaCategoria->id }}"
                                                                            @if (isset($caducidad[$vistaCategoria->id])) @if ($caducidad[$vistaCategoria->id] == 1) value="1" checked
                                                                            @else
                                                                            value="1" @endif
                                                                            @endif
                                                                        name="sin_caducidad_{{ $vistaCategoria->id }}">
                                                                        <span class="form-check-sign">
                                                                            <span class="check"></span>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <script type="text/javascript">
                                                                $("#sin_caducidad_{{ $vistaCategoria->id }}").change(function() {

                                                                    if ($("#monto_{{ $vistaCategoria->id }}").val() > 0) {
                                                                        if (document.getElementById('sin_caducidad_' + '{!! $vistaCategoria->id !!}').checked === true) {
                                                                            div_{{ $vistaCategoria->id }}.style.display = 'none';
                                                                            fin_{{ $vistaCategoria->id }}.removeAttribute("required");
                                                                        } else {
                                                                            div_{{ $vistaCategoria->id }}.style.display = 'initial';
                                                                            fin_{{ $vistaCategoria->id }}.setAttribute("required", "");
                                                                        }
                                                                    }
                                                                });
                                                            </script>
                                                        </td>

                                                        <td>
                                                            <div class="col-sm">
                                                                <div class="form-group">
                                                                    <input id="inicio_{{ $vistaCategoria->id }}"
                                                                        width="110"
                                                                        name="inicio_{{ $vistaCategoria->id }}"
                                                                        @if (isset($fecha_inicio[$vistaCategoria->id])) value="{{ $fecha_inicio[$vistaCategoria->id] }}" @endif />
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
                                                                        name="fin_{{ $vistaCategoria->id }}"
                                                                        @if (isset($fecha_fin[$vistaCategoria->id])) value="{{ $fecha_fin[$vistaCategoria->id] }}" @endif />
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
