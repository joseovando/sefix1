@extends('layouts.app', ['activePage' => 'presupuestosejecutados', 'titlePage' => __($titulo)])

<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('js/gijgo.min.js') }}" type="text/javascript"></script>
<link href="{{ asset('css/gijgo.min.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('js/messages.es-es.js') }}" type="text/javascript"></script>

<script>
    function nav(value) {
        if (value != "") {
            location.href = value;
        }
    }
</script>

<script>
    $(function() {
        var estado = JSON.parse(`<?php echo $estado; ?>`);
        if (estado == 1) {
            md.showNotification('top', 'right').notify({});
        }
    });
</script>

<style>
    textarea,
    input {
        padding: 10px;
        font-family: FontAwesome, "Open Sans", Verdana, sans-serif;
        font-style: normal;
        font-weight: normal;
        text-decoration: inherit;
    }

</style>

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
                                action="{{ route('presupuestosejecutados.create', [
                                    'id' => $id_categoria,
                                    'menu' => $menu,
                                    'date' => $date,
                                    'estado' => $estado,
                                ]) }}"
                                autocomplete="off" class="form-horizontal">
                                <div class="row">

                                    <div class="col-sm">

                                        <div class="form-group">
                                            <input id="date" width="276" name="date" value="{{ $date }}" />
                                            <script>
                                                $('#date').datepicker({
                                                    showOtherMonths: true,
                                                    locale: 'es-es',
                                                    format: 'yyyy-mm-dd',
                                                    weekStartDay: 1
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
                                                                    @if ($vistaCategoriaPadre->plantilla == 1)
                                                                        <option
                                                                            value="{{ route('presupuestosejecutados.create', [
                                                                                'id' => $vistaCategoriaPadre->id,
                                                                                'menu' => $menu,
                                                                                'date' => $date,
                                                                                'estado' => $estado,
                                                                            ]) }}"
                                                                            @if ($id_categoria == $vistaCategoriaPadre->id) selected @endif>
                                                                            {{ $vistaCategoriaPadre->categoria }}
                                                                        </option>
                                                                    @else
                                                                        @if ($vistaCategoriaPadre->id_user == auth()->id())
                                                                            <option
                                                                                value="{{ route('presupuestosejecutados.create', [
                                                                                    'id' => $vistaCategoriaPadre->id,
                                                                                    'menu' => $menu,
                                                                                    'date' => $date,
                                                                                    'estado' => $estado,
                                                                                ]) }}"
                                                                                @if ($id_categoria == $vistaCategoriaPadre->id) selected @endif>
                                                                                {{ $vistaCategoriaPadre->categoria }}
                                                                            </option>
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                            <input type="hidden" name="id_categoria"
                                                                value="{{ $id_categoria }}">
                                                            <input type="hidden" name="menu" value="{{ $menu }}">
                                                            <input type="hidden" name="tipo" value="{{ $tipo }}">
                                                            <input type="hidden" name="date" value="{{ $date }}">
                                                        </div>
                                                    </th>
                                                    @for ($i = 0; $i <= $n_inputs; $i++)
                                                        <th scope="col">{{ $calendario[$i] }}</th>
                                                    @endfor
                                                    <th scope="col">Total Ejecutado Mes</th>
                                                    <th scope="col">Total Programado Mes</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($vistaCategorias as $vistaCategoria)
                                                    @if ($vistaCategoria->plantilla == 1)
                                                        <tr>
                                                            <th scope="row">{{ $vistaCategoria->categoria }}</th>
                                                            @for ($i = 0; $i <= $n_inputs; $i++)
                                                                <td>
                                                                    <div class="input-group mb-3">

                                                                        <input type="text" class="form-control"
                                                                            name="{{ $vistaCategoria->id }}_{{ $fechas[$i] }}"
                                                                            style="font-family: FontAwesome"
                                                                            placeholder="&#xf0d6;"
                                                                            @if (isset($egreso[$i][$vistaCategoria->id])) value="{{ $egreso[$i][$vistaCategoria->id] }}" @endif
                                                                            onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">

                                                                        <a href="" data-toggle="modal"
                                                                            data-target="#modal_{{ $vistaCategoria->id }}_{{ $fechas[$i] }}"><i
                                                                                class="material-icons">description</i></a>

                                                                        <div id="modal_{{ $vistaCategoria->id }}_{{ $fechas[$i] }}"
                                                                            class="modal fade" tabindex="-1"
                                                                            role="dialog"
                                                                            aria-labelledby="exampleModalPopoversLabel"
                                                                            style="display: none;" aria-hidden="true">
                                                                            <div class="modal-dialog" role="document">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title"
                                                                                            id="exampleModalPopoversLabel">
                                                                                            Detalle
                                                                                        </h5>
                                                                                        <button type="button"
                                                                                            class="close"
                                                                                            data-dismiss="modal"
                                                                                            aria-label="Close">
                                                                                            <span
                                                                                                aria-hidden="true">×</span>
                                                                                        </button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="exampleFormControlTextarea1">Detalle</label>
                                                                                            @if (isset($detalle[$i][$vistaCategoria->id]))
                                                                                                <textarea class="form-control" name="detalle_{{ $vistaCategoria->id }}_{{ $fechas[$i] }}"
                                                                                                    rows="5">{{ $detalle[$i][$vistaCategoria->id] }}</textarea>
                                                                                            @else
                                                                                                <textarea class="form-control" name="detalle_{{ $vistaCategoria->id }}_{{ $fechas[$i] }}" rows="3"></textarea>
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button"
                                                                                            class="btn btn-secondary"
                                                                                            data-dismiss="modal">Cerrar</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </td>
                                                            @endfor

                                                            @if ($total_ejecutado_subcategoria[$vistaCategoria->id] > 0)
                                                                <th scope="row" bgcolor="#fec87c">
                                                                    {{ $total_ejecutado_subcategoria[$vistaCategoria->id] }}
                                                                </th>
                                                            @else
                                                                <th scope="row" bgcolor="#fec87c"></th>
                                                            @endif

                                                            @if ($total_programado_subcategoria[$vistaCategoria->id] > 0)
                                                                <th scope="row" bgcolor="#0cd0e8">
                                                                    {{ $total_programado_subcategoria[$vistaCategoria->id] }}
                                                                </th>
                                                            @else
                                                                <th scope="row" bgcolor="#0cd0e8"></th>
                                                            @endif

                                                        </tr>
                                                    @else
                                                        @if ($vistaCategoria->id_user == auth()->id())
                                                            <tr>
                                                                <th scope="row">{{ $vistaCategoria->categoria }}</th>
                                                                @for ($i = 0; $i <= $n_inputs; $i++)
                                                                    <td>
                                                                        <div class="input-group mb-3">

                                                                            <input type="text" class="form-control"
                                                                                name="{{ $vistaCategoria->id }}_{{ $fechas[$i] }}"
                                                                                style="font-family: FontAwesome"
                                                                                placeholder="&#xf0d6;"
                                                                                @if (isset($egreso[$i][$vistaCategoria->id])) value="{{ $egreso[$i][$vistaCategoria->id] }}" @endif
                                                                                onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">

                                                                            <a href="" data-toggle="modal"
                                                                                data-target="#modal_{{ $vistaCategoria->id }}_{{ $fechas[$i] }}"><i
                                                                                    class="material-icons">description</i></a>

                                                                            <div id="modal_{{ $vistaCategoria->id }}_{{ $fechas[$i] }}"
                                                                                class="modal fade" tabindex="-1"
                                                                                role="dialog"
                                                                                aria-labelledby="exampleModalPopoversLabel"
                                                                                style="display: none;" aria-hidden="true">
                                                                                <div class="modal-dialog" role="document">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h5 class="modal-title"
                                                                                                id="exampleModalPopoversLabel">
                                                                                                Detalle
                                                                                            </h5>
                                                                                            <button type="button"
                                                                                                class="close"
                                                                                                data-dismiss="modal"
                                                                                                aria-label="Close">
                                                                                                <span
                                                                                                    aria-hidden="true">×</span>
                                                                                            </button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    for="exampleFormControlTextarea1">Detalle</label>
                                                                                                @if (isset($detalle[$i][$vistaCategoria->id]))
                                                                                                    <blade
                                                                                                        ___html_tags_2___ />
                                                                                                @else
                                                                                                    <blade
                                                                                                        ___html_tags_3___ />
                                                                                                @endif
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <button type="button"
                                                                                                class="btn btn-secondary"
                                                                                                data-dismiss="modal">Cerrar</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </td>
                                                                @endfor

                                                                @if ($total_ejecutado_subcategoria[$vistaCategoria->id] > 0)
                                                                    <th scope="row" bgcolor="#fec87c">
                                                                        {{ $total_ejecutado_subcategoria[$vistaCategoria->id] }}
                                                                    </th>
                                                                @else
                                                                    <th scope="row" bgcolor="#fec87c"></th>
                                                                @endif

                                                                @if ($total_programado_subcategoria[$vistaCategoria->id] > 0)
                                                                    <th scope="row" bgcolor="#0cd0e8">
                                                                        {{ $total_programado_subcategoria[$vistaCategoria->id] }}
                                                                    </th>
                                                                @else
                                                                    <th scope="row" bgcolor="#0cd0e8"></th>
                                                                @endif

                                                            </tr>
                                                        @endif
                                                    @endif
                                                @endforeach

                                                <tr>
                                                    <th scope="row">Total</th>
                                                    @for ($i = 0; $i <= $n_inputs; $i++)
                                                        @if ($total_monto_dia[$i] > 0)
                                                            <th scope="row" bgcolor="#7adf7f" align="right">
                                                                {{ $total_monto_dia[$i] }}</th>
                                                        @else
                                                            <th scope="row" bgcolor="#7adf7f" align="right"></th>
                                                        @endif
                                                    @endfor
                                                    <th scope="row" bgcolor="#fec87c" align="right">
                                                        {{ $total_ejecutado_mes }}</th>
                                                    <th scope="row" bgcolor="#0cd0e8" align="right">
                                                        {{ $total_programado_mes }}</th>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="card-footer ml-auto mr-auto">
                                        <button type="submit"
                                            class="save-button first btn btn-primary">{{ __('Guardar') }}</button>
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
