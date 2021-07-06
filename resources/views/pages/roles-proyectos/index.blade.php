@extends('layouts.app')
@if($compania!=null)
    @section('company',$compania->Descripcion)
@endif
@section('content')
    @include('layouts.top-nav')
    <div class="container container-rapi2">
        <main role="main" class="ml-sm-auto">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 h2-less">Roles en Proyectos</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group mr-2">
                        <a type="button" class="btn-less btn btn-info" id="new" href="{{route('Select')}}"><i class="fas fa-plus"></i> Agregar Usuario a Proyecto</a>
                    </div>
                </div>
            </div>
        </main>
        <div id="Alert"></div>
    </div>
    @if ( session('mensaje') )
        <div class="container-edits" style="margin-top: 2%">
            <div class="alert alert-success" class='message' id='message'>{{ session('mensaje') }}</div>
        </div>
    @endif
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
                        <th scope="col" style="text-transform: uppercase">Usuario</th>
                        <th scope="col" style="text-transform: uppercase">Puesto</th>
                        <th scope="col" style="text-transform: uppercase">Proyecto</th>
                        <th scope="col" style="text-transform: uppercase">Fase actual del proyecto</th>
                        <th scope="col" style="text-transform: uppercase">Rol RASIC</th>
                        <th scope="col" style="text-transform: uppercase">Fecha de Asignación</th>
                        <th scope="col" style="text-transform: uppercase" data-toggle="tooltip" data-placement="top" title="Presiona el botón para cambiar el estado">Estado</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($rolPROYECTO as $item)
                        <tr id="{{$item->Clave}}">
                            <td class="td td-center">{{$item->Usuario}}</td>
                            <td class="td td-center">{{$item->Puesto}}</td>
                            <td class="td td-center">{{$item->Proyecto}}</td>
                            <td class="td td-center">{{$item->Fase}}</td>
                            <td class="td td-center">{{$item->RolRASIC}}</td>
                            <td class="td td-center">
                                <a class="btn btn btn-dark no-href"><i class="fas fa-calendar-plus"></i> {{$item->FechaCreacion}}</a>
                            </td>
                            @if($item->Activo == 1)
                                <td class="td td-center">
                                    <a class="btn btn btn-success no-href" clave="{{$item->Clave}}" onclick="changeEstado(this);"><i class="fas fa-check"></i> Activo</a>
                                </td>
                            @else
                                <td class="td td-center">
                                    <a class="btn btn btn-danger no-href" clave="{{$item->Clave}}" onclick="changeEstado(this);" data-toggle="tooltip" data-placement="top" title="Este usuario no puede registrar actividades"><i class="fas fa-times-circle"></i> Inactivo</a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot class="table-footer">
                    <tr>
                        <th scope="col" style="text-transform: uppercase">Usuario</th>
                        <th scope="col" style="text-transform: uppercase">Puesto</th>
                        <th scope="col" style="text-transform: uppercase">Proyecto</th>
                        <th scope="col" style="text-transform: uppercase">Fase actual del proyecto</th>
                        <th scope="col" style="text-transform: uppercase">Rol RASIC</th>
                        <th scope="col" style="text-transform: uppercase">Fecha de Asignación</th>
                        <th scope="col" style="text-transform: uppercase">Estado</th>
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

        function changeEstado(button){
            var clave = $(button).attr('clave');
            $('#myModal').load( '{{ url('/Admin/RolesProyectos/ChangeStatus') }}/'+clave,function(response, status, xhr){
                if ( status == "success" ) {
                    $('#myModal').modal('show');
                }
            } );
        }
    </script>
@endsection
