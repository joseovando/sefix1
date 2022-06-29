<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">Categorias</h4>
            </div>
            <div class="card-body table-responsive">

                <table id="example" class="display data-table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Categoria</th>
                            <th class="no-sort"></th>
                            <th class="no-sort"></th>
                            <th>SubCategoria</th>
                            <th class="no-sort"></th>
                            <th class="no-sort"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vistaCategorias as $vistaCategoria)
                            <tr>
                                <td>{{ $vistaCategoria->tipo_categoria }}</td>
                                <td>{{ $vistaCategoria->categoria_padre }}</td>
                                <td width="1%">
                                    @if ($vistaCategoria->plantilla_padre == 1)
                                        @if ($vistaUserRol->rol_name == 'administrator')
                                            <button class="btn btn-warning btn-fab btn-fab-mini" data-toggle="modal"
                                                data-target="#saveModal"
                                                onclick="editarCategoria({{ $vistaCategoria->id_padre }})">
                                                <i class="material-icons">edit</i>
                                            </button>
                                        @endif
                                    @else
                                        @if ($vistaCategoria->user_padre == auth()->id())
                                            <button class="btn btn-warning btn-fab btn-fab-mini" data-toggle="modal"
                                                data-target="#saveModal"
                                                onclick="editarCategoria({{ $vistaCategoria->id_padre }})">
                                                <i class="material-icons">edit</i>
                                            </button>
                                        @endif
                                    @endif
                                </td>
                                <td width="1%">
                                    @if ($vistaCategoria->plantilla_padre == 1)
                                        @if ($vistaUserRol->rol_name == 'administrator')
                                            <button class="btn btn-danger btn-fab btn-fab-mini"
                                                onclick="borrarCategoria({{ $vistaCategoria->id_padre }})">
                                                <i class="material-icons">close</i>
                                            </button>
                                        @endif
                                    @else
                                        @if ($vistaCategoria->user_padre == auth()->id())
                                            <button class="btn btn-danger btn-fab btn-fab-mini"
                                                onclick="borrarCategoria({{ $vistaCategoria->id_padre }})">
                                                <i class="material-icons">close</i>
                                            </button>
                                        @endif
                                    @endif
                                </td>
                                <td>{{ $vistaCategoria->categoria }}</td>
                                <td width="1%">
                                    <button class="btn btn-warning btn-fab btn-fab-mini" data-toggle="modal"
                                        data-target="#saveModal2 onclick="
                                        editarCuenta({{ $vistaCategoria->id_padre }})""
                                        onclick="editarSubCategoria({{ $vistaCategoria->id }})">
                                        <i class="material-icons">edit</i>
                                    </button>
                                </td>
                                <td width="1%">
                                    <button class="btn btn-danger btn-fab btn-fab-mini"
                                        onclick="borrarSubCategoria({{ $vistaCategoria->id }})">
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
            <div class="card-footer">
            </div>
        </div>
    </div>
</div>
