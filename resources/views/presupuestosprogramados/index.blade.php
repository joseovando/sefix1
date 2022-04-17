@extends('layouts.app', ['activePage' => 'Ingresos', 'titlePage' => __('Tablero de Ingresos')])

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

    <style type="text/css">
        nav>.nav.nav-tabs {

            border: none;
            color: #fff;
            background: #272e38;
            border-radius: 0;

        }

        nav>div a.nav-item.nav-link,
        nav>div a.nav-item.nav-link.active {
            border: none;
            padding: 18px 25px;
            color: #fff;
            background: #272e38;
            border-radius: 0;
        }

        nav>div a.nav-item.nav-link.active:after {
            content: "";
            position: relative;
            bottom: -60px;
            left: -10%;
            border: 15px solid transparent;
            border-top-color: #e74c3c;
        }

        .tab-content {
            background: #fdfdfd;
            line-height: 25px;
            border: 1px solid #ddd;
            border-top: 5px solid #e74c3c;
            border-bottom: 5px solid #e74c3c;
            padding: 30px 25px;
        }

        nav>div a.nav-item.nav-link:hover,
        nav>div a.nav-item.nav-link:focus {
            border: none;
            background: #e74c3c;
            color: #fff;
            border-radius: 0;
            transition: background 0.20s linear;
        }

    </style>

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

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        window.alert = function() {};
        var defaultCSS = document.getElementById('bootstrap-css');

        function changeCSS(css) {
            if (css) $('head > link').filter(':first').replaceWith('<link rel="stylesheet" href="' + css +
                '" type="text/css" />');
            else $('head > link').filter(':first').replaceWith(defaultCSS);
        }
    </script>

    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 ">
                            <nav>
                                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                                        role="tab" aria-controls="nav-home" aria-selected="true">Ingreso Programado</a>
                                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                                        role="tab" aria-controls="nav-profile" aria-selected="false">Ingreso Ejecutado</a>
                                </div>
                            </nav>
                            <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">

                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                    aria-labelledby="nav-home-tab">

                                    <br>
                                    <div class="row">
                                        <a class="btn btn-primary" href="{{ route('categorias.index', 1) }}"
                                            role="button">
                                            + Nuevo Ingreso Programado
                                        </a>
                                    </div>

                                    <table id="example" class="display" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th>Categoria</th>
                                                <th>Mes</th>
                                                <th>Frecuencia</th>
                                                <th>Sin Caducidad</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($vistaIngresoProgramadoPadres as $vistaIngresoProgramadoPadre)
                                                <tr>
                                                    <td>
                                                        <a class="navbar-brand"
                                                            href="{{ route('presupuestosprogramados.edit', ['id' => $vistaIngresoProgramadoPadre->id_padre, 'menu' => 1]) }}">
                                                            <i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                    </td>
                                                    <td>
                                                        <a class="navbar-brand"
                                                            href="{{ route('presupuestosprogramados.delete', ['id' => $vistaIngresoProgramadoPadre->id_padre, 'menu' => 1]) }}">
                                                            <i class="fa fa-trash" aria-hidden="true"></i></a>
                                                    </td>
                                                    <td>{{ $vistaIngresoProgramadoPadre->categoria_padre }}</td>
                                                    <td>{{ date('Y-m', strtotime($vistaIngresoProgramadoPadre->fecha_promedio)) }}
                                                    </td>
                                                    <td>{{ $vistaIngresoProgramadoPadre->frecuencia }}</td>
                                                    <td>
                                                        @if ($vistaIngresoProgramadoPadre->sin_caducidad === 1)
                                                            Sin Caducidad
                                                        @else
                                                            Con Caducidad
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>

                                <div class="tab-pane fade" id="nav-profile" role="tabpanel"
                                    aria-labelledby="nav-profile-tab">

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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
