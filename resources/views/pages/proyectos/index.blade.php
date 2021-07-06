@extends('layouts.app')
@if($compania!=null)
    @section('company',$compania->Descripcion)
@endif
@section('content')
    @include('layouts.top-nav')
    <div class="container container-rapi2">
        <main role="main" class="ml-sm-auto">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 h2-less">Proyectos en @yield('company','Sin Compañia')</h1>
                @if($rol == 4)
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group mr-2">
                        <a type="button" class="btn-less btn btn-info" id="new" onclick="AddProject();"><i class="fas fa-plus"></i> Agregar Proyecto</a>
                    </div>
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
    @isset($mensaje)
        <div class="container-edits" style="margin-top: 2%">
            <div class="alert alert-warning" class='message' id='message'>{{ $mensaje }}</div>
        </div>
    @endisset
    @if ( session('mensajeAlert') )
        <div class="container-edits" style="margin-top: 2%">
            <div class="alert alert-warning" class='message' id='message'>{{ session('mensajeAlert') }}</div>
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
                        <th scope="col" style="text-transform: uppercase">Descripción</th>
                        <th scope="col" style="text-transform: uppercase">Objetivo</th>
                        <th scope="col" style="text-transform: uppercase">Criterio de Exito</th>
                        <th scope="col" style="text-transform: uppercase">Área</th>
                        <th scope="col" style="text-transform: uppercase" data-toggle="tooltip" data-placement="top" title="Presiona en el botón para cambiar de fase">Fase</th>
                        <th scope="col" style="text-transform: uppercase">Enfoque</th>
                        <th scope="col" style="text-transform: uppercase">Trabajo</th>
                        <th scope="col" style="text-transform: uppercase">Indicador</th>
                        <th scope="col" style="text-transform: uppercase" data-toggle="tooltip" data-placement="top" title="Presiona en el botón para cambiar de estado">Estado</th>
                        <th scope="col" style="text-transform: uppercase">Registro</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($proyecto as $item)
                        @if($item->Activo == 1)
                            <tr id="{{$item->Clave}}">
                                <td class="td td-center">{{$item->Clave}}</td>
                                <td class="td td-center">{{$item->Descripcion}}</td>
                                <td class="td td-center">{{$item->Objectivo}}</td>
                                <td class="td td-center">{{$item->Criterio}}</td>
                                <td class="td td-center">{{$item->Area}}</td>
                                <td class="td td-center">
                                    <a class="btn btn btn-success no-href" @if($rol == 4) clave="{{$item->Clave}}" onclick="changeFase(this);" @endif style="cursor: pointer"><i class="fas fa-edit"></i> {{$item->Fase}}</a>
                                </td>
                                <td class="td td-center">{{$item->Enfoque}}</td>
                                <td class="td td-center">{{$item->Trabajo}}</td>
                                <td class="td td-center">{{$item->Indicador}}</td>
                                <td class="td td-center">
                                    <a class="btn btn btn-warning no-href" style="cursor: pointer" @if($rol == 4)clave="{{$item->Clave}}" onclick="changeEstado(this);" @endif><i class="fas fa-edit"></i> {{$item->Status}}</a>
                                </td>
                                <td class="td td-center">
                                    <a class="btn btn btn-info no-href" href="{{route('TypeActivity', $item->Clave)}}"><i class="fas fa-edit"></i> Registrar Actividad</a>
                                </td>
                            </tr>
                        @elseif($item->Activo == 0)
                            <tr id="{{$item->Clave}}">
                                <td class="td td-center">{{$item->Clave}}</td>
                                <td class="td td-center">{{$item->Descripcion}}</td>
                                <td class="td td-center">{{$item->Objectivo}}</td>
                                <td class="td td-center">{{$item->Criterio}}</td>
                                <td class="td td-center">{{$item->Area}}</td>
                                <td class="td td-center">
                                    <a class="btn btn btn-success no-href" style="background-color: gray; border-color: gray" data-toggle="tooltip" data-placement="top" title="Debido al estado del proyecto, no se puede cambiar de fase"><i class="fas fa-edit"></i> {{$item->Fase}}</a>
                                </td>
                                <td class="td td-center">{{$item->Enfoque}}</td>
                                <td class="td td-center">{{$item->Trabajo}}</td>
                                <td class="td td-center">{{$item->Indicador}}</td>
                                @if($item->Status == 'Completado' || $item->Status == 'Terminado' || $item->Status == 'Finalizado' || $item->Status == 'Acabado' || $item->Status == 'Hecho')
                                    <td class="td td-center">
                                        <a class="btn btn btn-success no-href" @if($rol == 4) clave="{{$item->Clave}}" onclick="changeEstado(this);" @endif style="background-color: #1fab26; border-color: #1fab26" data-toggle="tooltip" data-placement="top" title="Este estado bloquea el proyecto"><i class="fas fa-edit"></i> {{$item->Status}}</a>
                                    </td>
                                @else
                                <td class="td td-center">
                                    <a class="btn btn btn-warning no-href" @if($rol == 4) clave="{{$item->Clave}}" onclick="changeEstado(this);" @endif style="background-color: #ab221f; border-color: #ab221f" data-toggle="tooltip" data-placement="top" title="Este estado bloquea el proyecto"><i class="fas fa-edit"></i> {{$item->Status}}</a>
                                </td>
                                @endif
                                <td class="td td-center">
                                    <a class="btn btn btn-info no-href" style="background-color: gray !important; border-color: gray" data-toggle="tooltip" data-placement="top" title="Debido al estado del proyecto, no es posible registrar actividades"><i class="fas fa-edit"></i> Registrar Actividad</a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                    <tfoot class="table-footer">
                    <tr>
                        <th style="text-transform: uppercase">Identificador</th>
                        <th style="text-transform: uppercase">Descripción</th>
                        <th style="text-transform: uppercase">Objetivo</th>
                        <th style="text-transform: uppercase">Criterio de Exito</th>
                        <th style="text-transform: uppercase">Área</th>
                        <th style="text-transform: uppercase">Fase</th>
                        <th style="text-transform: uppercase">Enfoque</th>
                        <th style="text-transform: uppercase">Trabajo</th>
                        <th style="text-transform: uppercase">Indicador</th>
                        <th scope="col" style="text-transform: uppercase">Estado</th>
                        <th style="text-transform: uppercase">Registro</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <script>
        $('.mydatatable').DataTable();

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })

        function AddProject() {
            $('#myModal').load( '{{ url('/Admin/Proyectos/New') }}',function(response, status, xhr)
            {
                if (status == "success")
                    $('#myModal').modal('show');
            });
        }

        function changeEstado(button){
            var clave = $(button).attr('clave');
            $('#myModal').load( '{{ url('/Admin/Proyectos/ChangeStatus') }}/'+clave,function(response, status, xhr){
                if ( status == "success" ) {
                    $('#myModal').modal('show');
                }
            } );
        }

        function changeFase(button){
            var clave = $(button).attr('clave');
            $('#myModal').load( '{{ url('/Admin/Proyectos/ChangeStage') }}/'+clave,function(response, status, xhr){
                if ( status == "success" ) {
                    $('#myModal').modal('show');
                }
            } );
        }

        function add(button){
            var clave = $(button).attr('clave');
            $('#myModal').load( '{{ url('/Admin/Actividades/New') }}/'+clave,function(response, status, xhr){
                if ( status == "success" ) {
                    $('#myModal').modal('show');
                }
            } );
        }
    </script>
@endsection
