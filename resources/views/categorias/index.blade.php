@extends('layouts.app', ['activePage' => 'categorias', 'titlePage' => __('Categorias')])
@section('content')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/autoComplete.min.css') }}">

    <style>
        .scroll {
            margin-left: 5px;
            max-height: 400px;
            overflow-y: auto;
        }

        .margin {
            margin-left: 5px;
            margin-right: 5px;
        }

    </style>

    <div class="content">
        <div class="container-fluid">

            {{-- Create Buttons --}}
            <div class="row">
                <div class="col-md-3">
                    <button class="btn btn-info btn-round btn-block" data-toggle="modal" data-target="#saveModal">
                        <i class="fa fa-plus-square" aria-hidden="true"></i>&nbsp; Nueva Categoria
                    </button>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-info btn-round btn-block" data-toggle="modal" data-target="#configModal">
                        <i class="fa fa-cog" aria-hidden="true"></i>&nbsp; Categorias Favoritas
                    </button>
                </div>
            </div>
            {{-- Create Buttons --}}

            <br>

            {{-- Buscador de Categorias --}}
            <form method="post" action="{{ route('categorias.search') }}" autocomplete="off" class="form-horizontal">
                @csrf
                <div class="row">
                    <div class="col-md-5">
                        <div class="autoComplete_wrapper">
                            <input id="autoComplete" type="search" dir="ltr" spellcheck=false autocorrect="off"
                                autocomplete="off" autocapitalize="off" name="search">
                            <input type="hidden" name="menu" value="{{ $menu }}">
                            <input type="hidden" name="ano_actual" value="{{ $ano_actual }}">
                            <input type="hidden" name="mes_actual" value="{{ $mes_actual }}">
                            <input type="hidden" name="estado" value="{{ $estado }}">
                            <input type="hidden" name="fecha_actual" value="{{ $fecha_actual }}">
                            <input type="hidden" name="comercial" value="{{ $comercial }}">
                        </div>
                        <script src="{{ asset('js/autoComplete.min.js') }}"></script>
                        <script>
                            var data = @json($json);
                            const autoCompleteJS = new autoComplete({
                                selector: "#autoComplete",
                                placeHolder: "Busque Categoria...",
                                data: {
                                    src: data,
                                    cache: true,
                                },
                                resultsList: {
                                    element: (list, data) => {
                                        if (!data.results.length) {
                                            // Create "No Results" message element
                                            const message = document.createElement("div");
                                            // Add class to the created element
                                            message.setAttribute("class", "no_result");
                                            // Add message text content
                                            message.innerHTML = `<span>Found No Results for "${data.query}"</span>`;
                                            // Append message element to the results list
                                            list.prepend(message);
                                        }
                                    },
                                    noResults: true,
                                },
                                diacritics: true,
                                resultItem: {
                                    highlight: true
                                },

                                events: {
                                    input: {
                                        selection: (event) => {
                                            const selection = event.detail.selection.value;
                                            autoCompleteJS.input.value = selection;
                                        }
                                    }
                                }
                            });
                        </script>
                    </div>
                    <div class="col-md-3">
                        <button type="success" class="btn btn-info">Ir</button>
                    </div>
                </div>
            </form>
            {{-- Buscador de Categorias --}}

            <br>

            {{-- List Categoria Buttons --}}
            <div class="row" id="div_lista_categorias">
                @foreach ($vistaCategoriaFavoritas as $vistaCategoriaFavorita)
                    @switch($menu)
                        @case(1)
                            <div class="col-md-3">
                                <a href="{{ route('presupuestosprogramados.create', [
                                    'id' => $vistaCategoriaFavorita->id,
                                    'menu' => $menu,
                                    'ano' => $ano_actual,
                                    'mes' => $mes_actual,
                                    'estado' => $estado,
                                    'comercial' => $comercial,
                                ]) }}"
                                    class="btn {{ $vistaCategoriaFavorita->fondo }} btn-lg btn-block" role="button">
                                    <i class="{{ $vistaCategoriaFavorita->icono }}"></i><br><br>
                                    {{ substr($vistaCategoriaFavorita->categoria, 0, 25) }}
                                </a>
                            </div>
                        @break

                        @case(2)
                            <div class="col-md-3">
                                <a href="{{ route('presupuestosejecutados.create', [
                                    'id' => $vistaCategoriaFavorita->id,
                                    'menu' => $menu,
                                    'date' => $fecha_actual,
                                    'estado' => $estado,
                                    'comercial' => $comercial,
                                ]) }}"
                                    class="btn {{ $vistaCategoriaFavorita->fondo }} btn-lg btn-block" role="button">
                                    <i class="{{ $vistaCategoriaFavorita->icono }}"></i><br><br>
                                    {{ substr($vistaCategoriaFavorita->categoria, 0, 25) }}
                                </a>
                            </div>
                        @break

                        @case(3)
                            <div class="col-md-3">
                                <a href="{{ route('presupuestosprogramados.create', [
                                    'id' => $vistaCategoriaFavorita->id,
                                    'menu' => $menu,
                                    'ano' => $ano_actual,
                                    'mes' => $mes_actual,
                                    'estado' => $estado,
                                    'comercial' => $comercial,
                                ]) }}"
                                    class="btn {{ $vistaCategoriaFavorita->fondo }} btn-lg btn-block" role="button">
                                    <i class="{{ $vistaCategoriaFavorita->icono }}"></i><br><br>
                                    {{ substr($vistaCategoriaFavorita->categoria, 0, 25) }}
                                </a>
                            </div>
                        @break

                        @case(4)
                            <div class="col-md-3">
                                <a href="{{ route('presupuestosejecutados.create', [
                                    'id' => $vistaCategoriaFavorita->id,
                                    'menu' => $menu,
                                    'date' => $fecha_actual,
                                    'estado' => $estado,
                                    'comercial' => $comercial,
                                ]) }}"
                                    class="btn {{ $vistaCategoriaFavorita->fondo }} btn-lg btn-block" role="button">
                                    <i class="{{ $vistaCategoriaFavorita->icono }}"></i><br><br>
                                    {{ substr($vistaCategoriaFavorita->categoria, 0, 25) }}
                                </a>
                            </div>
                        @break
                    @endswitch
                @endforeach
            </div>
            {{-- List Categoria Buttons --}}

            <!-- Modal Categorias Favoritas Save -->
            <div class="modal fade" id="configModal" tabindex="-1" role="dialog" aria-labelledby="configModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Categorias Favoritas</h5>
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
                                <div class="row scroll">
                                    <section>
                                        <ul class="list-group list-group-sortable" id="ul_categoria_favorita">
                                            @for ($i = 0; $i < sizeof($arrayIdCategoria); $i++)
                                                <div class="col-xs-10">
                                                    <li class="list-group-item">
                                                        <input type="checkbox" class="form-check-input"
                                                            name="check_{{ $arrayIdCategoria[$i] }}"
                                                            id="check_{{ $arrayIdCategoria[$i] }}"
                                                            @if ($arrayCheckCategoria[$i] == 1) checked @endif>
                                                        <i class="fa fa-arrows" aria-hidden="true"></i>
                                                        {{ $arrayCategoria[$i] }}
                                                        <font color="#ffffff">|{{ $arrayIdCategoria[$i] }}|
                                                        </font>
                                                    </li>
                                                </div>
                                                <div class="col-xs-2"></div>
                                            @endfor
                                        </ul>
                                    </section>
                                    <input type="hidden" name="sortable" id="sortable" value="0">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary btn-submit"
                                    id="GuardarFavorita">Guardar</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal Categorias Favoritas Save -->

            <!-- Modal Create Categorias -->
            @include('categorias.modal_categoria')
            <!-- Modal Create Categorias -->

        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('js/jquery.sortable.js') }}"></script>

    <script>
        $('.list-group-sortable').sortable({
            placeholderClass: 'list-group-item'
        });
        $('.list-group-sortable').on('sortupdate', function() {
            var data = $(this).sortable('serialize');
            array_sortable = data[0].innerText;
            document.getElementById("sortable").value = array_sortable;
        });
    </script>

    <script>
        function cargarSortable() {
            $.ajax({
                url: "{{ route('categorias.getVistaCategoriaFavorita', [
                    'tipo' => $tipo,
                    'comercial' => $comercial,
                ]) }}",
                method: 'GET',

                success: function(r) {
                    let data = r;
                    let htmlCode = ``;
                    var menu = @json($menu);
                    var mes = @json($mes_actual);
                    var ano = @json($ano_actual);
                    var estado = @json($estado);
                    var comercial = @json($comercial);
                    var date = @json($fecha_actual);

                    for (var i = 0; i < data.vistaCategoriaFavoritas.length; ++i) {

                        rutaProgramada = '<div class="col-md-3"><a href="presupuestosprogramados/' +
                            data.vistaCategoriaFavoritas[i].id +
                            '/' + menu + '/' + mes + '/' + ano + '/' + estado + '/' + comercial +
                            '/create" class="btn ' +
                            data.vistaCategoriaFavoritas[i].fondo +
                            ' btn-lg btn-block" role="button"><i class="' +
                            data.vistaCategoriaFavoritas[i].icono +
                            '"></i><br><br>' +
                            data.vistaCategoriaFavoritas[i].categoria +
                            '</a></div>';

                        rutaEjecutada = '<div class="col-md-3"><a href="presupuestosejecutados/' +
                            data.vistaCategoriaFavoritas[i].id +
                            '/' + menu + '/' + date + '/' + estado + '/' + comercial + '/create" class="btn ' +
                            data.vistaCategoriaFavoritas[i].fondo +
                            ' btn-lg btn-block" role="button"><i class="' +
                            data.vistaCategoriaFavoritas[i].icono +
                            '"></i><br><br>' +
                            data.vistaCategoriaFavoritas[i].categoria +
                            '</a></div>';

                        switch (menu) {
                            case '1':
                                htmlCode += rutaProgramada;
                                break;
                            case '2':
                                htmlCode += rutaEjecutada;
                                break;
                            case '3':
                                console.log(menu);
                                htmlCode += rutaProgramada;
                                break;
                            case '4':
                                htmlCode += rutaEjecutada;
                                break;
                        }
                    };

                    $('#div_lista_categorias').html(htmlCode);
                }
            });
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#GuardarFavorita').click(function(e) {
                e.preventDefault();

                var _token = $("input[name='_token']").val();
                var contadorCheck = @json(sizeof($arrayIdCategoria));
                var arrayIdCategoria = @json($arrayIdCategoria);
                var arrayCheck = [];

                for (var i = 0; i < contadorCheck; ++i) {
                    var check = '#check_' + arrayIdCategoria[i];
                    arrayCheck[i] = $(check).prop("checked");
                }

                var sortable = $("#sortable").val();

                $.ajax({
                    url: "{{ route('categorias.store_favorita') }}",
                    type: 'POST',
                    data: {
                        _token: _token,
                        arrayIdCategoria: arrayIdCategoria,
                        arrayCheck: arrayCheck,
                        sortable: sortable
                    },
                    success: function(data) {
                        cargarSortable();
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Configuración Actualizada Correctamente',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                });
            });

            $('#GuardarCategoria').click(function(e) {
                e.preventDefault();

                var _token = $("input[name='_token']").val();
                var categoria = $("#categoria").val();
                var logo_categoria = $("#logo_categoria").val();
                var fondo_categoria = $("#fondo_categoria").val();
                var tipo_categoria = $("#tipo_categoria").val();
                var comercial = @json($comercial);

                $.ajax({
                    url: "{{ route('categorias.store_ajax_categoria') }}",
                    type: 'POST',
                    data: {
                        _token: _token,
                        categoria: categoria,
                        logo_categoria: logo_categoria,
                        fondo_categoria: fondo_categoria,
                        tipo_categoria: tipo_categoria,
                        comercial: comercial,
                    },
                    success: function(data) {
                        cargarSortable();
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Registro Guardado Correctamente, Información Actualizada',
                            showConfirmButton: false,
                            timer: 2000
                        })
                    }
                });
            });
        });
    </script>

    <script>
        $(function() {
            var search_result = @json($search_result);
            if (search_result == 1) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Busqueda no Encontrada, Intente nuevamente realizar la Busqueda',
                    showConfirmButton: false,
                    timer: 3000
                })
            }
        });
    </script>
@endpush
