@extends('layouts.app', ['activePage' => 'categorias', 'titlePage' => __('Categorias')])

@section('content')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>

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
                <a class="btn btn-primary" href="{{ route('categorias.create_categoria') }}" role="button">
                    + Nueva Categoria
                </a>
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