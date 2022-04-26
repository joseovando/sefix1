<style>
    .margin {
        margin-left: 10px;
        margin-right: 10px;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #2196F3;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }

</style>

<script type="text/javascript">
    window.onload = function() {
        var base_path = '{{ url('/') }}';
        var llaveswitch = localStorage.getItem("htmlswitch");

        if (llaveswitch == "checked") {
            var comercial = 1;
            $("#switch").prop('checked', true);
            var htmlSwitch = "<h4>&nbsp;&nbsp;Cuenta Comercial</h4>";
            $('#label_switch').html(htmlSwitch);
        } else {
            var comercial = 0;
            $("#switch").prop('checked', false);
            var htmlSwitch = "<h4>&nbsp;&nbsp;Cuenta Personal</h4>";
            $('#label_switch').html(htmlSwitch);
        }

        var href_ingreso_programado = base_path + "/categorias/1/" + comercial + "/0/index";
        $("#ingreso_programado").prop('href', href_ingreso_programado);
        var href_ingreso_ejecutado = base_path + "/categorias/2/" + comercial + "/0/index";
        $("#ingreso_ejecutado").prop('href', href_ingreso_ejecutado);
        var href_egreso_programado = base_path + "/categorias/3/" + comercial + "/0/index";
        $("#egreso_programado").prop('href', href_egreso_programado);
        var href_egreso_ejecutado = base_path + "/categorias/4/" + comercial + "/0/index";
        $("#egreso_ejecutado").prop('href', href_egreso_ejecutado);

        var href_categoria_tablero_categoria = base_path + "/categorias/" + comercial + "/tablero_categoria";
        $("#categoria_tablero_categoria").prop('href', href_categoria_tablero_categoria);
        var href_categoria_tablero = base_path + "/categorias/" + comercial + "/tablero";
        $("#categoria_tablero").prop('href', href_categoria_tablero);
    }

    function handleOnClick() {
        var base_path = '{{ url('/') }}';

        if ($("#switch").prop('checked')) {
            var comercial = 1;
            var htmlSwitch = "<h4>Cuenta Comercial</h4>";
            localStorage.setItem("htmlswitch", "checked");
            $('#label_switch').html(htmlSwitch);
        } else {
            var comercial = 0;
            var htmlSwitch = "<h4>Cuenta Personal</h4>";
            localStorage.setItem("htmlswitch", "unchecked");
            $('#label_switch').html(htmlSwitch);
        }

        var href_ingreso_programado = base_path + "/categorias/1/" + comercial + "/0/index";
        $("#ingreso_programado").prop('href', href_ingreso_programado);
        var href_ingreso_ejecutado = base_path + "/categorias/2/" + comercial + "/0/index";
        $("#ingreso_ejecutado").prop('href', href_ingreso_ejecutado);
        var href_egreso_programado = base_path + "/categorias/3/" + comercial + "/0/index";
        $("#egreso_programado").prop('href', href_egreso_programado);
        var href_egreso_ejecutado = base_path + "/categorias/4/" + comercial + "/0/index";
        $("#egreso_ejecutado").prop('href', href_egreso_ejecutado);

        var href_categoria_tablero_categoria = base_path + "/categorias/" + comercial + "/tablero_categoria";
        $("#categoria_tablero_categoria").prop('href', href_categoria_tablero_categoria);
        var href_categoria_tablero = base_path + "/categorias/" + comercial + "/tablero";
        $("#categoria_tablero").prop('href', href_categoria_tablero);
    }
</script>

<div class="sidebar" data-color="orange" data-background-color="white"
    data-image="{{ asset('material') }}/img/sidebar-1.jpg">
    <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->

    @if (preg_match('/(android|webos|avantgo|iphone|ipod|ipad|bolt|boost|cricket|docomo|fone|hiptop|opera mini|mini|kitkat|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i', $_SERVER['HTTP_USER_AGENT']))
    @else
        <div class="logo">
            <a href="#" class="simple-text logo-normal">
            </a>
            <img src="{{ asset('img/sefix_logo.png') }}" width="90%">
        </div>
        <br>
    @endif

    <div class="sidebar-wrapper">

        <div class="row margin">
            <div class="col-xs-4">
                <label class="switch">
                    <input type="checkbox" id="switch" onclick="handleOnClick()">
                    <span class="slider"></span>
                </label>
            </div>
            <div class="col-xs-8">
                <div id="label_switch">
                    <h4>&nbsp;&nbsp;Cuenta Personal</h4>
                </div>
            </div>
        </div>

        <ul class="nav">

            <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="material-icons">dashboard</i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>

            {{-- Ingresos --}}
            <li class="nav-item {{ $activePage == 'ingresos' || $activePage == 'user-management' ? ' active' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#ingresos" aria-expanded="true">
                    <i class="material-icons">account_balance_wallet</i>
                    <p>{{ __('Ingreso') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="ingresos">
                    <ul class="nav">
                        <li class="nav-item{{ $activePage == 'iprogramado' ? ' active' : '' }}">
                            <a class="nav-link" id="ingreso_programado" href="">
                                <i class="material-icons">developer_board</i>
                                <span class="sidebar-normal">{{ __('Programado') }} </span>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'iejecutado' ? ' active' : '' }}">
                            <a class="nav-link" id="ingreso_ejecutado" href="">
                                <i class="material-icons">domain</i>
                                <span class="sidebar-normal">{{ __('Ejecutado') }} </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- egreso --}}
            <li class="nav-item {{ $activePage == 'egreso' || $activePage == 'user-management' ? ' active' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#egreso" aria-expanded="true">
                    <i class="material-icons">shopping_cart</i>
                    <p>{{ __('Egreso') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="egreso">
                    <ul class="nav">
                        <li class="nav-item{{ $activePage == 'iejecutado' ? ' active' : '' }}">
                            <a class="nav-link" id="egreso_programado" href="">
                                <i class="material-icons">developer_board</i>
                                <span class="sidebar-normal">{{ __('Programado') }} </span>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'iejecutado' ? ' active' : '' }}">
                            <a class="nav-link" id="egreso_ejecutado" href="">
                                <i class="material-icons">domain</i>
                                <span class="sidebar-normal">{{ __('Ejecutado') }} </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- cuentas --}}
            <li class="nav-item {{ $activePage == 'cuentas' || $activePage == 'cuentas' ? ' active' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#cuentas" aria-expanded="true">
                    <i class="material-icons">monetization_on</i>
                    <p>{{ __('Cuentas') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="cuentas">
                    <ul class="nav">
                        <li class="nav-item{{ $activePage == 'por_cobrar' ? ' active' : '' }}">
                            <a class="nav-link"
                                href="{{ route('cuentas.index', [
                                    'id' => 1,
                                    'ano' => 1,
                                    'mes' => 1,
                                ]) }}">
                                <i class="material-icons">money_off</i>
                                <span class="sidebar-normal">{{ __('Por Cobrar') }} </span>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'por_pagar' ? ' active' : '' }}">
                            <a class="nav-link"
                                href="{{ route('cuentas.index', [
                                    'id' => 2,
                                    'ano' => 1,
                                    'mes' => 1,
                                ]) }}">
                                <i class="material-icons">attach_money</i>
                                <span class="sidebar-normal">{{ __('Por Pagar') }} </span>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'reporte' ? ' active' : '' }}">
                            <a class="nav-link"
                                href="{{ route('cuentas.reporte', [
                                    'ano' => 1,
                                    'mes' => 1,
                                ]) }}">
                                <i class="material-icons">insert_chart</i>
                                <span class="sidebar-normal">{{ __('Reporte') }} </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- Categorias --}}
            <li
                class="nav-item {{ $activePage == 'categorias' || $activePage == 'user-management' ? ' active' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#categorias" aria-expanded="true">
                    <i class="material-icons">category</i>
                    <p>{{ __('Categorias') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="categorias">
                    <ul class="nav">
                        <li class="nav-item{{ $activePage == 'categoria' ? ' active' : '' }}">
                            <a class="nav-link" id="categoria_tablero_categoria" href="">
                                <i class="material-icons">mode_comment</i>
                                <span class="sidebar-normal">{{ __('Categorias') }} </span>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'subcategoria' ? ' active' : '' }}">
                            <a class="nav-link" id="categoria_tablero" href="">
                                <i class="material-icons">question_answer</i>
                                <span class="sidebar-normal">{{ __('Subcategorias') }} </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- Reportes --}}
            <li class="nav-item {{ $activePage == 'reportes' || $activePage == 'reportes' ? ' active' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#reportes" aria-expanded="true">
                    <i class="material-icons">assessment</i>
                    <p>{{ __('Reportes') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="reportes">
                    <ul class="nav">
                        <li class="nav-item{{ $activePage == 'reportes' ? ' active' : '' }}">
                            <a class="nav-link"
                                href="{{ route('reportes.index', [
                                    'ano' => 1,
                                    'mes' => 1,
                                ]) }}">
                                <i class="material-icons">insert_chart</i>
                                <span class="sidebar-normal">{{ __('General') }} </span>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'reportes' ? ' active' : '' }}">
                            <a class="nav-link"
                                href="{{ route('reportes.categoria', [
                                    'ano' => 1,
                                    'mes' => 1,
                                    'tipo' => 1,
                                ]) }}">
                                <i class="material-icons">insert_chart</i>
                                <span class="sidebar-normal">{{ __('Ingreso') }} </span>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'reportes' ? ' active' : '' }}">
                            <a class="nav-link"
                                href="{{ route('reportes.categoria', [
                                    'ano' => 1,
                                    'mes' => 1,
                                    'tipo' => 2,
                                ]) }}">
                                <i class="material-icons">insert_chart</i>
                                <span class="sidebar-normal">{{ __('Egreso') }} </span>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'reportes' ? ' active' : '' }}">
                            <a class="nav-link" href="{{ route('reportes.tablero') }}">
                                <i class="material-icons">insert_chart</i>
                                <span class="sidebar-normal">{{ __('Categorias') }} </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- Users --}}
            @can('user_index')
                <li class="nav-item {{ $activePage == 'profile' || $activePage == 'user-management' ? ' active' : '' }}">
                    <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="true">
                        <i><img style="width:25px" src="{{ asset('material') }}/img/laravel.svg"></i>
                        <p>{{ __('Usuarios') }}
                            <b class="caret"></b>
                        </p>
                    </a>

                    <div class="collapse" id="laravelExample">
                        <ul class="nav">
                            <li class="nav-item{{ $activePage == 'Usuarios' ? ' active' : '' }}">
                                <a class="nav-link" href="{{ route('users.index') }}">
                                    <span class="sidebar-mini"> UM </span>
                                    <span class="sidebar-normal"> {{ __('Usuarios') }} </span>
                                </a>
                            </li>
                            @can('permission_index')
                                <li class="nav-item{{ $activePage == 'Permisos' ? ' active' : '' }}">
                                    <a class="nav-link" href="{{ route('permissions.index') }}">
                                        <span class="sidebar-mini"> UM </span>
                                        <span class="sidebar-normal"> {{ __('Permisos') }} </span>
                                    </a>
                                </li>
                            @endcan
                            @can('role_index')
                                <li class="nav-item{{ $activePage == 'Roles' ? ' active' : '' }}">
                                    <a class="nav-link" href="{{ route('roles.index') }}">
                                        <span class="sidebar-mini"> UM </span>
                                        <span class="sidebar-normal"> {{ __('Roles') }} </span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                @endcan
            </li>
        </ul>
    </div>
</div>
