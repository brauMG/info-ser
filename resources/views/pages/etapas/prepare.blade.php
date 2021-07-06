@extends('layouts.app')
@if($compania!=null)
    @section('company',$compania->Descripcion)
@endif
@section('content')
    @include('layouts.top-nav')
    <div class="container container-rapi2">
        <main role="main" class="ml-sm-auto">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 h2-less">Reporte de Etapas</h1>
            </div>
        </main>
        <div id="Alert"></div>
    </div>
    @if ( session('mensaje') )
        <div class="container-edits" style="margin-top: 2%">
            <div class="alert alert-success" class='message' id='message'>{{ session('mensaje') }}</div>
        </div>
    @endif
    @if ( session('mensajeDanger') )
        <div class="container-edits" style="margin-top: 2%">
            <div class="alert alert-danger" class='message' id='message'>{{ session('mensajeDanger') }}</div>
        </div>
    @endif
    @if($errors->any())
        <div class="container-edits" style="margin-top: 1%">
            <div class="alert alert-danger" class='message' id='message'>
                Se encontraron los siguientes errores: <br>
                @foreach($errors->all() as $error)
                    <br>
                    {{'• '.$error }}
                @endforeach
            </div>
        </div>
    @endif
    <div class="container">
        <div class="card">
            <div class="card-header" style="background-color: #055e76 !important; color: white !important; text-align: center !important;">
                <h4 class="no-bottom">Filtros</h4>
            </div>
            <div class="card-body">
                <div class="col-xl-12" style="padding-top: 1%;">
                    <form method="POST" action="{{route('StagesPDF')}}">
                        @csrf
                        <table class="table-responsive table-card-inline">
                            <thead class="thead">
                            <tr class="tr-card-complete" style="text-align: center">
                                <th scope="col" class="th-card filters-header filters-headers-mod"><i class="fas fa-map-pin"></i> Fases</th>
                                <th scope="col" class="th-card filters-header filters-headers-mod"><i class="fas fa-project-diagram"></i> Proyecto</th>
                                <th scope="col" class="th-card filters-header filters-headers-mod"><i class="fas fa-layer-group"></i> Etapas</th>
                            </tr>
                            </thead>
                            <tbody class="fonts" style="text-align: center">
                            <tr class="tr-card-complete">
                                <td class="td filters-act-creation filters-mod">
                                    @if(count($fases) == 0)
                                        <a style="color: #c42623; font-size: 1.2em"><strong>No hay Fases</strong></a>
                                    @else
                                        @foreach($fases as $fase)
                                            <div class="form-check filters-projects-list">
                                                <input type="checkbox" class="form-check-input box-mod" id="exampleCheck1" name="fases[]" value="{{$fase->Clave}}">
                                                <label class="form-check-label" for="exampleCheck1">{{$fase->Descripcion}}</label>
                                            </div>
                                        @endforeach
                                    @endif
                                </td>
                                <td class="td filters-act-project filters-mod">
                                    @if(count($proyectos) == 0)
                                        <a style="color: #c42623; font-size: 1.2em"><strong>No hay proyectos</strong></a>
                                    @else
                                        @foreach($proyectos as $proyecto)
                                            <div class="form-check filters-projects-list">
                                                <input type="checkbox" class="form-check-input box-mod" id="exampleCheck1" name="proyectos[]" value="{{$proyecto->Clave}}">
                                                <label class="form-check-label" for="exampleCheck1">{{$proyecto->Descripcion}}</label>
                                            </div>
                                        @endforeach
                                    @endif
                                </td>
                                <td class="td filters-act-stages filters-mod">
                                    @if(count($etapas) == 0)
                                        <a style="color: #c42623; font-size: 1.2em"><strong>No hay etapas</strong></a>
                                    @else
                                        @foreach($etapas as $etapa)
                                            <div class="form-check filters-stages-list">
                                                <input type="checkbox" class="form-check-input box-mod" id="exampleCheck1" name="etapas[]" value="{{$etapa->Clave}}">
                                                <label class="form-check-label" for="exampleCheck1">{{$etapa->Etapa}} de {{$etapa->Proyecto}}</label>
                                            </div>
                                        @endforeach
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="container" style="text-align: center; padding-top: 2%">
                            <button type="submit" class="btn btn-primary" onclick="myFunction()">Generar Reporte</button>
                            <button type="reset" class="btn btn-warning" onclick="myFunction2()">Limpiar Campos</button>
                            <div id="mySpan" style="text-align: center; padding-top: 1%; color: #16a817; text-transform: uppercase; display: none">
                                <span><strong>El reporte se esta generando y se descargara automaticamente al finalizar</strong></span>
                            </div>
                        </div>
                    </form>
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
