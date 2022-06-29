<div class="col-lg-12 col-md-12">
    <div class="container-fluid">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalCoeficientes">
            + Nuevo Coeficiente
        </button>
    </div>
    <br>
    <div class="card">
        <div class="card-header card-header-primary">
            <h4 class="card-title">Coeficientes</h4>
            <p class="card-category"></p>
        </div>
        {{-- <div class="card-body table-responsive"> --}}
        <div class="card-body table-responsive">
            <div class="">
                <table id="table_coeficientes" class="display data-table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Tipo Coeficiente</th>
                            <th>Coeficiente</th>
                            <th>Valor de cálculo</th>
                            <th>Valor determinado por el Sistema</th>
                            <th>Valor Personalizado</th>
                            <th>Información Adicional</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vistaBrujulaCoeficientes as $brujulaInversion)
                            <tr>
                                <td>{{ $brujulaInversion->tipo_categoria }}</td>
                                <td>{{ $brujulaInversion->categoria }}</td>

                                @if ($brujulaInversion->id_valor_calculo == 1)
                                    <td>Personalizado</td>
                                @else
                                    <td>Determinado por el Sistema</td>
                                @endif

                                <td>{{ $brujulaInversion->valor_sistema }}</td>
                                <td>{{ $brujulaInversion->valor_usuario }}</td>
                                <td>{{ $brujulaInversion->informacion_adicional }}</td>

                                <td width="1%">
                                    <button class="btn btn-warning btn-fab btn-fab-mini" data-toggle="modal"
                                        data-target="#ModalCoeficientes"
                                        onclick="editarCoeficientes({{ $brujulaInversion->id }})">
                                        <i class="material-icons">edit</i>
                                    </button>
                                </td>
                                <td width="1%">
                                    <button class="btn btn-danger btn-fab btn-fab-mini"
                                        onclick="borrarCoeficientes({{ $brujulaInversion->id }})">
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
