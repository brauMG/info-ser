@extends('layouts.app')
@if($compania!=null)
    @section('company',$compania->Descripcion)
@endif
@section('content')
    @include('layouts.top-nav')
    <div class="container container-rapi2">
        <main role="main" class="ml-sm-auto">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 h2-less">Actividades</h1>
                @if($rol == 4 || $rol == 3)
                    <div class="btn-group mr-2">
                        <a type="button" class="btn-less btn btn-info" id="new" href="{{url('/Admin/Proyectos')}}"><i class="fas fa-plus"></i> Agregar Actividad</a>
                    </div>
                @endif
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
        <div data-simplebar class="table-responsive table-height">
            <div class="col text-center">
                <table class="table table-striped table-bordered mydatatable">
                    <thead class="table-header">
                    <tr>
                        <th scope="col" style="text-transform: uppercase">Identificador</th>
                        <th scope="col" style="text-transform: uppercase">Proyecto</th>
                        <th scope="col" style="text-transform: uppercase">Fase</th>
                        <th scope="col" style="text-transform: uppercase">Etapa</th>
                        <th scope="col" style="text-transform: uppercase">Usuario</th>
                        <th scope="col" style="text-transform: uppercase">Descripción</th>
                        <th scope="col" style="text-transform: uppercase">Decisión</th>
                        <th scope="col" style="text-transform: uppercase">Fecha de Creación</th>
                        <th scope="col" style="text-transform: uppercase" >Estado de Revisión</th>
                        <th scope="col" style="text-transform: uppercase">Fecha de Revisión</th>
                        <th scope="col" style="text-transform: uppercase">Hora de Revisión</th>
                        <th scope="col" style="text-transform: uppercase">Fecha de Vencimiento</th>
                        <th scope="col" style="text-transform: uppercase">Hora de Vencimiento</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($actividad as $item)
                            <tr id="{{$item->Clave}}">
                                <td class="td td-center">{{$item->Clave}}</td>
                                <td class="td td-center">{{$item->Proyecto}}</td>
                                <td class="td td-center">{{$item->Fase}}</td>
                                <td class="td td-center">{{$item->Etapa}}</td>
                                <td class="td td-center">{{$item->Usuario}}</td>
                                <td class="td td-center">{{$item->Descripcion}}</td>
                                <td class="td td-center">{{$item->Decision}}
                                <td class="td td-center">
                                    <a class="btn btn-dark no-href"><i class="fas fa-calendar-plus"></i> {{$item->FechaCreacion}}</a>
                                </td>
                                @if($item->Estado == 0)
                                    <td class="td td-center">
                                        <a class="btn btn-warning no-href" @if($rol == 4) clave="{{$item->Clave}}" onclick="changeEstado(this);" @endif><i class="fas fa-question-circle"></i> Pendiente</a>
                                    </td>
                                @elseif($item->Estado == 1)
                                    <td class="td td-center">
                                        <a class="btn btn btn-success no-href" data-toggle="tooltip" data-placement="top" title="Esta actividad ya fue revisada"><i class="fas fa-check-circle"></i> Aprobada</a>
                                    </td>
                                @elseif($item->Estado == 2)
                                    <td class="td td-center">
                                        <a class="btn btn btn-danger no-href" data-toggle="tooltip" data-placement="top" title="Esta actividad ya fue revisada"><i class="fas fa-times-circle"></i> Desaprobada</a>
                                    </td>
                                @endif
                                @if($item->Fecha_Revision == null)
                                    <td class="td td-center">
                                        <a class="btn btn btn-warning no-href"><i class="fas fa-question-circle"></i> Pendiente</a>
                                    </td>
                                    <td class="td td-center">
                                        <a class="btn btn btn-warning no-href"><i class="fas fa-question-circle"></i> Pendiente</a>
                                    </td>
                                @elseif($item->Fecha_Revision > $item->Fecha_Vencimiento)
                                    <td class="td td-center">
                                        <a class="btn btn btn-danger no-href"><i class="fas fa-calendar-times"></i> Se reviso tarde el: {{$item->Fecha_Revision}}</a>
                                    </td>
                                    <td class="td td-center">
                                        <a class="btn btn btn-danger no-href"><i class="fas fa-clock"></i> Se reviso a las: {{$item->Hora_Revision}}</a>
                                    </td>
                                @elseif($item->Fecha_Revision <= $item->Fecha_Vencimiento)
                                    <td class="td td-center">
                                        <a class="btn btn btn-success no-href"><i class="fas fa-calendar-check"></i> Se reviso a tiempo el: {{$item->Fecha_Revision}}</a>
                                    </td>
                                    <td class="td td-center">
                                        <a class="btn btn btn-success no-href"><i class="fas fa-clock"></i> Se reviso a las: {{$item->Hora_Revision}}</a>
                                    </td>
                                @endif
                                @if($date == $item->Fecha_Vencimiento)
                                    @if($time > $item->Hora_Vencimiento)
                                        <td class="td td-center">
                                            <a class="btn btn btn-danger no-href"><i class="fas fa-calendar-times"></i> Vencio hoy: {{$item->Fecha_Vencimiento}}</a>
                                        </td>
                                        <td class="td td-center">
                                            <a class="btn btn btn-danger no-href"><i class="fas fa-hourglass-end"></i> Vencio hoy a las: {{$item->Hora_Vencimiento}}</a>
                                        </td>
                                    @else
                                        <td class="td td-center">
                                            <a class="btn btn btn-warning no-href"><i class="fas fa-calendar"></i> Vence hoy: {{$item->Fecha_Vencimiento}}</a>
                                        </td>
                                        <td class="td td-center">
                                            <a class="btn btn btn-warning no-href"><i class="fas fa-hourglass-half"></i> Vence hoy a las: {{$item->Hora_Vencimiento}}</a>
                                        </td>
                                    @endif
                                @elseif($date < $item->Fecha_Vencimiento)
                                    <td class="td td-center">
                                        <a class="btn btn btn-success no-href"><i class="fas fa-calendar"></i> Vence el: {{$item->Fecha_Vencimiento}}</a>
                                    </td>
                                    <td class="td td-center">
                                        <a class="btn btn btn-success no-href"><i class="fas fa-hourglass-start"></i> Vence a las: {{$item->Hora_Vencimiento}}</a>
                                    </td>
                                @else
                                    <td class="td td-center">
                                        <a class="btn btn btn-danger no-href"><i class="fas fa-calendar-times"></i> Vencio el: {{$item->Fecha_Vencimiento}}</a>
                                    </td>
                                    <td class="td td-center">
                                        <a class="btn btn btn-danger no-href"><i class="fas fa-hourglass-end"></i> Vencio a las: {{$item->Hora_Vencimiento}}</a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-footer">
                    <tr>
                        <th scope="col" style="text-transform: uppercase">Identificador</th>
                        <th scope="col" style="text-transform: uppercase">Proyecto</th>
                        <th scope="col" style="text-transform: uppercase">Fase</th>
                        <th scope="col" style="text-transform: uppercase">Etapa</th>
                        <th scope="col" style="text-transform: uppercase">Usuario</th>
                        <th scope="col" style="text-transform: uppercase">Descripción</th>
                        <th scope="col" style="text-transform: uppercase">Decisión</th>
                        <th scope="col" style="text-transform: uppercase">Estado</th>
                        <th scope="col" style="text-transform: uppercase">Fecha de Creación</th>
                        <th scope="col" style="text-transform: uppercase">Fecha de Revisión</th>
                        <th scope="col" style="text-transform: uppercase">Hora de Revisión</th>
                        <th scope="col" style="text-transform: uppercase">Fecha de Vencimiento</th>
                        <th scope="col" style="text-transform: uppercase">Hora de Vencimiento</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        $('.mydatatable').DataTable();

        function changeEstado(button){
            var clave = $(button).attr('clave');
            $('#myModal').load( '{{ url('/Admin/Actividades/ChangeStatus') }}/'+clave,function(response, status, xhr){
                if ( status == "success" ) {
                    $('#myModal').modal('show');
                }
            } );
        }
    </script>
@endsection
