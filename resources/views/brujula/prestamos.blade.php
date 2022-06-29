<div class="col-lg-12 col-md-12">
    <div class="container-fluid">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalPrestamos">
            + Nuevo Préstamo
        </button>
    </div>
    <br>
    <div class="card">
        <div class="card-header card-header-primary">
            <h4 class="card-title">Préstamos</h4>
            <p class="card-category"></p>
        </div>
        {{-- <div class="card-body table-responsive"> --}}
        <div class="card-body table-responsive">
            <div class="">
                <table id="table_prestamos" class="display data-table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Cuenta</th>
                            <th>Año Inicio</th>
                            <th>Año Culminación</th>
                            <th>Tipo de Capital</th>
                            <th>Capital</th>
                            <th>Porcentaje de Interés Anual</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($brujulaPrestamos as $brujulaInversion)
                            <tr>
                                <td>{{ $brujulaInversion->cuenta }}</td>
                                <td>{{ $brujulaInversion->ano_inicio }}</td>
                                <td>{{ $brujulaInversion->ano_culminacion }}</td>

                                @if ($brujulaInversion->id_tipo_capital == 1)
                                    <td>Valor Futuro</td>
                                @else
                                    <td>Valor Actual</td>
                                @endif

                                <td>{{ $brujulaInversion->capital }}</td>
                                <td>{{ $brujulaInversion->porcentaje_interes_anual }}</td>

                                <td width="1%">
                                    <button class="btn btn-warning btn-fab btn-fab-mini" data-toggle="modal"
                                        data-target="#ModalPrestamos"
                                        onclick="editarInversiones({{ $brujulaInversion->id }})">
                                        <i class="material-icons">edit</i>
                                    </button>
                                </td>
                                <td width="1%">
                                    <button class="btn btn-danger btn-fab btn-fab-mini"
                                        onclick="borrarInversiones({{ $brujulaInversion->id }})">
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
