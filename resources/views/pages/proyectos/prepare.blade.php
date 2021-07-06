@extends('layouts.app')
@if($compania!=null)
    @section('company',$compania->Descripcion)
@endif
@section('content')
    @include('layouts.top-nav')
    <div class="container container-rapi2">
        <main role="main" class="ml-sm-auto">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 h2-less">Reporte de Proyectos</h1>
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
                    <form method="POST" action="{{route('ProjectsPDF')}}">
                        @csrf
                        <table class="table-responsive table-card-inline">
                            <thead class="thead">
                            <tr class="tr-card-complete" style="text-align: center">
                                <th scope="col" class="th-card filters-header filters-headers-mod"><i class="fas fa-map-pin"></i> Fases</th>
                                <th scope="col" class="th-card filters-header filters-headers-mod"><i class="fas fa-project-diagram"></i> Proyecto</th>
                                <th scope="col" class="th-card filters-header filters-headers-mod"><i class="fas fa-search-dollar"></i> Indicadores</th>
                            </tr>
                            </thead>
                            <tbody class="fonts" style="text-align: center">
                            <tr class="tr-card-complete">
                                <td class="td filters-act-creation filters-mod">
                                    @if(count($fases) == 0)
                                        <a style="color: #c42623; font-size: 1.2em"><strong>No hay fases</strong></a>
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
                                    @if(count($indicadores) == 0)
                                        <a style="color: #c42623; font-size: 1.2em"><strong>No hay indicadores</strong></a>
                                    @else
                                        @foreach($indicadores as $indicador)
                                            <div class="form-check filters-projects-list">
                                                <input type="checkbox" class="form-check-input box-mod" id="exampleCheck1" name="indicadores[]" value="{{$indicador->Clave}}">
                                                <label class="form-check-label" for="exampleCheck1">{{$indicador->Descripcion}}</label>
                                            </div>
                                        @endforeach
                                    @endif
                                </td>
                            </tr>
                            </tbody>

                            <thead class="thead">
                            <tr class="tr-card-complete" style="text-align: center">
                                <th scope="col" class="th-card filters-header filters-headers-mod"><i class="fas fa-chart-area"></i> Areas</th>
                                <th scope="col" class="th-card filters-header filters-headers-mod"><i class="fas fa-search"></i> Enfoques</th>
                                <th scope="col" class="th-card filters-header filters-headers-mod"><i class="fas fa-briefcase"></i> Trabajos</th>
                            </tr>
                            </thead>
                            <tbody class="fonts" style="text-align: center">
                            <tr class="tr-card-complete">
                                <td class="td filters-act-creation filters-mod">
                                    @if(count($areas) == 0)
                                        <a style="color: #c42623; font-size: 1.2em"><strong>No hay areas</strong></a>
                                    @else
                                        @foreach($areas as $area)
                                            <div class="form-check filters-projects-list">
                                                <input type="checkbox" class="form-check-input box-mod" id="exampleCheck1" name="areas[]" value="{{$area->Clave}}">
                                                <label class="form-check-label" for="exampleCheck1">{{$area->Descripcion}}</label>
                                            </div>
                                        @endforeach
                                    @endif
                                </td>
                                <td class="td filters-act-project filters-mod">
                                    @if(count($enfoques) == 0)
                                        <a style="color: #c42623; font-size: 1.2em"><strong>No hay enfoques</strong></a>
                                    @else
                                        @foreach($enfoques as $enfoque)
                                            <div class="form-check filters-projects-list">
                                                <input type="checkbox" class="form-check-input box-mod" id="exampleCheck1" name="enfoques[]" value="{{$enfoque->Clave}}">
                                                <label class="form-check-label" for="exampleCheck1">{{$enfoque->Descripcion}}</label>
                                            </div>
                                        @endforeach
                                    @endif
                                </td>
                                <td class="td filters-act-stages filters-mod">
                                    @if(count($trabajos) == 0)
                                        <a style="color: #c42623; font-size: 1.2em"><strong>No hay trabajos</strong></a>
                                    @else
                                        @foreach($trabajos as $trabajo)
                                            <div class="form-check filters-stages-list">
                                                <input type="checkbox" class="form-check-input box-mod" id="exampleCheck1" name="trabajos[]" value="{{$trabajo->Clave}}">
                                                <label class="form-check-label" for="exampleCheck1">{{$trabajo->Descripcion}}</label>
                                            </div>
                                        @endforeach
                                    @endif
                                </td>
                            </tr>
                            </tbody>

                            <thead class="thead">
                            <tr class="tr-card-complete" style="text-align: center">
                                <th scope="col" class="th-card filters-header filters-headers-mod"><i class="fas fa-registered"></i> SER</th>
                                <th scope="col" class="th-card filters-header filters-headers-mod"><i class="fas fa-signal"></i> Estados</th>
                                <th scope="col" class="th-card filters-header filters-headers-mod"><i class="fas fa-registered"></i> SER</th>
                            </tr>
                            </thead>
                            <tbody class="fonts" style="text-align: center">
                            <tr class="tr-card-complete">
                                <td class="td filters-act-creation filters-mod">

                                </td>
                                <td class="td filters-act-project filters-mod">
                                    @if(count($estados) == 0)
                                        <a style="color: #c42623; font-size: 1.2em"><strong>No hay estados</strong></a>
                                    @else
                                        @foreach($estados as $estado)
                                            <div class="form-check filters-projects-list">
                                                <input type="checkbox" class="form-check-input box-mod" id="exampleCheck1" name="estados[]" value="{{$estado->Clave}}">
                                                <label class="form-check-label" for="exampleCheck1">{{$estado->status}}</label>
                                            </div>
                                        @endforeach
                                    @endif
                                </td>
                                <td class="td filters-act-stages filters-mod">

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

