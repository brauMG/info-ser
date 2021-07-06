@extends('layouts.app')
@if($compania!=null)
    @section('company',$compania->Descripcion)
@endif
@section('content')
    @include('layouts.top-nav')
    <div class="container container-rapi2">
        <main role="main" class="ml-sm-auto">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 h2-less">Usuarios</h1>
            </div>
            <div class="btn-toolbar mb-2 mb-md-0">
                <button type="button" class="btn-less btn btn-info" id="new" onclick="AddUser();"><i class="fas fa-plus"></i> Agregar Usuario</button>
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
                        <th scope="col" style="text-transform: uppercase">Clave</th>
                        <th scope="col" style="text-transform: uppercase">Compania</th>
                        <th scope="col" style="text-transform: uppercase">Nombre(s)</th>
                        <th scope="col" style="text-transform: uppercase">Correo</th>
                        <th scope="col" style="text-transform: uppercase">Área</th>
                        <th scope="col" style="text-transform: uppercase">Puesto</th>
                        <th scope="col" style="text-transform: uppercase">Rol</th>
                        <th scope="col" style="text-transform: uppercase">Recibe Correo</th>
                        <th scope="col" style="text-transform: uppercase">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($usuarios as $item)
                            <tr id="{{$item->Clave}}">
                                <td class="td td-center">{{$item->Clave}}</td>
                                <td class="td td-center">{{$item->Compania}}</td>
                                <td class="td td-center">{{$item->Nombres}}</td>
                                <td class="td td-center">{{$item->email}}</td>
                                <td class="td td-center">{{$item->Area}}</td>
                                <td class="td td-center">{{$item->Puesto}}</td>
                                <td class="td td-center">{{$item->Rol}}</td>
                                @if($item->Send == true)
                                    <td class="td td-center">
                                        <a class="btn btn btn-success no-href" clave="{{$item->Clave}}" onclick="changeSend(this);" style="background-color: #1fab26; border-color: #1fab26" data-toggle="tooltip" data-placement="top" title="Recibe correos sobre novedades en los proyectos"><i class="fas fa-edit"></i> Si</a>
                                    </td>
                                @else
                                    <td class="td td-center">
                                        <a class="btn btn btn-success no-href" clave="{{$item->Clave}}" onclick="changeSend(this);" style="background-color: #ab221f; border-color: #ab221f" data-toggle="tooltip" data-placement="bottom" title="No recibe correos sobre novedades en los proyectos"><i class="fas fa-edit"></i> No</a>
                                    </td>
                                @endif
                                    <td  class="td td-center">
                                    <a class="btn-row btn btn-warning no-href" clave="{{$item->Clave}}" onclick="edit(this);"><i class="fas fa-edit"></i>Editar</a>
                                    <a class="btn-row btn btn-danger no-href" clave="{{$item->Clave}}" onclick="deleted(this);"><i class="fas fa-trash-alt"></i>Eliminar</a>
                                </td>
                        @endforeach
                    </tbody>
                    <tfoot class="table-footer">
                    <tr>
                        <th style="text-transform: uppercase">Clave</th>
                        <th style="text-transform: uppercase">Compania</th>
                        <th style="text-transform: uppercase">Nombre(s)</th>
                        <th style="text-transform: uppercase">Correo</th>
                        <th style="text-transform: uppercase">Área</th>
                        <th style="text-transform: uppercase">Puesto</th>
                        <th style="text-transform: uppercase">Rol</th>
                        <th style="text-transform: uppercase">Recibe Correo</th>
                        <th style="text-transform: uppercase">Acciones</th>
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

        function changeSend(button){
            var clave = $(button).attr('clave');
            $('#myModal').load( '{{ url('/Admin/Usuarios/ChangeSend') }}/'+clave,function(response, status, xhr){
                if ( status == "success" ) {
                    $('#myModal').modal('show');
                }
            } );
        }

        function AddUser() {
            $('#myModal').load( '{{ url('/Admin/Usuarios/New') }}',function(response, status, xhr)
            {
                if (status == "success")
                    $('#myModal').modal('show');
            });
        }

        function edit(button){
            var clave = $(button).attr('clave');
            $('#myModal').load( '{{ url('/Admin/Usuarios/Edit') }}/'+clave,function(response, status, xhr){
                if ( status == "success" ) {
                    $('#myModal').modal('show');
                }
            } );
        }

        function deleted(button){
            var clave = $(button).attr('clave');
            $('#myModal').load( '{{ url('/Admin/Usuarios/Delete') }}/'+clave,function(response, status, xhr){
                if ( status == "success" ) {
                    $('#myModal').modal('show');
                }
            } );
        }
    </script>
@endsection
