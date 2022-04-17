@extends('layouts.app', ['activePage' => 'Ingresos', 'titlePage' => __('Tablero de Egresos')])

@section('content')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.dataTables.min.css') }}">
    <script type="text/javascript" language="javascript" src="{{ asset('js/jquery-3.5.1.js') }}"></script>
    <script type="text/javascript" language="javascript"
        src="{{ asset('js/jquery.dataTables.min.js') }}"></script>

    <script type="text/javascript" language="javascript"
        src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
    <script type="text/javascript" language="javascript"
        src="{{ asset('js/jszip.min.js') }}"></script>
    <script type="text/javascript" language="javascript"
        src="{{ asset('js/pdfmake.min.js') }}"></script>
    <script type="text/javascript" language="javascript"
        src="{{ asset('js/vfs_fonts.js') }}"></script>
    <script type="text/javascript" language="javascript"
        src="{{ asset('js/buttons.html5.min.js') }}"></script>

    <script type="text/javascript" class="init">
        $(document).ready(function() {
            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'pdfHtml5'
                ]
            });
        });
    </script>

    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <a class="navbar-brand" href="#"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Nuevo Egreso
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('categorias.index', 3) }}">Egreso
                                        Programado</a>
                                    <a class="dropdown-item" href="{{ route('categorias.index', 4) }}">Egreso
                                        Ejecutado</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>

            <div class="row">
                <table id="example" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>Fecha</th>
                            <th>Categoria</th>
                            <th>Programado</th>
                            <th>Ejecutado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vistaEgresos as $vistaEgreso)
                            <tr>
                                <td>
                                    <a class="navbar-brand"
                                        href="{{ route('presupuestosejecutados.edit', ['id' => $vistaEgreso->id, 'menu' => 1]) }}">
                                        <i class="fa fa-pencil" aria-hidden="true"></i></a>
                                </td>
                                <td>
                                    <a class="navbar-brand"
                                        href="{{ route('presupuestosejecutados.delete', ['id' => $vistaEgreso->id, 'menu' => 1]) }}">
                                        <i class="fa fa-trash" aria-hidden="true"></i></a>
                                </td>
                                <td>{{ $vistaEgreso->fecha }}</td>
                                <td>{{ $vistaEgreso->categoria_padre }} / {{ $vistaEgreso->categoria }}</td>
                                <td>{{ $vistaEgreso->monto_programado }}</td>
                                <td>{{ $vistaEgreso->monto_ejecutado }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>Fecha</th>
                            <th>Categoria</th>
                            <th>Programado</th>
                            <th>Ejecutado</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
