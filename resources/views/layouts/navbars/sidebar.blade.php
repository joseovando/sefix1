<div class="sidebar" data-color="orange" data-background-color="white"
    data-image="{{ asset('material') }}/img/sidebar-1.jpg">
    <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
    <div class="logo">
        <a href="#" class="simple-text logo-normal">
        </a>
        <img src="{{ asset('img/sefix_logo.png') }}" width="90%">
    </div>
    <div class="sidebar-wrapper">
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
                            <a class="nav-link" href="{{ route('categorias.index', 1) }}">
                                <i class="material-icons">developer_board</i>
                                <span class="sidebar-normal">{{ __('Programado') }} </span>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'iejecutado' ? ' active' : '' }}">
                            <a class="nav-link" href="{{ route('categorias.index', 2) }}">
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
                        <li class="nav-item{{ $activePage == 'iprogramado' ? ' active' : '' }}">
                            <a class="nav-link" href="{{ route('categorias.index', 3) }}">

                                <i class="material-icons">developer_board</i>
                                <span class="sidebar-normal">{{ __('Programado') }} </span>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'iejecutado' ? ' active' : '' }}">
                            <a class="nav-link" href="{{ route('categorias.index', 4) }}">
                                <i class="material-icons">domain</i>
                                <span class="sidebar-normal">{{ __('Ejecutado') }} </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- Categorias --}}
            <li class="nav-item{{ $activePage == 'categorias' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('categorias.index', 1) }}">
                    <i class="material-icons">apps</i>
                    <p>{{ __('Categorias') }}</p>
                </a>
            </li>

            {{-- Graficas --}}
            <li class="nav-item{{ $activePage == 'graficas' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('charts.ejemplo') }}">
                    <i class="material-icons">apps</i>
                    <p>{{ __('Gasto Vivienda') }}</p>
                </a>
            </li>

            <li class="nav-item{{ $activePage == 'graficas' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('charts.ejemplo_pie') }}">
                    <i class="material-icons">apps</i>
                    <p>{{ __('Seguimiento Gastos') }}</p>
                </a>
            </li>

            <li class="nav-item{{ $activePage == 'graficas' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('charts.ejemplo_group_bar') }}">
                    <i class="material-icons">apps</i>
                    <p>{{ __('Pasajes Programado Ejecutado') }}</p>
                </a>
            </li>

            <li class="nav-item{{ $activePage == 'graficas' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('charts.gasto_categoria') }}">
                    <i class="material-icons">apps</i>
                    <p>{{ __('Gasto por Categoria') }}</p>
                </a>
            </li>

            {{-- Laravel --}}
            <li class="nav-item{{ $activePage == 'posts' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('posts.index') }}">
                    <i class="material-icons">blur_linear</i>
                    <p>{{ __('Posts') }}</p>
                </a>
            </li>

            <li class="nav-item {{ $activePage == 'profile' || $activePage == 'user-management' ? ' active' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="true">
                    <i><img style="width:25px" src="{{ asset('material') }}/img/laravel.svg"></i>
                    <p>{{ __('Laravel Examples') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="laravelExample">
                    <ul class="nav">
                        <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
                            <a class="nav-link" href="{{ route('profile.edit') }}">
                                <span class="sidebar-mini"> UP </span>
                                <span class="sidebar-normal">{{ __('User profile') }} </span>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
                            <a class="nav-link" href="{{ route('user.index') }}">
                                <span class="sidebar-mini"> UM </span>
                                <span class="sidebar-normal"> {{ __('User Management') }} </span>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'table' ? ' active' : '' }}">
                            <a class="nav-link" href="{{ route('table') }}">
                                <i class="material-icons">content_paste</i>
                                <p>{{ __('Table List') }}</p>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'typography' ? ' active' : '' }}">
                            <a class="nav-link" href="{{ route('typography') }}">
                                <i class="material-icons">library_books</i>
                                <p>{{ __('Typography') }}</p>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'icons' ? ' active' : '' }}">
                            <a class="nav-link" href="{{ route('icons') }}">
                                <i class="material-icons">bubble_chart</i>
                                <p>{{ __('Icons') }}</p>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'map' ? ' active' : '' }}">
                            <a class="nav-link" href="{{ route('map') }}">
                                <i class="material-icons">location_ons</i>
                                <p>{{ __('Maps') }}</p>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'notifications' ? ' active' : '' }}">
                            <a class="nav-link" href="{{ route('notifications') }}">
                                <i class="material-icons">notifications</i>
                                <p>{{ __('Notifications') }}</p>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'language' ? ' active' : '' }}">
                            <a class="nav-link" href="{{ route('language') }}">
                                <i class="material-icons">language</i>
                                <p>{{ __('RTL Support') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
