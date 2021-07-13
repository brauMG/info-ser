<div class="sidebar" data-color="azure" data-background-color="blue" data-image="{{ asset('material') }}/img/sidebar-4.jpg">
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
            {{--Super Admin = 1, Admin = 2, Usuario = 3, PMO = 4, Presidente = 5, Director = 6, Gerente = 7--}}
            @if(Auth::user()->id_rol == 3 || Auth::user()->id_rol == 4 || Auth::user()->id_rol == 7)
            <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
                <a class="nav-link" href="#">
                    <i class="material-icons text-white">edit_calendar</i>
                    <p>{{ __('Proyectos') }}</p>
                </a>
            </li>
            @endif

            @if(Auth::user()->id_rol == 2 || Auth::user()->id_rol == 4 || Auth::user()->id_rol == 5 || Auth::user()->id_rol == 6 || Auth::user()->id_rol == 7)
            <li class="nav-item {{ ($activePage == 'profile' || $activePage == 'user-management') ? ' active' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="true">
                    <i><img style="width:25px" src="{{ asset('material') }}/img/reportes.svg"></i>
                    <p>{{ __('Reportes') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse show" id="laravelExample">
                    <ul class="nav">
                        <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
                            <a class="nav-link" href="#">
                                <i class="material-icons text-white">insights</i>
                                <span class="sidebar-normal">{{ __('Actividades') }} </span>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
                            <a class="nav-link" href="#">
                                <i class="material-icons text-white">insights</i>
                                <span class="sidebar-normal"> {{ __('Etapas') }} </span>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
                            <a class="nav-link" href="#">
                                <i class="material-icons text-white">insights</i>
                                <span class="sidebar-normal"> {{ __('Proyectos') }} </span>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
                            <a class="nav-link" href="#">
                                <i class="material-icons text-white">insights</i>
                                <span class="sidebar-normal"> {{ __('Usuarios') }} </span>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
                            <a class="nav-link" href="#">
                                <i class="material-icons text-white">insights</i>
                                <span class="sidebar-normal"> {{ __('Usuarios en Proyectos') }} </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif

            @if(Auth::user()->id_rol == 2 || Auth::user()->id_rol == 4 || Auth::user()->id_rol == 5 || Auth::user()->id_rol == 6 || Auth::user()->id_rol == 7)
            <li class="nav-item {{ ($activePage == 'profile' || $activePage == 'user-management') ? ' active' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="true">
                    <i><img style="width:25px" src="{{ asset('material') }}/img/graficas.svg"></i>
                    <p>{{ __('Gráficas') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse show" id="laravelExample">
                    <ul class="nav">
                        <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
                            <a class="nav-link" href="#">
                                <i class="material-icons text-white">analytics</i>
                                <span class="sidebar-normal">{{ __('Proyectos') }} </span>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
                            <a class="nav-link" href="#">
                                <i class="material-icons text-white">analytics</i>
                                <span class="sidebar-normal"> {{ __('Actividades') }} </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif

            @if(Auth::user()->id_rol == 1)
            <li class="nav-item{{ $activePage == 'Compañias' ? ' active' : '' }}">
                <a class="nav-link" href="{{ url('/companias/') }}">
                    <i class="material-icons text-white">business</i>
                    <p>{{ __('Compañias') }}</p>
                </a>
            </li>
            @endif

            @if(Auth::user()->id_rol == 1)
            <li class="nav-item{{ $activePage == 'Patrocinadores' ? ' active' : '' }}">
                <a class="nav-link" href="{{ url('/patrocinadores') }}">
                    <i class="material-icons text-white">monetization_on</i>
                    <p>{{ __('Patrocinadores') }}</p>
                </a>
            </li>
            @endif

            @if(Auth::user()->id_rol == 1)
            <li class="nav-item{{ $activePage == 'Roles' ? ' active' : '' }}">
                <a class="nav-link" href="{{ url('/roles/') }}">
                    <i class="material-icons text-white">admin_panel_settings</i>
                    <p>{{ __('Roles') }}</p>
                </a>
            </li>
            @endif

            @if(Auth::user()->id_rol == 1 || Auth::user()->id_rol == 2)
            <li class="nav-item{{ $activePage == 'Áreas' ? ' active' : '' }}">
                <a class="nav-link" href="{{ url('/areas/') }}">
                    <i class="material-icons text-white">work</i>
                    <p>{{ __('Áreas') }}</p>
                </a>
            </li>
            @endif

            @if(Auth::user()->id_rol == 1 || Auth::user()->id_rol == 2)
            <li class="nav-item{{ $activePage == 'Puestos' ? ' active' : '' }}">
                <a class="nav-link" href="{{ url('/puesto/') }}">
                    <i class="material-icons text-white">room_preferences</i>
                    <p>{{ __('Puestos') }}</p>
                </a>
            </li>
            @endif

            @if(Auth::user()->id_rol == 1 || Auth::user()->id_rol == 2)
            <li class="nav-item{{ $activePage == 'Estados' ? ' active' : '' }}">
                <a class="nav-link" href="{{ url('/estados/') }}">
                    <i class="material-icons text-white">pending</i>
                    <p>{{ __('Estados') }}</p>
                </a>
            </li>
            @endif

            @if(Auth::user()->id_rol == 1 || Auth::user()->id_rol == 2)
            <li class="nav-item{{ $activePage == 'Usuarios' ? ' active' : '' }}">
                <a class="nav-link" href="{{ url('/usuarios/') }}">
                    <i class="material-icons text-white">manage_accounts</i>
                    <p>{{ __('Usuarios') }}</p>
                </a>
            </li>
            @endif

            @if(Auth::user()->id_rol == 4 || Auth::user()->id_rol == 7)
            <li class="nav-item{{ $activePage == 'language' ? ' active' : '' }}">
                <a class="nav-link text-white bg-secondary" href="#">
                    <i class="material-icons text-white">approval</i>
                    <p>{{ __('Etapas') }}</p>
                </a>
            </li>
            @endif

            @if(Auth::user()->id_rol == 4 || Auth::user()->id_rol == 7)
            <li class="nav-item{{ $activePage == 'language' ? ' active' : '' }}">
                <a class="nav-link text-white bg-secondary" href="#">
                    <i class="material-icons text-white">badge</i>
                    <p>{{ __('Roles en Proyectos') }}</p>
                </a>
            </li>
            @endif

            @if(Auth::user()->id_rol == 1 || Auth::user()->id_rol == 2)
            <li class="nav-item{{ $activePage == 'RASIC' ? ' active' : '' }}">
                <a class="nav-link" href="{{ url('/roles-RASIC/') }}">
                    <i class="material-icons text-white">category</i>
                    <p>{{ __('Roles RASIC') }}</p>
                </a>
            </li>
            @endif

            @if(Auth::user()->id_rol == 1 || Auth::user()->id_rol == 2)
            <li class="nav-item{{ $activePage == 'Indicadores' ? ' active' : '' }}">
                <a class="nav-link" href="{{ url('/indicadores/') }}">
                    <i class="material-icons text-white">account_tree</i>
                    <p>{{ __('Indicadores') }}</p>
                </a>
            </li>
            @endif

            @if(Auth::user()->id_rol == 1 || Auth::user()->id_rol == 2)
            <li class="nav-item{{ $activePage == 'Fases' ? ' active' : '' }}">
                <a class="nav-link" href="{{ url('/fases/') }}">
                    <i class="material-icons text-white">legend_toggle</i>
                    <p>{{ __('Fases') }}</p>
                </a>
            </li>
            @endif

            @if(Auth::user()->id_rol == 1 || Auth::user()->id_rol == 2)
            <li class="nav-item{{ $activePage == 'Enfoques' ? ' active' : '' }}">
                <a class="nav-link" href="{{ url('/enfoques/') }}">
                    <i class="material-icons text-white">loupe</i>
                    <p>{{ __('Enfoques') }}</p>
                </a>
            </li>
            @endif

            @if(Auth::user()->id_rol == 1 || Auth::user()->id_rol == 2)
            <li class="nav-item{{ $activePage == 'Trabajos' ? ' active' : '' }}">
                <a class="nav-link" href="{{ url('/trabajos/') }}">
                    <i class="material-icons text-white">engineering</i>
                    <p>{{ __('Trabajos') }}</p>
                </a>
            </li>
            @endif

            @if(Auth::user()->id_rol == 3 || Auth::user()->id_rol == 4)
            <li class="nav-item{{ $activePage == 'language' ? ' active' : '' }}">
                <a class="nav-link text-white bg-secondary" href="#">
                    <i class="material-icons text-white">add_task</i>
                    <p>{{ __('Actividades') }}</p>
                </a>
            </li>
            @endif

            <li class="nav-item{{ $activePage == 'language' ? ' active' : '' }}">
                <a class="nav-link text-white bg-dark" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
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
