@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

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

            <div class="row">

                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header card-header-warning">
                            <h4 class="card-title">Relación Ingresos Egresos Ejecutado</h4>
                            <p class="card-category">{{ $mes_actual_text }}</p>
                        </div>
                        <div class="card-body table-responsive">
                            <canvas id="bar-ingresos-egresos-mes" height="308"></canvas>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">access_time</i> Actualizado al {{ $fecha_actual }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header card-header-warning">
                            <h4 class="card-title">Relación Ingresos Egresos Mensual</h4>
                            <p class="card-category">{{ $mes_actual_text }}</p>
                        </div>
                        <div class="card-body table-responsive">

                            @if ($navegador_mobile == 1)
                            @else
                                <br><br>
                            @endif

                            <table class="table table-hover">
                                <thead class="text-warning">
                                    <th>Detalle</th>
                                    <th>Ejecutado</th>
                                    <th>Programado</th>
                                    <th>Diferencia Numeral</th>
                                    <th>Diferencia Porcentual</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Ingreso</td>
                                        <td>{{ number_format($total_ingreso_bar, 2) }}</td>
                                        <td>{{ number_format($total_ingreso_programado_bar, 2) }}</td>
                                        <td>{{ number_format($diferencia_ingreso_bar, 2) }}</td>
                                        <td>{{ number_format($porcentaje_ingreso_bar, 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Egreso</td>
                                        <td>{{ number_format($total_egreso_bar, 2) }}</td>
                                        <td>{{ number_format($total_egreso_programado_bar, 2) }}</td>
                                        <td>{{ number_format($diferencia_egreso_bar, 2) }}</td>
                                        <td>{{ number_format($porcentaje_egreso_bar, 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Saldo</td>
                                        <td>{{ number_format($saldo_ejecutado_bar, 2) }}</td>
                                        <td>{{ number_format($saldo_programado_bar, 2) }}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>

                            @if ($navegador_mobile == 1)
                            @else
                                <br><br>
                            @endif

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

            <div class="row">

                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header card-header-rose">
                            <h4 class="card-title">Distribución del Egreso Mensual</h4>
                            <p class="card-category">{{ $mes_actual_text }}</p>
                        </div>
                        <div class="card-body table-responsive">
                            @if ($navegador_mobile == 1)
                                <div id="piechart_3d"></div>
                            @else
                                <div id="piechart_3d" style="height: 600px;"></div>
                            @endif
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">access_time</i> Actualizado al {{ $fecha_actual }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header card-header-rose">
                            <h4 class="card-title">Distribución del Egreso Programado Ejecutado</h4>
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

                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Ingresos Corrientes</h4>
                            <p class="card-category">{{ $mes_actual_text }}</p>
                        </div>
                        <div class="card-body table-responsive">
                            <canvas id="bar-ingreso-corriente" height="300"></canvas>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">access_time</i> Actualizado al {{ $fecha_actual }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Inversiones Tasa Fija Retorno</h4>
                            <p class="card-category">{{ $mes_actual_text }}</p>
                        </div>
                        <div class="card-body table-responsive">
                            <canvas id="bar-ingreso-tasa-fija" height="300"></canvas>
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

                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Inversiones Retorno Fluctuante</h4>
                            <p class="card-category">{{ $mes_actual_text }}</p>
                        </div>
                        <div class="card-body table-responsive">
                            <canvas id="bar-ingreso-retorno" height="300"></canvas>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">access_time</i> Actualizado al {{ $fecha_actual }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Ingreso Total Anual</h4>
                            <p class="card-category">{{ $mes_actual_text }}</p>
                        </div>
                        <div class="card-body table-responsive">
                            <canvas id="bar-ingreso-total" height="300"></canvas>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">access_time</i> Actualizado al {{ $fecha_actual }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-warning card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">content_copy</i>
                            </div>
                            <p class="card-category">Used Space</p>
                            <h3 class="card-title">49/50
                                <small>GB</small>
                            </h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons text-danger">warning</i>
                                <a href="#pablo">Get More Space...</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-success card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">store</i>
                            </div>
                            <p class="card-category">Revenue</p>
                            <h3 class="card-title">$34,245</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">date_range</i> Last 24 Hours
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-danger card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">info_outline</i>
                            </div>
                            <p class="card-category">Fixed Issues</p>
                            <h3 class="card-title">75</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">local_offer</i> Tracked from Github
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-info card-header-icon">
                            <div class="card-icon">
                                <i class="fa fa-twitter"></i>
                            </div>
                            <p class="card-category">Followers</p>
                            <h3 class="card-title">+245</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">update</i> Just Updated
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            {{-- <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header card-header-tabs card-header-primary">
                            <div class="nav-tabs-navigation">
                                <div class="nav-tabs-wrapper">
                                    <span class="nav-tabs-title">Tasks:</span>
                                    <ul class="nav nav-tabs" data-tabs="tabs">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#profile" data-toggle="tab">
                                                <i class="material-icons">bug_report</i> Bugs
                                                <div class="ripple-container"></div>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#messages" data-toggle="tab">
                                                <i class="material-icons">code</i> Website
                                                <div class="ripple-container"></div>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#settings" data-toggle="tab">
                                                <i class="material-icons">cloud</i> Server
                                                <div class="ripple-container"></div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="profile">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="checkbox" value=""
                                                                checked>
                                                            <span class="form-check-sign">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>Sign contract for "What are conference organizers afraid of?"</td>
                                                <td class="td-actions text-right">
                                                    <button type="button" rel="tooltip" title="Edit Task"
                                                        class="btn btn-primary btn-link btn-sm">
                                                        <i class="material-icons">edit</i>
                                                    </button>
                                                    <button type="button" rel="tooltip" title="Remove"
                                                        class="btn btn-danger btn-link btn-sm">
                                                        <i class="material-icons">close</i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="checkbox" value="">
                                                            <span class="form-check-sign">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>Lines From Great Russian Literature? Or E-mails From My Boss?</td>
                                                <td class="td-actions text-right">
                                                    <button type="button" rel="tooltip" title="Edit Task"
                                                        class="btn btn-primary btn-link btn-sm">
                                                        <i class="material-icons">edit</i>
                                                    </button>
                                                    <button type="button" rel="tooltip" title="Remove"
                                                        class="btn btn-danger btn-link btn-sm">
                                                        <i class="material-icons">close</i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="checkbox" value="">
                                                            <span class="form-check-sign">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>Flooded: One year later, assessing what was lost and what was found when
                                                    a ravaging rain swept
                                                    through metro Detroit
                                                </td>
                                                <td class="td-actions text-right">
                                                    <button type="button" rel="tooltip" title="Edit Task"
                                                        class="btn btn-primary btn-link btn-sm">
                                                        <i class="material-icons">edit</i>
                                                    </button>
                                                    <button type="button" rel="tooltip" title="Remove"
                                                        class="btn btn-danger btn-link btn-sm">
                                                        <i class="material-icons">close</i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="checkbox" value=""
                                                                checked>
                                                            <span class="form-check-sign">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>Create 4 Invisible User Experiences you Never Knew About</td>
                                                <td class="td-actions text-right">
                                                    <button type="button" rel="tooltip" title="Edit Task"
                                                        class="btn btn-primary btn-link btn-sm">
                                                        <i class="material-icons">edit</i>
                                                    </button>
                                                    <button type="button" rel="tooltip" title="Remove"
                                                        class="btn btn-danger btn-link btn-sm">
                                                        <i class="material-icons">close</i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="messages">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="checkbox" value=""
                                                                checked>
                                                            <span class="form-check-sign">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>Flooded: One year later, assessing what was lost and what was found when
                                                    a ravaging rain swept
                                                    through metro Detroit
                                                </td>
                                                <td class="td-actions text-right">
                                                    <button type="button" rel="tooltip" title="Edit Task"
                                                        class="btn btn-primary btn-link btn-sm">
                                                        <i class="material-icons">edit</i>
                                                    </button>
                                                    <button type="button" rel="tooltip" title="Remove"
                                                        class="btn btn-danger btn-link btn-sm">
                                                        <i class="material-icons">close</i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="checkbox" value="">
                                                            <span class="form-check-sign">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>Sign contract for "What are conference organizers afraid of?"</td>
                                                <td class="td-actions text-right">
                                                    <button type="button" rel="tooltip" title="Edit Task"
                                                        class="btn btn-primary btn-link btn-sm">
                                                        <i class="material-icons">edit</i>
                                                    </button>
                                                    <button type="button" rel="tooltip" title="Remove"
                                                        class="btn btn-danger btn-link btn-sm">
                                                        <i class="material-icons">close</i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="settings">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="checkbox" value="">
                                                            <span class="form-check-sign">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>Lines From Great Russian Literature? Or E-mails From My Boss?</td>
                                                <td class="td-actions text-right">
                                                    <button type="button" rel="tooltip" title="Edit Task"
                                                        class="btn btn-primary btn-link btn-sm">
                                                        <i class="material-icons">edit</i>
                                                    </button>
                                                    <button type="button" rel="tooltip" title="Remove"
                                                        class="btn btn-danger btn-link btn-sm">
                                                        <i class="material-icons">close</i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="checkbox" value=""
                                                                checked>
                                                            <span class="form-check-sign">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>Flooded: One year later, assessing what was lost and what was found when
                                                    a ravaging rain swept
                                                    through metro Detroit
                                                </td>
                                                <td class="td-actions text-right">
                                                    <button type="button" rel="tooltip" title="Edit Task"
                                                        class="btn btn-primary btn-link btn-sm">
                                                        <i class="material-icons">edit</i>
                                                    </button>
                                                    <button type="button" rel="tooltip" title="Remove"
                                                        class="btn btn-danger btn-link btn-sm">
                                                        <i class="material-icons">close</i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="checkbox" value=""
                                                                checked>
                                                            <span class="form-check-sign">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>Sign contract for "What are conference organizers afraid of?"</td>
                                                <td class="td-actions text-right">
                                                    <button type="button" rel="tooltip" title="Edit Task"
                                                        class="btn btn-primary btn-link btn-sm">
                                                        <i class="material-icons">edit</i>
                                                    </button>
                                                    <button type="button" rel="tooltip" title="Remove"
                                                        class="btn btn-danger btn-link btn-sm">
                                                        <i class="material-icons">close</i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header card-header-warning">
                            <h4 class="card-title">Employees Stats</h4>
                            <p class="card-category">New employees on 15th September, 2016</p>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-hover">
                                <thead class="text-warning">
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Salary</th>
                                    <th>Country</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Dakota Rice</td>
                                        <td>$36,738</td>
                                        <td>Niger</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Minerva Hooper</td>
                                        <td>$23,789</td>
                                        <td>Curaçao</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Sage Rodriguez</td>
                                        <td>$56,142</td>
                                        <td>Netherlands</td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Philip Chaney</td>
                                        <td>$38,735</td>
                                        <td>Korea, South</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> --}}

        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('js/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('js/chartjs-plugin-labels.js') }}"></script>

    <script>
        const cDataIngresosEgresosMesLabels = JSON.parse(`<?php echo $data_ingresos_egresos_mes_labels; ?>`);
        const cDataIngresosEgresosMesValues = JSON.parse(`<?php echo $data_ingresos_egresos_mes_values; ?>`);

        const cDataTotalIngresoMes = JSON.parse(`<?php echo $data_total_ingreso_mes; ?>`);
        const cDataTotalIngresoProgramadoMes = JSON.parse(`<?php echo $data_total_ingreso_programado_mes; ?>`);
        const cDataTotalEgresoMes = JSON.parse(`<?php echo $data_total_egreso_mes; ?>`);
        const cDataTotalEgresoProgramadoMes = JSON.parse(`<?php echo $data_total_egreso_programado_mes; ?>`);

        const cDataIngresoCorriente = JSON.parse(`<?php echo $data_ingreso_categoria_anual_corriente; ?>`);
        const cDataIngresoProgramadoCorriente = JSON.parse(`<?php echo $data_ingreso_programado_categoria_anual_corriente; ?>`);
        const cDataIngresoTasaFija = JSON.parse(`<?php echo $data_ingreso_categoria_anual_tasa_fija; ?>`);
        const cDataIngresoProgramadoTasaFija = JSON.parse(`<?php echo $data_ingreso_programado_categoria_anual_tasa_fija; ?>`);
        const cDataIngresoRetorno = JSON.parse(`<?php echo $data_ingreso_categoria_anual_retorno; ?>`);
        const cDataIngresoProgramadoRetorno = JSON.parse(`<?php echo $data_ingreso_programado_categoria_anual_retorno; ?>`);

        $(document).ready(function() {

            new Chart(document.getElementById('bar-ingresos-egresos-mes'), {
                type: 'bar',
                data: {
                    labels: cDataIngresosEgresosMesLabels,
                    datasets: [{
                        label: '',
                        data: cDataIngresosEgresosMesValues,
                        backgroundColor: [
                            '#FF6384',
                            '#36A2EB',
                            '#FFCE56'
                        ]
                    }]
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
                            render: 'value',
                            position: 'outside'
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

            new Chart(document.getElementById('bar-ingreso-corriente'), {
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
                            data: cDataIngresoCorriente,
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
                            data: cDataIngresoProgramadoCorriente,
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

            new Chart(document.getElementById('bar-ingreso-tasa-fija'), {
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
                            data: cDataIngresoTasaFija,
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
                            data: cDataIngresoProgramadoTasaFija,
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

            new Chart(document.getElementById('bar-ingreso-retorno'), {
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
                            data: cDataIngresoRetorno,
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
                            data: cDataIngresoProgramadoRetorno,
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

            new Chart(document.getElementById('bar-ingreso-total'), {
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
        });
    </script>

    <script type="text/javascript" src="{{ asset('js/loader.js') }}"></script>
    <script type="text/javascript">
        var cDataIngresosEgresosMesLabel = JSON.parse(`<?php echo $data_egreso_categoria_label; ?>`);
        var cDataIngresosEgresosMesData = JSON.parse(`<?php echo $data_egreso_categoria_data; ?>`);

        google.charts.load("current", {
            packages: ["corechart"]
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var dataArray = [];
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Name');
            data.addColumn('number', 'Quantity');

            for (var i = 0; i < cDataIngresosEgresosMesLabel.length; i++) {
                dataArray.push([cDataIngresosEgresosMesLabel[i], cDataIngresosEgresosMesData[i]]);
            }

            data.addRows(dataArray);

            var options = {
                is3D: true,
                legend: {
                    position: 'bottom',
                },
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
            chart.draw(data, options);
        }
    </script>
@endpush
