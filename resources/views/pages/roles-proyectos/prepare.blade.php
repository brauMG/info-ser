@extends('layouts.app', ['activePage' => 'UsuariosProyectosPDF', 'titlePage' => __('Usuarios Por Proyectos Reporte')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @if ( session('mensaje') )
                        <div class="alert alert-success" role="alert" id="message">
                            {{ session('mensaje') }}
                        </div>
                    @endif
                    @if ( session('mensajeAlert') )
                        <div class="alert alert-warning" role="alert" id="message">
                            {{ session('mensajeAlert') }}
                        </div>
                    @endif
                    @if ( session('mensajeDanger') )
                        <div class="alert alert-danger" role="alert" id="message">
                            {{ session('mensajeDanger') }}
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger" role="alert" id="message">
                            Se encontraron los siguientes errores: <br>
                            @foreach($errors->all() as $error)
                                <br>
                                {{'• '.$error }}
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Filtros - Reporte de Usuarios Por Proyectos</h4>
                        </div>
                    </div>
                </div>
                <form class="form-control" method="POST" action="{{route('UsersProjectsPDF')}}">
                    @csrf
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header card-header-info">
                                        <h4 class="card-title"><i class="material-icons icons-charts-list">spatter_dots</i> Proyectos</h4>
                                    </div>
                                    <div class="card-body" style="height: 250px; overflow: auto">
                                        @if(count($proyectos) == 0)
                                            <a style="color: #c42623; font-size: 1.2em"><strong>No hay proyectos</strong></a>
                                        @else
                                            @foreach($proyectos as $proyecto)
                                                <div class="form-check filters-projects-list">
                                                    <input type="checkbox" class="form-check-input box-mod" id="proyecto{{$proyecto->id}}" name="proyectos[]" value="{{$proyecto->id}}">
                                                    <label class="form-check-label" for="proyecto{{$proyecto->id}}">{{$proyecto->descripcion}}</label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header card-header-info">
                                        <h4 class="card-title"><i class="material-icons icons-charts-list">area_chart</i> Fases</h4>
                                    </div>
                                    <div class="card-body" style="height: 250px; overflow: auto">
                                        @if(count($fases) == 0)
                                            <a style="color: #c42623; font-size: 1.2em"><strong>No hay fases</strong></a>
                                        @else
                                            @foreach($fases as $fase)
                                                <div class="form-check filters-projects-list">
                                                    <input type="checkbox" class="form-check-input box-mod" id="fase{{$fase->id}}" name="fases[]" value="{{$fase->id}}">
                                                    <label class="form-check-label" for="fase{{$fase->id}}">{{$fase->descripcion}}</label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header card-header-info">
                                        <h4 class="card-title"><i class="material-icons icons-charts-list">engineering</i> Usuarios</h4>
                                    </div>
                                    <div class="card-body" style="height: 250px; overflow: auto">
                                        @if(count($usuarios) == 0)
                                            <a style="color: #c42623; font-size: 1.2em"><strong>No hay roles</strong></a>
                                        @else
                                            @foreach($usuarios as $usuario)
                                                <div class="form-check filters-stages-list">
                                                    <input type="checkbox" class="form-check-input box-mod" id="usuario{{$usuario->id}}" name="usuarios[]" value="{{$usuario->id}}">
                                                    <label class="form-check-label" for="usuario{{$usuario->id}}">{{$usuario->nombres}}</label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header card-header-info">
                                        <h4 class="card-title"><i class="material-icons icons-charts-list">vpn_key</i> Roles RASIC</h4>
                                    </div>
                                    <div class="card-body" style="height: 250px; overflow: auto">
                                            @foreach($rasics as $rasic)
                                                <div class="form-check filters-stages-list">
                                                    <input type="checkbox" class="form-check-input box-mod" id="rasic{{$rasic->id}}" name="rasics[]" value="{{$rasic->id}}">
                                                    <label class="form-check-label" for="rasic{{$rasic->id}}">{{$rasic->rol_rasic}}</label>
                                                </div>
                                            @endforeach
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="container text-center">
                                    <button type="submit" class="btn btn-primary" onclick="myFunction()">Generar Reporte</button>
                                    <button type="reset" class="btn btn-warning" onclick="myFunction2()">Limpiar Campos</button>
                                    <div id="mySpan" style="display: none">
                                        <span><strong>El reporte se esta generando y se descargara automaticamente al finalizar</strong></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <script>
                    function myFunction() {
                        var x = document.getElementById("mySpan");
                        if (x.style.display === "none") {
                            x.style.display = "block";
                        } else {
                            x.style.display = "none";
                        }
                    }
                    function myFunction2() {
                        var x = document.getElementById("mySpan");
                        if (x.style.display === "block") {
                            x.style.display = "none";
                        } else {
                            x.style.display = "none";
                        }
                    }
                </script>
@endsection
