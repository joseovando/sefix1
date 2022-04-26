@extends('layouts.app', ['activePage' => 'cuentas', 'titlePage' => __('Cuentas')])

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

    function cargarTabla() {
        $.ajax({
            url: "{{ route('cuentas.getVistaCuentas', [
                'id' => $id,
                'mes' => $mes_actual,
                'ano' => $ano_actual,
            ]) }}",
            method: 'GET',
            success: function(r) {
                let data = r;
                let htmlCode = ``;
                let htmltfoot = ``;

                for (var i = 0; i < data.vistaCuentas.length; ++i) {
                    btnEditar =
                        '<button class="btn btn-warning btn-fab btn-fab-mini" data-toggle="modal" data-target="#exampleModal" onclick="editarCuenta(' +
                        data.vistaCuentas[i].id +
                        ')"><i class="material-icons">edit</i></button>';

                    btnBorrar =
                        '<button class="btn btn-danger btn-fab btn-fab-mini" onclick="botonBorrar(' +
                        data.vistaCuentas[i].id +
                        ')"><i class="material-icons">close</i></button>';

                    htmlCode += '<tr><td>' +
                        data.vistaCuentas[i].fecha + '</td><td>' +
                        data.vistaCuentas[i].detalle + '</td><td>' +
                        data.vistaCuentas[i].monto + '</td><td width="1%">' +
                        btnEditar + '</td><td width="1%">' + btnBorrar + '</td></tr>';
                };

                $('#tabla-cuentas tbody').html(htmlCode);
                htmltfoot += '<th colspan="2">Total ' + data.titulo + '</th>';
                htmltfoot += '<th>' + data.total + '</th><th></th></tr>';
                $('#tabla-cuentas tfoot').html(htmltfoot);
            }
        });
    }

    function editarCuenta(id) {
        var base_path = '{{ url('/') }}';
        $.ajax({
            url: base_path + "/cuentas/" + id + "/edit",
            method: 'GET',
            success: function(eCuenta) {
                let dataEditar = eCuenta;
                document.getElementById("id_cuenta").value = dataEditar.vistaCuentas[0].id;
                document.getElementById("date").value = dataEditar.vistaCuentas[0].fecha;
                document.getElementById("detalle").value = dataEditar.vistaCuentas[0].detalle;
                document.getElementById("monto").value = dataEditar.vistaCuentas[0].monto;
            }
        });
    }

    function borrarCuenta(id) {
        var base_path = '{{ url('/') }}';
        $.ajax({
            url: base_path + "/cuentas/" + id + "/delete",
            method: 'GET',
            success: function(data) {
                cargarTabla();
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Registro Eliminado Correctamente, Información Actualizada',
                    showConfirmButton: false,
                    timer: 2000
                })
            }
        });
    }

    function botonBorrar(id) {
        Swal.fire({
            title: '¿Esta seguro de eliminar el registro?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Si',
            denyButtonText: `No`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                borrarCuenta(id);
            } else if (result.isDenied) {}
        })
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
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                + Nueva {{ $titulo }}
            </button>
        </div>

        {{-- Cambiar Fecha --}}
        <form method="get"
            action="{{ route('cuentas.index', [
                'id' => $id,
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
                        <h4 class="card-title">{{ $titulo }}</h4>
                    </div>
                    <div class="card-body table-responsive">

                        <table id="tabla-cuentas" class="display data-table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Detalle</th>
                                    <th>Monto</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vistaCuentas as $vistaCuenta)
                                    <tr>
                                        <td>{{ $vistaCuenta->fecha }}</td>
                                        <td>{{ $vistaCuenta->detalle }}</td>
                                        <td>{{ $vistaCuenta->monto }}</td>
                                        <td width="1%">
                                            <button class="btn btn-warning btn-fab btn-fab-mini" data-toggle="modal"
                                                data-target="#exampleModal"
                                                onclick="editarCuenta({{ $vistaCuenta->id }})">
                                                <i class="material-icons">edit</i>
                                            </button>
                                        </td>
                                        <td width="1%">
                                            <button class="btn btn-danger btn-fab btn-fab-mini"
                                                onclick="botonBorrar({{ $vistaCuenta->id }})">
                                                <i class="material-icons">close</i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="2">Total {{ $titulo }}</th>
                                    <th>{{ $total }}</th>
                                    <th></th>
                                    <th></th>
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

        <!-- Modal Save -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Nueva {{ $titulo }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="alert alert-success alert-block" style="display: none;">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong class="success-msg"></strong>
                        </div>
                    </div>
                    <form>
                        @csrf
                        <div class="modal-body">

                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Fecha</label>
                                    <input id="date" width="276" name="date" required />
                                    <input type="hidden" name="id_cuenta" id="id_cuenta">
                                    <input type="hidden" name="tipo_cuenta" id="tipo_cuenta" value="{{ $id }}">
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
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Detalle</label>
                                    <textarea class="form-control" name="detalle" id="detalle" rows="2" required></textarea>
                                </div>
                            </div>

                            <div class="col-sm">

                                @if ($navegador_mobile == 1)
                                    <div class="form-group{{ $errors->has('monto') ? ' has-danger' : '' }}">
                                        <label for="exampleFormControlTextarea1">Monto</label>
                                        <input class="form-control{{ $errors->has('monto') ? ' is-invalid' : '' }}"
                                            name=monto" id="monto" type="number" style="font-family: FontAwesome"
                                            placeholder="&#xf0d6; Monto" value="" required />
                                        <span id="result"></span>
                                    </div>
                                @else
                                    <div class="form-group{{ $errors->has('monto') ? ' has-danger' : '' }}">
                                        <label for="exampleFormControlTextarea1">Monto</label>
                                        <input class="form-control{{ $errors->has('monto') ? ' is-invalid' : '' }}"
                                            name=monto" id="monto" type="text" style="font-family: FontAwesome"
                                            placeholder="&#xf0d6; Monto" value=""
                                            onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"
                                            required />
                                        <span id="result"></span>
                                    </div>
                                @endif


                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary btn-submit" id="guardarCuenta">Guardar</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal Save -->

    </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#guardarCuenta').click(function(e) {
                e.preventDefault();

                var _token = $("input[name='_token']").val();
                var id_cuenta = $("#id_cuenta").val();
                var tipo_cuenta = $("#tipo_cuenta").val();
                var date = $("#date").val();
                var tipo_time = $("#tipo_time").val();
                var detalle = $("#detalle").val();
                var monto = $("#monto").val();

                $.ajax({
                    url: "{{ route('cuentas.store') }}",
                    type: 'POST',
                    data: {
                        _token: _token,
                        id_cuenta: id_cuenta,
                        tipo_cuenta: tipo_cuenta,
                        date: date,
                        tipo_time: tipo_time,
                        detalle: detalle,
                        monto: monto
                    },
                    success: function(data) {
                        printMsg(data);
                        cargarTabla();
                    }
                });
            });

            function printMsg(msg) {
                if ($.isEmptyObject(msg.error)) {
                    console.log(msg.success);
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Registro Guardado Correctamente, Información Actualizada',
                        showConfirmButton: false,
                        timer: 2000
                    })

                } else {
                    $.each(msg.error, function(key, value) {
                        $('.' + key + '_err').text(value);
                    });
                }
            }

        });
    </script>
@endpush
