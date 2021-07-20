@extends('layouts.app', ['activePage' => 'ActividadesPDF', 'titlePage' => __('Actividades Reporte')])

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
                            <h4 class="card-title">Filtros - Reporte de Actividades</h4>
                        </div>
                    </div>
                </div>

                <form class="form-control" method="POST" action="{{route('ActivitiesPDF')}}">
                    @csrf
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header card-header-info">
                                        <h4 class="card-title"><i class="material-icons icons-charts-list">calendar_today</i> Fecha de Creación</h4>
                                    </div>
                                    <div class="card-body" style="height: 250px; overflow: auto">
                                        <label for="desde" class="label-on-left">Desde el: </label>
                                        <input class="form-control" type="date" id="desde" name="desde">
                                        <label for="hasta" class="label-on-left">Hasta el: </label>
                                        <input class="form-control" type="date" id="hasta" name="hasta">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header card-header-info">
                                        <h4 class="card-title"><i class="material-icons icons-charts-list">scatter_plot</i> Proyectos</h4>
                                    </div>
                                    <div class="card-body" style="height: 250px; overflow: auto">
                                        @if(count($proyectos) == 0)
                                            <a style="color: #c42623; font-size: 1.2em"><strong>No hay proyectos</strong></a>
                                        @else
                                            @foreach($proyectos as $proyecto)
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="proyectoCheck{{$proyecto->id}}" name="proyectos[]" value="{{$proyecto->id}}">
                                                    <label class="form-check-label" for="proyectoCheck{{$proyecto->id}}">{{$proyecto->descripcion}}</label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header card-header-info">
                                        <h4 class="card-title"><i class="material-icons icons-charts-list">vpn_key</i> Etapas</h4>
                                    </div>
                                    <div class="card-body" style="height: 250px; overflow: auto">
                                        @if(count($etapas) == 0)
                                            <a style="color: #c42623; font-size: 1.2em"><strong>No hay etapas</strong></a>
                                        @else
                                            @foreach($etapas as $etapa)
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="etapaCheck{{$etapa->id}}" name="etapas[]" value="{{$etapa->id}}">
                                                    <label class="form-check-label" for="etapaCheck{{$etapa->id}}">{{$etapa->etapa}} de {{$etapa->proyecto}}</label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header card-header-info">
                                        <h4 class="card-title"><i class="material-icons icons-charts-list">stacked_bar_chart</i> Fases</h4>
                                    </div>
                                    <div class="card-body" style="height: 250px; overflow: auto">
                                        @if(count($fases) == 0)
                                            <a style="color: #c42623; font-size: 1.2em"><strong>No hay fases</strong></a>
                                        @else
                                            @foreach($fases as $fase)
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="fasesCheck{{$fase->id}}" name="fases[]" value="{{$fase->id}}">
                                                    <label class="form-check-label" for="fasesCheck{{$fase->id}}">{{$fase->descripcion}}</label>
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
                                            <a style="color: #c42623; font-size: 1.2em"><strong>No hay fases</strong></a>
                                        @else
                                            @foreach($usuarios as $usuario)
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="usuariosCheck{{$usuario->id}}" name="usuarios[]" value="{{$usuario->id}}">
                                                    <label class="form-check-label" for="usuariosCheck{{$usuario->id}}">{{$usuario->nombres}}</label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header card-header-info">
                                        <h4 class="card-title"><i class="material-icons icons-charts-list">theater_comedy</i> Estados</h4>
                                    </div>
                                    <div class="card-body" style="height: 250px; overflow: auto">
                                        @foreach($estados as $estado)
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="estadosCheck{{$estado}}" name="estados[]" value="{{$estado}}">
                                                <label class="form-check-label" for="estadosCheck{{$estado}}">@if($estado == 0) Pendiente @elseif($estado == 1) Aprobada @elseif($estado == 2) Desaprobada @endif</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="container text-center">
                                    <button type="submit" class="btn  btn-sm btn-primary" onclick="myFunction()">Generar Reporte</button>
                                    <button type="reset" class="btn btn-sm btn-warning" onclick="myFunction2()">Limpiar Campos</button>
                                    <div id="mySpan" style="display: ">
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
