@extends('layouts.app')
@if($compania!=null)
    @section('company',$compania->Descripcion)
@endif
@section('content')
    @include('layouts.top-nav')
    <div class="container container-rapi2">
        <main role="main" class="ml-sm-auto">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 h2-less">RASIC</h1>
            </div>
        </main>
        <div id="Alert"></div>
    </div>
    <div class="container">
        <div data-simplebar class="table-responsive table-height">
            <div class="col text-center">
                <table class="table table-striped table-bordered mydatatable">
                    <thead class="table-header">
                    <tr>
                        <th scope="col" style="text-transform: uppercase">Clave</th>
                        <th scope="col" style="text-transform: uppercase">Rol RASIC</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($rolRASIC as $item)
                            <tr id="{{$item->Clave}}">
                                <td class="td td-center">{{$item->Clave}}</td>
                                <td class="td td-center">{{$item->RolRASIC}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-footer">
                    <tr>
                        <th style="text-transform: uppercase">Clave</th>
                        <th style="text-transform: uppercase">Rol RASIC</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <script>
        $('.mydatatable').DataTable();
    </script>
@endsection
