@extends('layouts.app', ['activePage' => 'reportes', 'titlePage' => __('Reportes')])

<link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/buttons.dataTables.min.css') }}">

<script type="text/javascript" language="javascript" src="{{ asset('js/jquery-3.5.1.js') }}"></script>
<script type="text/javascript" language="javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" language="javascript" src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
<script type="text/javascript" language="javascript" src="{{ asset('js/jszip.min.js') }}"></script>
<script type="text/javascript" language="javascript" src="{{ asset('js/pdfmake.min.js') }}"></script>
<script type="text/javascript" language="javascript" src="{{ asset('js/vfs_fonts.js') }}"></script>
<script type="text/javascript" language="javascript" src="{{ asset('js/buttons.html5.min.js') }}"></script>

<script type="text/javascript" class="init">
    $(document).ready(function() {
        $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'pdfHtml5'
            ]
        });
        $('#example2').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'pdfHtml5'
            ]
        });
    });
</script>

@section('content')
    <div class="content">
        <div class="container-fluid">

            <form method="get"
                action="{{ route('reportes.categoria', [
                    'ano' => $ano_actual,
                    'mes' => $mes_actual,
                    'tipo' => $tipo,
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

            <div class="row">

                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-header card-header-rose">
                            <h4 class="card-title">Distribución Programado Ejecutado Mensual por Categoria</h4>
                            <p class="card-category">{{ $mes_actual_text }}</p>
                        </div>
                        <div class="card-body table-responsive">
                            <table id="example2" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Detalle</th>
                                        <th>Ejecutado</th>
                                        <th>Programado</th>
                                        <th>Diferencia Numeral</th>
                                        <th>Diferencia Porcentual</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 0; $i < $contador; $i++)
                                        <tr>
                                            <td>{{ $nombre_categoria[$i] }}</td>
                                            <td>{{ number_format($egreso_categoria_mes[$i], 2) }}</td>
                                            <td>{{ number_format($egreso_categoria_programado_mes[$i], 2) }}</td>
                                            <td>{{ number_format($diferencia_egreso_categoria_mes[$i], 2) }}</td>
                                            <td>{{ number_format($porcentaje_egreso_categoria_mes[$i], 2) }}</td>
                                        </tr>
                                    @endfor
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <th>{{ number_format($total_egreso_categoria_mes, 2) }}</th>
                                        <th>{{ number_format($total_egreso_categoria_programado_mes, 2) }}</th>
                                        <th>{{ number_format($total_diferencia_egreso_categoria_mes, 2) }}</th>
                                        <th>{{ number_format($total_porcentaje_egreso_categoria_mes, 2) }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">access_time</i> Actualizado al {{ $fecha_actual }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Distribución Programado Ejecutado Mensual por Categoria</h4>
                            <p class="card-category">{{ $mes_actual_text }}</p>
                        </div>
                        <div class="card-body table-responsive">
                            <canvas id="bar-categoria-mensual" height="400"></canvas>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">access_time</i> Actualizado al {{ $fecha_actual }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title">Relación Ingresos Egresos Anual</h4>
                            <p class="card-category">{{ $mes_actual_text }}</p>
                        </div>
                        <div class="card-body table-responsive">
                            <canvas id="bar-ingresos-egresos-anual" height="300"></canvas>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">access_time</i> Actualizado al {{ $fecha_actual }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('js/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('js/chartjs-plugin-labels.js') }}"></script>

    <script>
        const cDataNombreCategoria = JSON.parse(`<?php echo $data_nombre_categoria; ?>`);
        const cDataEgresoCategoriaMes = JSON.parse(`<?php echo $data_egreso_categoria_mes; ?>`);
        const cDataEgresoCategoriaProgramadoMes = JSON.parse(`<?php echo $data_egreso_categoria_programado_mes; ?>`);

        const cDataTotalIngresoMes = JSON.parse(`<?php echo $data_total_ingreso_mes; ?>`);
        const cDataTotalIngresoProgramadoMes = JSON.parse(`<?php echo $data_total_ingreso_programado_mes; ?>`);
        const cDataTotalEgresoMes = JSON.parse(`<?php echo $data_total_egreso_mes; ?>`);
        const cDataTotalEgresoProgramadoMes = JSON.parse(`<?php echo $data_total_egreso_programado_mes; ?>`);

        new Chart(document.getElementById('bar-categoria-mensual'), {
            type: 'bar',
            data: {
                labels: cDataNombreCategoria,
                datasets: [{
                        label: 'Ejecutado',
                        data: cDataEgresoCategoriaMes,
                        backgroundColor: [
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                        ]
                    },

                    {
                        label: 'Programado',
                        data: cDataEgresoCategoriaProgramadoMes,
                        backgroundColor: [
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                        ]
                    },
                ]
            },
            options: {
                title: {
                    display: true,
                    text: '',
                    position: 'top',
                    fontSize: 16,
                    fontColor: '#111',
                    padding: 20
                },
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        boxWidth: 20,
                        fontColor: '#111',
                        padding: 15
                    }
                },
                tooltips: {
                    enabled: true
                },
                plugins: {
                    labels: {
                        render: 'value'
                    }
                }
            }
        });

        new Chart(document.getElementById('bar-ingresos-egresos-anual'), {
            type: 'bar',
            data: {
                labels: ['ENE',
                    'FEB',
                    'MAR',
                    'ABR',
                    'MAY',
                    'JUN',
                    'JUL',
                    'AGO',
                    'SEP',
                    'OCT',
                    'NOV',
                    'DIC',
                ],
                datasets: [{
                        label: 'Ingreso Ejecutado',
                        data: cDataTotalIngresoMes,
                        backgroundColor: [
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                        ]
                    },
                    {
                        label: 'Ingreso Programado',
                        data: cDataTotalIngresoProgramadoMes,
                        backgroundColor: [
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                        ]
                    },
                    {
                        label: 'Egreso Ejecutado',
                        data: cDataTotalEgresoMes,
                        backgroundColor: [
                            '#c663ff',
                            '#c663ff',
                            '#c663ff',
                            '#c663ff',
                            '#c663ff',
                            '#c663ff',
                            '#c663ff',
                            '#c663ff',
                            '#c663ff',
                            '#c663ff',
                            '#c663ff',
                            '#c663ff',
                        ]
                    },
                    {
                        label: 'Egreso Programado',
                        data: cDataTotalEgresoProgramadoMes,
                        backgroundColor: [
                            '#6dff63',
                            '#6dff63',
                            '#6dff63',
                            '#6dff63',
                            '#6dff63',
                            '#6dff63',
                            '#6dff63',
                            '#6dff63',
                            '#6dff63',
                            '#6dff63',
                            '#6dff63',
                            '#6dff63',
                        ]
                    },
                ]
            },
            options: {
                title: {
                    display: true,
                    text: '',
                    position: 'top',
                    fontSize: 16,
                    fontColor: '#111',
                    padding: 20
                },
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        boxWidth: 20,
                        fontColor: '#111',
                        padding: 15
                    }
                },
                tooltips: {
                    enabled: true
                },
                plugins: {
                    labels: {
                        render: 'value'
                    }
                }
            }
        });
    </script>
@endpush
