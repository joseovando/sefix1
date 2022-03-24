@extends('layouts.app', ['activePage' => 'Permisos', 'titlePage' => __('Permisos')])

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
            ],
        });
    });
</script>

@section('content')
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                @can('permission_create')
                    <a class="btn btn-primary" href="{{ route('permissions.create') }}" role="button">
                        + Nuevo Permiso
                    </a>
                @endcan
            </div>

            <div class="row justify-content-center">
                <table id="example" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>Permiso</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $permission)
                            <tr>
                                <td>
                                    @can('permission_edit')
                                        <a class="navbar-brand" href="{{ route('permissions.edit', $permission->id) }}">
                                            <i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    @endcan
                                </td>
                                <td>
                                    @can('permission_delete')
                                        <a class="navbar-brand" href="{{ route('permissions.delete', $permission->id) }}">
                                            <i class="fa fa-trash" aria-hidden="true"></i></a>
                                    @endcan
                                </td>
                                <td>{{ $permission->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>Permiso</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
