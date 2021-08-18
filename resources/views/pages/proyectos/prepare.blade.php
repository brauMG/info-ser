@extends('layouts.app', ['activePage' => 'ProyectosPDF', 'titlePage' => __('Proyectos Reporte')])

@section('content')
        <div class="content">
                <form class="form-control" method="POST" action="{{route('ProjectsPDF')}}">
                    @csrf
                    <div class="container-fluid">
                        <div class="row">
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
                                                    <input type="checkbox" class="form-check-input" id="faseCheck{{$fase->id}}" name="fases[]" value="{{$fase->id}}">
                                                    <label class="form-check-label" for="faseCheck{{$fase->id}}">{{$fase->descripcion}}</label>
                                                </div>
                                            @endforeach
                                        @endif
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
                                        <h4 class="card-title"><i class="material-icons icons-charts-list">sell</i> Indicadores</h4>
                                    </div>
                                    <div class="card-body" style="height: 250px; overflow: auto">
                                        @if(count($indicadores) == 0)
                                            <a style="color: #c42623; font-size: 1.2em"><strong>No hay indicadores</strong></a>
                                        @else
                                            @foreach($indicadores as $indicador)
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="indicadorCheck{{$indicador->id}}" name="indicadores[]" value="{{$indicador->id}}">
                                                    <label class="form-check-label" for="indicadorCheck{{$indicador->id}}">{{$indicador->descripcion}}</label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-header card-header-info">
                                        <h4 class="card-title"><i class="material-icons icons-charts-list">area_chart</i> Áreas</h4>
                                    </div>
                                    <div class="card-body" style="height: 250px; overflow: auto">
                                        @if(count($areas) == 0)
                                            <a style="color: #c42623; font-size: 1.2em"><strong>No hay áreas</strong></a>
                                        @else
                                            @foreach($areas as $area)
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="areaCheck{{$area->id}}" name="areas[]" value="{{$area->id}}">
                                                    <label class="form-check-label" for="areaCheck{{$area->id}}">{{$area->descripcion}}</label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-header card-header-info">
                                        <h4 class="card-title"><i class="material-icons icons-charts-list">loupe</i> Enfoques</h4>
                                    </div>
                                    <div class="card-body" style="height: 250px; overflow: auto">
                                        @if(count($enfoques) == 0)
                                            <a style="color: #c42623; font-size: 1.2em"><strong>No hay enfoques</strong></a>
                                        @else
                                            @foreach($enfoques as $enfoque)
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="enfoquesCheck{{$enfoque->id}}" name="enfoques[]" value="{{$enfoque->id}}">
                                                    <label class="form-check-label" for="enfoquesCheck{{$enfoque->id}}">{{$enfoque->descripcion}}</label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-header card-header-info">
                                        <h4 class="card-title"><i class="material-icons icons-charts-list">work</i> Trabajos</h4>
                                    </div>
                                    <div class="card-body" style="height: 250px; overflow: auto">
                                        @if(count($trabajos) == 0)
                                            <a style="color: #c42623; font-size: 1.2em"><strong>No hay trabajos</strong></a>
                                        @else
                                            @foreach($trabajos as $trabajo)
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="trabajoCheck{{$trabajo->id}}" name="trabajos[]" value="{{$trabajo->id}}">
                                                    <label class="form-check-label" for="trabajoCheck{{$trabajo->id}}">{{$trabajo->descripcion}}</label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-header card-header-info">
                                        <h4 class="card-title"><i class="material-icons icons-charts-list">theater_comedy</i> Estados</h4>
                                    </div>
                                    <div class="card-body" style="height: 250px; overflow: auto">
                                        @if(count($estados) == 0)
                                            <a style="color: #c42623; font-size: 1.2em"><strong>No hay estados</strong></a>
                                        @else
                                        @foreach($estados as $estado)
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="estadoCheck{{$estado->id}}" name="estados[]" value="{{$estado->id}}">
                                                <label class="form-check-label" for="estadoCheck{{$estado->id}}">{{$estado->estado}}</label>
                                            </div>
                                        @endforeach
                                        @endif
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
                                    <div id="mySpan" style="display: none">
                                        <span><strong>El reporte se esta generando y se descargara automaticamente al finalizar</strong></span>
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

