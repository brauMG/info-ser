@extends('layouts.app', ['activePage' => 'ActividadesPDF', 'titlePage' => __('Actividades Reporte')])

@section('content')
    <div class="content">
    <form class="form-control" method="POST" action="{{route('ActivitiesPDF')}}">
                    @csrf
        <div class="container-fluid">
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

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header card-header-info">
                                        <h4 class="card-title"><i class="material-icons icons-charts-list">theater_comedy</i> Direcciones</h4>
                                    </div>
                                    <div class="card-body" style="height: 250px; overflow: auto">
                                        @foreach($direcciones as $direccion)
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="direccionesCheck{{$direccion->id}}" name="direcciones[]" value="{{$direccion->id}}">
                                                <label class="form-check-label" for="direccionesCheck{{$direccion->id}}">{{$direccion->nombre}}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header card-header-info">
                                        <h4 class="card-title"><i class="material-icons icons-charts-list">theater_comedy</i> Gerencias</h4>
                                    </div>
                                    <div class="card-body" style="height: 250px; overflow: auto">
                                        @foreach($gerencias as $gerencia)
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="gerenciasCheck{{$gerencia->id}}" name="gerencias[]" value="{{$gerencia->id}}">
                                                <label class="form-check-label" for="gerenciasCheck{{$gerencia->id}}">{{$gerencia->nombre}}</label>
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
