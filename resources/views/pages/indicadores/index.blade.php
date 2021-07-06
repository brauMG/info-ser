@extends('layouts.app')
@if($compania!=null)
    @section('company',$compania->Descripcion)
@endif
@section('content')
    @include('layouts.top-nav')
    <div class="container container-rapi2">
        <main role="main" class="ml-sm-auto">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 h2-less">Indicadores</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group mr-2">
                        <button type="button" class="btn-less btn btn-info" id="new" onclick="AddIndicator();"><i class="fas fa-plus"></i> Agregar Indicador</button>
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
                        <th scope="col" style="text-transform: uppercase">Clave</th>
                        <th scope="col" style="text-transform: uppercase">Descripción</th>
                        <th scope="col" style="text-transform: uppercase">Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($indicador as $item)
                        <tr id="{{$item->Clave}}">
                            <td class="td td-center">{{$item->Clave}}</td>
                            <td class="td td-center">{{$item->Descripcion}}</td>
                            <td class="td td-center">
                                <a class="btn-row btn btn-warning no-href" clave="{{$item->Clave}}" onclick="edit(this);"><i class="fas fa-edit"></i>Editar</a>
                                <a class="btn-row btn btn-danger no-href" clave="{{$item->Clave}}" onclick="deleted(this);"><i class="fas fa-trash-alt"></i>Eliminar</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot class="table-footer">
                    <tr>
                        <th style="text-transform: uppercase">Clave</th>
                        <th style="text-transform: uppercase">Descripción</th>
                        <th style="text-transform: uppercase">Acción</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <script>
        $('.mydatatable').DataTable();

        function AddIndicator() {
            $('#myModal').load( '{{ url('/Admin/Indicador/New') }}',function(response, status, xhr)
            {
                if (status == "success")
                    $('#myModal').modal('show');
            });
        }

        function edit(button){
            var clave = $(button).attr('clave');
            $('#myModal').load( '{{ url('/Admin/Indicador/Edit') }}/'+clave,function(response, status, xhr){
                if ( status == "success" ) {
                    $('#myModal').modal('show');
                }
            } );
        }

        function deleted(button){
            var clave = $(button).attr('clave');
            $('#myModal').load( '{{ url('/Admin/Indicador/Delete') }}/'+clave,function(response, status, xhr){
                if ( status == "success" ) {
                    $('#myModal').modal('show');
                }
            } );
        }
    </script>
@endsection
