@extends('layouts.app', ['activePage' => 'categorias', 'titlePage' => __('Categorias')])

@section('content')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.dataTables.min.css') }}">
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
        });
    </script>

    <div class="content">

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <a class="btn btn-primary" href="{{ route('categorias.create_categoria', $comercial) }}" role="button">
                        + Nueva Categoria
                    </a>
                </div>
                <div class="col-md-3">
                    <a class="btn btn-primary" href="{{ route('categorias.create', $comercial) }}" role="button">
                        + Nueva Subcategoria
                    </a>
                </div>
                <div class="col-md-3"></div>
                <div class="col-md-12"></div>
            </div>

            <br>

            <div class="row">
                <table id="example" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>Tipo</th>
                            <th>Categoria</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vistaCategoriaPadres as $vistaCategoriaPadre)
                            <tr>
                                <td>
                                    <a class="navbar-brand"
                                        href="{{ route('categorias.edit_categoria', ['id' => $vistaCategoriaPadre->id]) }}">
                                        <i class="fa fa-pencil" aria-hidden="true"></i></a>
                                </td>
                                <td>
                                    <a class="navbar-brand"
                                        href="{{ route('categorias.delete_categoria', ['id' => $vistaCategoriaPadre->id]) }}">
                                        <i class="fa fa-trash" aria-hidden="true"></i></a>
                                </td>
                                <td>{{ $vistaCategoriaPadre->tipo_categoria }}</td>
                                <td>{{ $vistaCategoriaPadre->categoria }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>Tipo</th>
                            <th>Categoria</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
