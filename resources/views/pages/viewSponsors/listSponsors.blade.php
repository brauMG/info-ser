@extends('layouts.app')
@if($compania!=null)
    @section('company',$compania->Descripcion)
@endif
@section('content')
    @include('layouts.top-nav')
    <div class="container container-rapi2">
        <main role="main" class="ml-sm-auto">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 h2-less">Patrocinadores</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group mr-2">
                        <a href="{{url('/Admin/addSponsors/create')}}" class="btn-less btn btn-info" id="new"><i class="fas fa-plus"></i> Agregar Patrocinador</a>
                    </div>
                </div>
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
                        <td class=''>Imagen</td>
                        <td class=''>Nombre</td>
                        <td class=''>Descripción</td>
                        <td class=''>Link</td>
                        <td class=''>Acción</td>
                    </tr>
                    </thead>
                    <tbody class="">
                    @foreach($sponsors as $sponsor)
                            <tr>
                                <td class="td td-center"><img src="{{ URL::to('/') }}/sponsors/{{ $sponsor->image }}" class="img-thumbnail" width="75" /></td>
                                <td class="td td-center">{{$sponsor -> name}}</td>
                                <td class="td td-center">{{substr($sponsor->description, 0, 115)}}...</td>
                                <td class="td td-center">{{$sponsor -> link}}</td>
                                <td class="td td-center">
                                    <a href="{{ route('ShowSponsor', $sponsor->sponsorId) }}" class="btn-row btn btn-info"><i class="fas fa-bookmark"></i> Mostrar</a>
                                    <a href="{{ route('EditSponsor', $sponsor->sponsorId) }}" class="btn-row btn btn-warning"><i class="fas fa-edit"></i> Editar</a>
                                </td>
                            </tr>
                    @endforeach
                    <tfoot class="table-footer">
                    <tr>
                        <td class=''>Imagen</td>
                        <td class=''>Nombre</td>
                        <td class=''>Descripción</td>
                        <td class=''>Link</td>
                        <td class=''>Ver</td>
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
