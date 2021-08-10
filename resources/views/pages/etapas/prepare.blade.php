@extends('layouts.app', ['activePage' => 'EtapasPDF', 'titlePage' => __('Etapas Reporte')])

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
                            <h4 class="card-title">Filtros - Reporte de Etapas</h4>
                        </div>
                    </div>
                </div>
                    <form class="form-control" method="POST" action="{{route('StagesPDF')}}">
                        @csrf
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header card-header-info">
                                            <h4 class="card-title"><i class="material-icons icons-charts-list">stacked_bar_chart</i> Fases</h4>
                                        </div>
                                        <div class="card-body" style="height: 250px; overflow: auto">
                                        @if(count($fases) == 0)
                                            <a style="color: #c42623; font-size: 1.2em"><strong>No hay Fases</strong></a>
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
                                            <h4 class="card-title"><i class="material-icons icons-charts-list">scatter_plot</i> Proyectos</h4>
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
                                            <h4 class="card-title"><i class="material-icons icons-charts-list">vpn_key</i> Etapas</h4>
                                        </div>
                                        <div class="card-body" style="height: 250px; overflow: auto">
                                        @if(count($etapas) == 0)
                                            <a style="color: #c42623; font-size: 1.2em"><strong>No hay etapas</strong></a>
                                        @else
                                            @foreach($etapas as $etapa)
                                                <div class="form-check filters-stages-list">
                                                    <input type="checkbox" class="form-check-input box-mod" id="etapa{{$etapa->id}}" name="etapas[]" value="{{$etapa->id}}">
                                                    <label class="form-check-label" for="etapa{{$etapa->id}}">{{$etapa->etapa}} de {{$etapa->proyecto}}</label>
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
