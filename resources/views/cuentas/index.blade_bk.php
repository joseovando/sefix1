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


            <div class="row">
                @can('role_create')
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        + Nueva {{ $titulo }}
                    </button>
                @endcan
            </div>


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
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vistaCuentas as $vistaCuenta)
                                        <tr>
                                            <td>{{ $vistaCuenta->fecha }}</td>
                                            <td>{{ $vistaCuenta->detalle }}</td>
                                            <td>{{ $vistaCuenta->monto }}</td>
                                            <td>
                                                <button class="btn btn-warning btn-fab btn-fab-mini" data-toggle="modal"
                                                    data-target="#exampleModal"
                                                    onclick="editarCuenta({{ $vistaCuenta->id }})">
                                                    <i class="material-icons">edit</i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
{{--                                     @for ($i = 0; $i < $contador; $i++)
                                        <tr>
                                            <th colspan="2">Total {{ $titulo }} {{ $label_cuenta[$i] }}</th>
                                            <th>{{ $total_cuenta[$i] }}</th>
                                            <th></th>
                                        </tr>
                                    @endfor --}}
                                    <tr>
                                        <th colspan="2">Total {{ $titulo }}</th>
                                        <th>{{ $total }}</th>
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
                                        <input type="hidden" name="tipo_cuenta" id="tipo_cuenta"
                                            value="{{ $id }}">
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
                                    <div class="form-group{{ $errors->has('monto') ? ' has-danger' : '' }}">
                                        <label for="exampleFormControlTextarea1">Monto</label>
                                        <input class="form-control{{ $errors->has('monto') ? ' is-invalid' : '' }}"
                                            name=monto" id="monto" type="text" style="font-family: FontAwesome"
                                            placeholder="&#xf0d6; Monto" value=""
                                            onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"
                                            required />
                                        <span id="result"></span>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary btn-submit"
                                        id="guardarCuenta">Guardar</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Save -->

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
                        type: 'success',
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

            function cargarTabla() {
                $.ajax({
                    url: "{{ route('cuentas.getVistaCuentas', $id) }}",
                    method: 'GET',
                    success: function(r) {
                        let data = r;
                        let htmlCode = ``;
                        let htmltfoot = ``;

                        for (var i = 0; i < data.vistaCuentas.length; ++i) {
                            botonEditar =
                                '<button class="btn btn-warning btn-fab btn-fab-mini" data-toggle="modal" data-target="#exampleModal" onclick="editarCuenta(' +
                                data.vistaCuentas[i].id +
                                ')"><i class="material-icons">edit</i></button>';

                            htmlCode += '<tr><td>' +
                                data.vistaCuentas[i].fecha + '</td><td>' +
                                data.vistaCuentas[i].detalle + '</td><td>' +
                                data.vistaCuentas[i].monto + '</td><td>' +
                                botonEditar + '</td></tr>';
                        };
                        $('#tabla-cuentas tbody').html(htmlCode);

/*                         for (var i = 0; i < data.contador; ++i) {
                            htmltfoot += '<tr><th colspan="2">' +
                                data.label_cuenta[i] + '</th><th>' +
                                data.total_cuenta[i] + '</th><th></th></tr>';
                        }; */

                        htmltfoot += '<th colspan="2">Total ' + data.titulo + '</th>';
                        htmltfoot += '<th>' + data.total + '</th><th></th></tr>';
                        $('#tabla-cuentas tfoot').html(htmltfoot);
                    }
                });
            }
        });
    </script>
@endpush
