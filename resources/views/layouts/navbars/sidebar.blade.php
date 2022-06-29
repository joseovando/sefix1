<link rel="stylesheet" type="text/css" href="{{ asset('css/sidebar.css') }}">

@include('layouts.navbars.scripts')

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

            {{-- Brujula Financiera --}}
            <li class="nav-item{{ $activePage == 'brujula' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('brujula.index') }}">
                    <i class="material-icons">explore</i>
                    <p>{{ __('Brujula Financiera') }}</p>
                </a>
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
