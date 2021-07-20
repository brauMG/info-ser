@extends('layouts.app', ['activePage' => 'UsuariosPDF', 'titlePage' => __('Usuarios Reporte')])

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
                            <h4 class="card-title">Filtros - Reporte de Usuarios</h4>
                        </div>
                    </div>
                </div>
                <form class="form-control" method="POST" action="{{route('UsersPDF')}}">
                    @csrf
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header card-header-info">
                                        <h4 class="card-title"><i class="material-icons icons-charts-list">engineering</i> Puestos</h4>
                                    </div>
                                    <div class="card-body" style="height: 250px; overflow: auto">
                                        @if(count($puestos) == 0)
                                            <a style="color: #c42623; font-size: 1.2em"><strong>No hay puestos</strong></a>
                                        @else
                                            @foreach($puestos as $puesto)
                                                <div class="form-check filters-projects-list">
                                                    <input type="checkbox" class="form-check-input box-mod" id="puesto{{$puesto->id}}" name="puestos[]" value="{{$puesto->id}}">
                                                    <label class="form-check-label" for="puesto{{$puesto->id}}">{{$puesto->descripcion}}</label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header card-header-info">
                                        <h4 class="card-title"><i class="material-icons icons-charts-list">area_chart</i> Áreas</h4>
                                    </div>
                                    <div class="card-body" style="height: 250px; overflow: auto">
                                        @if(count($areas) == 0)
                                            <a style="color: #c42623; font-size: 1.2em"><strong>No hay areas</strong></a>
                                        @else
                                            @foreach($areas as $area)
                                                <div class="form-check filters-projects-list">
                                                    <input type="checkbox" class="form-check-input box-mod" id="area{{$area->id}}" name="areas[]" value="{{$area->id}}">
                                                    <label class="form-check-label" for="area{{$area->id}}">{{$area->descripcion}}</label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header card-header-info">
                                        <h4 class="card-title"><i class="material-icons icons-charts-list">vpn_key</i> Roles</h4>
                                    </div>
                                    <div class="card-body" style="height: 250px; overflow: auto">
                                        @if(count($roles) == 0)
                                            <a style="color: #c42623; font-size: 1.2em"><strong>No hay roles</strong></a>
                                        @else
                                            @foreach($roles as $rol)
                                                <div class="form-check filters-stages-list">
                                                    <input type="checkbox" class="form-check-input box-mod" id="rol{{$rol->id}}" name="roles[]" value="{{$rol->id}}">
                                                    <label class="form-check-label" for="rol{{$rol->id}}">{{$rol->rol}}</label>
                                                </div>
                                            @endforeach
                                        @endif
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
