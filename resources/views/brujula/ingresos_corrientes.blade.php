<div class="col-lg-12 col-md-12">
    <div class="container-fluid">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalIngresosCorrientes">
            + Nuevo Ingreso Corriente
        </button>
    </div>
    <br>
    <div class="card">
        <div class="card-header card-header-primary">
            <h4 class="card-title">Ingresos Corrientes</h4>
            <p class="card-category"></p>
        </div>
        {{-- <div class="card-body table-responsive"> --}}
        <div class="card-body table-responsive">
            <div class="">
                <table id="table_ingresos_corrientes" class="display data-table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Categoría</th>
                            <th>Cuenta</th>
                            <th>Año Inicio</th>
                            <th>Año Culminación</th>
                            <th>Tipo de Monto</th>
                            <th>Monto</th>
                            <th>Porcentaje Coeficiente de Crecimiento</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vistaBrujulaIngresosCorrientes as $vistaBrujulaCorriente)
                            <tr>
                                <td>{{ $vistaBrujulaCorriente->categoria }}</td>
                                <td>{{ $vistaBrujulaCorriente->cuenta }}</td>
                                <td>{{ $vistaBrujulaCorriente->ano_inicio }}</td>
                                <td>{{ $vistaBrujulaCorriente->ano_culminacion }}</td>
                                @if ($vistaBrujulaCorriente->id_tipo_monto == 1)
                                    <td>Valor Futuro</td>
                                @else
                                    <td>Valor Actual</td>
                                @endif
                                <td>{{ $vistaBrujulaCorriente->monto }}</td>
                                <td>{{ $vistaBrujulaCorriente->coeficiente_crecimiento }}</td>
                                <td width="1%">
                                    <button class="btn btn-warning btn-fab btn-fab-mini" data-toggle="modal"
                                        data-target="#ModalIngresosCorrientes"
                                        onclick="editarCorriente({{ $vistaBrujulaCorriente->id }})">
                                        <i class="material-icons">edit</i>
                                    </button>
                                </td>
                                <td width="1%">
                                    <button class="btn btn-danger btn-fab btn-fab-mini"
                                        onclick="borrarCorriente({{ $vistaBrujulaCorriente->id }})">
                                        <i class="material-icons">close</i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="card-footer">
        </div>
    </div>
</div>
