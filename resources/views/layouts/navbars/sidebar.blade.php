<div class="sidebar" data-color="orange" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
    <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
    <div class="logo">
        <a href="https://creative-tim.com/" class="simple-text logo-normal">
            {{ __('info ser') }}
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
                <a class="nav-link" href="#">
                    <i class="material-icons">dashboard</i>
                    <p>{{ __('Proyectos') }}</p>
                </a>
            </li>
            <li class="nav-item {{ ($activePage == 'profile' || $activePage == 'user-management') ? ' active' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="true">
                    <i><img style="width:25px" src="{{ asset('material') }}/img/laravel.svg"></i>
                    <p>{{ __('Reportes') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse show" id="laravelExample">
                    <ul class="nav">
                        <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
                            <a class="nav-link" href="#">
                                <span class="sidebar-mini"> UP </span>
                                <span class="sidebar-normal">{{ __('User profile') }} </span>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
                            <a class="nav-link" href="#">
                                <span class="sidebar-mini"> UM </span>
                                <span class="sidebar-normal"> {{ __('User Management') }} </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item {{ ($activePage == 'profile' || $activePage == 'user-management') ? ' active' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="true">
                    <i><img style="width:25px" src="{{ asset('material') }}/img/laravel.svg"></i>
                    <p>{{ __('Reportes') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse show" id="laravelExample">
                    <ul class="nav">
                        <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
                            <a class="nav-link" href="#">
                                <span class="sidebar-mini"> UP </span>
                                <span class="sidebar-normal">{{ __('Actividades') }} </span>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
                            <a class="nav-link" href="#">
                                <span class="sidebar-mini"> UM </span>
                                <span class="sidebar-normal"> {{ __('Etapas') }} </span>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
                            <a class="nav-link" href="#">
                                <span class="sidebar-mini"> UM </span>
                                <span class="sidebar-normal"> {{ __('Proyectos') }} </span>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
                            <a class="nav-link" href="#">
                                <span class="sidebar-mini"> UM </span>
                                <span class="sidebar-normal"> {{ __('Usuarios') }} </span>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
                            <a class="nav-link" href="#">
                                <span class="sidebar-mini"> UM </span>
                                <span class="sidebar-normal"> {{ __('Usuarios en Proyectos') }} </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item {{ ($activePage == 'profile' || $activePage == 'user-management') ? ' active' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="true">
                    <i><img style="width:25px" src="{{ asset('material') }}/img/laravel.svg"></i>
                    <p>{{ __('Gráficas') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse show" id="laravelExample">
                    <ul class="nav">
                        <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
                            <a class="nav-link" href="#">
                                <span class="sidebar-mini"> UP </span>
                                <span class="sidebar-normal">{{ __('Proyectos') }} </span>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
                            <a class="nav-link" href="#">
                                <span class="sidebar-mini"> UM </span>
                                <span class="sidebar-normal"> {{ __('Actividades') }} </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item{{ $activePage == 'table' ? ' active' : '' }}">
                            <a class="nav-link" href="#">
                    <i class="material-icons">content_paste</i>
                    <p>{{ __('Compañias') }}</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'typography' ? ' active' : '' }}">
                            <a class="nav-link" href="#">
                    <i class="material-icons">library_books</i>
                    <p>{{ __('Patrocinadores') }}</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'icons' ? ' active' : '' }}">
                            <a class="nav-link" href="#">
                    <i class="material-icons">bubble_chart</i>
                    <p>{{ __('Roles') }}</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'map' ? ' active' : '' }}">
                            <a class="nav-link" href="#">
                    <i class="material-icons">location_ons</i>
                    <p>{{ __('Áreas') }}</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'notifications' ? ' active' : '' }}">
                            <a class="nav-link" href="#">
                    <i class="material-icons">notifications</i>
                    <p>{{ __('Puestos') }}</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'language' ? ' active' : '' }}">
                            <a class="nav-link" href="#">
                    <i class="material-icons">language</i>
                    <p>{{ __('Estados') }}</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'language' ? ' active' : '' }}">
                <a class="nav-link text-white bg-dark" href="#">
                    <i class="material-icons text-white">unarchive</i>
                    <p>{{ __('Usuarios') }}</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'language' ? ' active' : '' }}">
                <a class="nav-link text-white bg-info" href="#">
                    <i class="material-icons text-white">unarchive</i>
                    <p>{{ __('Proyectos') }}</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'language' ? ' active' : '' }}">
                <a class="nav-link text-white bg-secondary" href="#">
                    <i class="material-icons text-white">unarchive</i>
                    <p>{{ __('Etapas') }}</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'language' ? ' active' : '' }}">
                <a class="nav-link text-white bg-secondary" href="#">
                    <i class="material-icons text-white">unarchive</i>
                    <p>{{ __('Roles en Proyectos') }}</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'language' ? ' active' : '' }}">
                <a class="nav-link text-white bg-primary" href="#">
                    <i class="material-icons text-white">unarchive</i>
                    <p>{{ __('Roles RASIC') }}</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'language' ? ' active' : '' }}">
                <a class="nav-link text-white bg-danger" href="#">
                    <i class="material-icons text-white">unarchive</i>
                    <p>{{ __('Indicadores') }}</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'language' ? ' active' : '' }}">
                <a class="nav-link text-white bg-secondary" href="#">
                    <i class="material-icons text-white">unarchive</i>
                    <p>{{ __('Fases') }}</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'language' ? ' active' : '' }}">
                <a class="nav-link text-white bg-secondary" href="#">
                    <i class="material-icons text-white">unarchive</i>
                    <p>{{ __('Usuarios') }}</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'language' ? ' active' : '' }}">
                <a class="nav-link text-white bg-success" href="#">
                    <i class="material-icons text-white">unarchive</i>
                    <p>{{ __('Enfoques') }}</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'language' ? ' active' : '' }}">
                <a class="nav-link text-white bg-warning" href="#">
                    <i class="material-icons text-white">unarchive</i>
                    <p>{{ __('Trabajos') }}</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'language' ? ' active' : '' }}">
                <a class="nav-link text-white bg-secondary" href="#">
                    <i class="material-icons text-white">unarchive</i>
                    <p>{{ __('Actividades') }}</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'language' ? ' active' : '' }}">
                <a class="nav-link text-white bg-danger" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="material-icons text-white">logout</i>
                    <p>{{ __('Cerrar Sesión') }}</p>
                </a>
            </li>
            {{--        <li class="nav-item active-pro{{ $activePage == 'upgrade' ? ' active' : '' }}">--}}
            {{--            <a class="nav-link text-white bg-danger" href="{{ route('upgrade') }}">--}}
            {{--                <i class="material-icons text-white">unarchive</i>--}}
            {{--                <p>{{ __('Manual de Usuario') }}</p>--}}
            {{--            </a>--}}
            {{--        </li>--}}
            {{--        <li class="nav-item active-pro{{ $activePage == 'upgrade' ? ' active' : '' }}">--}}
            {{--            <a class="nav-link text-white bg-danger" href="{{ route('upgrade') }}">--}}
            {{--                <i class="material-icons text-white">unarchive</i>--}}
            {{--                <p>{{ __('Manual de Usuario') }}</p>--}}
            {{--            </a>--}}
            {{--        </li>--}}
            {{--        <li class="nav-item active-pro{{ $activePage == 'upgrade' ? ' active' : '' }}">--}}
            {{--            <a class="nav-link text-white bg-danger" href="{{ route('upgrade') }}">--}}
            {{--                <i class="material-icons text-white">unarchive</i>--}}
            {{--                <p>{{ __('Manual de Usuario') }}</p>--}}
            {{--            </a>--}}
            {{--        </li>--}}
            {{--        <li class="nav-item active-pro{{ $activePage == 'upgrade' ? ' active' : '' }}">--}}
            {{--            <a class="nav-link text-white bg-danger" href="{{ route('upgrade') }}">--}}
            {{--                <i class="material-icons text-white">unarchive</i>--}}
            {{--                <p>{{ __('Manual de Usuario') }}</p>--}}
            {{--            </a>--}}
            {{--        </li>--}}
        </ul>
    </div>
</div>
