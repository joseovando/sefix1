@extends('layouts.app', ['activePage' => 'reporte', 'titlePage' => __('Reporte qCuentas')])

<link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.dataTables.min.css') }}">
<script type="text/javascript" language="javascript" src="{{ asset('js/jquery-3.5.1.js') }}"></script>
<script type="text/javascript" language="javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>

<script type="text/javascript" language="javascript" src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
<script type="text/javascript" language="javascript" src="{{ asset('js/jszip.min.js') }}"></script>
<script type="text/javascript" language="javascript" src="{{ asset('js/pdfmake.min.js') }}"></script>
<script type="text/javascript" language="javascript" src="{{ asset('js/vfs_fonts.js') }}"></script>
<script type="text/javascript" language="javascript" src="{{ asset('js/buttons.html5.min.js') }}"></script>

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

<script type="text/javascript" class="init">
    $(document).ready(function() {
        $('#tabla-cuentas').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'pdfHtml5'
            ],
        });
    });
</script>

@section('content')
    <div class="content">
        <div class="container-fluid">

            {{-- Cambiar Fecha --}}
            <form method="get"
                action="{{ route('cuentas.reporte', [
                    'mes' => $mes_actual,
                    'ano' => $ano_actual,
                ]) }}"
                autocomplete="off" class="form-horizontal">

                <div class="row">
                    <div class="col-sm">
                        <label for="exampleFormControlSelect1">Mes</label>
                    </div>

                    <div class="col-sm">
                        <div class="form-group">

                            <select class="form-control" id="ano_actual" name="ano_actual">
                                @for ($i = $ano_actual_inicio; $i <= $ano_actual_fin; $i++)
                                    <option value="{{ $i }}" @if ($i == $ano_actual) selected @endif>
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
                                    <option value="{{ $i }}" @if ($i == $mes_actual) selected @endif>
                                        {{ $meses[$i] }}
                                    </option>
                                @endfor
                            </select>

                        </div>
                    </div>
                    <div class="col-sm">
                        <button type="submit" class="btn btn-primary">{{ __('Cambiar Mes') }}</button>
                    </div>
                    <div class="col-sm">
                        <input type="hidden" name="llave_form" value="1">
                    </div>
                </div>

            </form>
            {{-- Cambiar Fecha --}}

            <!-- Table -->
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Estado Mensual Presupuesto</h4>
                            <p class="card-category">{{ $mes_actual_text }}</p>
                        </div>
                        <div class="card-body">

                            <table id="tabla-cuentas" class="display data-table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Detalle</th>
                                        <th>Monto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cuentaTipos as $cuentaTipo)
                                        @if ($cuentaTipo->id == 1)
                                            <tr>
                                                <th colspan="2">INGRESOS</th>
                                            </tr>
                                        @else
                                            <tr>
                                                <th colspan="2">EGRESOS</th>
                                            </tr>
                                        @endif

                                        <tr>
                                            <th>{{ $cuentaTipo->tipo_categoria }}</th>
                                            <td>{{ number_format($total_tipo[$cuentaTipo->id], 2) }}</td>
                                        </tr>

                                        @if ($cuentaTipo->id == 1)
                                            <tr>
                                                <th>Ingreso Ejecutado</th>
                                                <td>{{ number_format($total_ingreso, 2) }}</td>
                                            </tr>
                                        @else
                                            <tr>
                                                <th>Egreso Ejecutado</th>
                                                <td>{{ number_format($total_egreso, 2) }}</td>
                                            </tr>
                                        @endif

                                        @if ($cuentaTipo->id == 1)
                                            <tr>
                                                <th>Total Ingreso Plus</th>
                                                <th>{{ number_format($total_ingreso_plus, 2) }}</th>
                                            </tr>
                                        @else
                                            <tr>
                                                <th>Total Egreso Plus</th>
                                                <th>{{ number_format($total_egreso_plus, 2) }}</th>
                                            </tr>
                                        @endif
                                    @endforeach

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Superavit / Deficit Mensual</th>
                                        <th>{{ number_format($deficit, 2) }}</th>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>
                        <div class="card-footer">
                        </div>
                    </div>
                </div>
            </div>
            <!-- table -->

        </div>
    </div>
@endsection
@push('js')
@endpush
