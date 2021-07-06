@extends('layouts.app')
@if($compania!=null)
    @section('company',$compania->Descripcion)
@endif
@section('content')
    @include('layouts.top-nav')
    <div class='container'>
        <div data-simplebar class="card-height-add-sponsor" style="height: 930px !important;">
            <div class="col text-center">
                <div class="justify-content-center">
                    <div class="card card-add-company">

                        <div class="card-header card-header-cute" style="background-color: #055e76 !important; color: white !important; text-align: center !important;">
                            <h4 class="no-bottom" style="text-transform: uppercase">Editar Registro de Patrocinador</h4>
                        </div>
                        <div class="container-company" style="background-color: rgba(18,51,74,0.33)">
                            <img id="old-image" src="{{ URL::to('/') }}/sponsors/{{ $sponsor->image }}" class="img-thumbnail" width="100" />
                        </div>
                        @if ( session('mensaje') )
                            <div class="container-edits" style="margin-top: 2%">
                                <div class="alert alert-success" class='message' id='message'>{{ session('mensaje') }}</div>
                            </div>
                        @endif
                        @if ( session('mensajeError') )
                            <div class="container-edits" style="margin-top: 2%">
                                <div class="alert alert-warning" class='message' id='message'>{{ session('mensajeError') }}</div>
                            </div>
                        @endif
                        <div class="container-edits">
                            <div class="container btn-group" role="group">
                                <input type="button" class="btn" value="Datos Personales" style="background-color: #0F4C75; color: white" disabled>
                            </div>
                            <!--TABLES-->
                            <form class="form" id="from" method="POST" action="{{ route('UpdateSponsor',[$sponsor->sponsorId]) }}" style="margin-bottom: 2% !important;" enctype="multipart/form-data">
                                @csrf
                                <div class="form-edits" style="margin-bottom: 1% !important;">
                                    <table class="table-responsive table-card-inline" id="tAdmin">
                                        <!--TABLA ADMIN-->
                                        <tr class="tr-card-complete">
                                            <th class="th-card"><i class="fas fa-user-tag"></i> Nombre</th>
                                            <td class="td-card">
                                                <input type="text" name="name" id="nameS" class="form-control @error('name') is-invalid @enderror" value="{{ $sponsor->name }}" required>
                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr class="tr-card-complete">
                                            <th class="th-card"><i class="fab fa-readme"></i> Descripción</th>
                                            <td class="td-card">
                                                <div class="form-group">
                                                    <textarea rows="5" style="background-color: #eff0ee" name="description" id="descriptionS"  class="form-control @error('description') is-invalid @enderror" required>{{ $sponsor->description }}</textarea>
                                                </div>
                                                @error('description')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr class="">
                                            <th id='head' class="th-card"><i class="fas fa-clipboard-check"></i> Compañias Asignadas</th>
                                            <td class="td-card">
                                                @foreach ($array_companies as $company)
                                                    @if($company['companyId'] == 1)
                                                        <div class="form-check">
                                                            <input class="form-check-input label-size" type="hidden" name="companies[{{$company['name']}}]" value="{{ $company['companyId'] }}" checked>
                                                        </div>
                                                    @else
                                                        @if ($company['valid'])
                                                            <div class="form-check">
                                                                <input class="form-check-input label-size" type="checkbox" name="companies[{{$company['name']}}]" value="{{ $company['companyId'] }}" checked>
                                                                <label class="form-check-label label-size" for="defaultCheck1">{{ $company['name'] }}</label>
                                                            </div>
                                                        @else
                                                            <div class="form-check">
                                                                <input class="form-check-input label-size" type="checkbox" name="companies[{{$company['name']}}]" value="{{ $company['companyId'] }}">
                                                                <label class="form-check-label label-size" for="defaultCheck1">{{ $company['name'] }}</label>
                                                            </div>
                                                        @endif
                                                    @endif
                                                @endforeach
                                                @error('companies')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr class="tr-card-complete">
                                            <th class="th-card"> <i class="fas fa-signature"></i> Link</th>
                                            <td class="td-card">
                                                <input type="text" name="link" id="linkS"  class="form-control @error('link') is-invalid @enderror" value="{{ $sponsor->link }}" required>
                                                @error('link')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr id="tr-image">
                                            <th class="th-card">
                                                <i class="far fa-file-image"></i> Imagen (formato .png)
                                            </th>
                                            <td class="td-card">
                                                <input class="adjust-file2 form-control @error('image') is-invalid @enderror" type="file" name="image" />
                                                <div class="container">
                                                <img src="{{ URL::to('/') }}/sponsors/{{ $sponsor->image }}" class="img-thumbnail" width="100" />
                                                    <input type="hidden" name="hidden_image" value="{{ $sponsor->image }}" />
                                                </div>
                                                @error('image')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr class="">
                                            <th id='head' class="th-card"><i class="fas fa-check-circle"></i> Mostrar en Inicio</th>
                                            <td class="td-card">
                                                <div class="form-check">
                                                    @if($sponsor['show'] == true)
                                                        <input class="form-check-input label-size" type="checkbox" name="show" value="1" checked>
                                                    @else
                                                        <input class="form-check-input label-size" type="checkbox" name="show" value="1">
                                                    @endif
                                                    <label class="form-check-label label-size" for="defaultCheck1">Si</label>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class='container' style="margin-bottom: -12px !important;">
                                    <a href="{{ url('/Admin/viewSponsors/listSponsors') }}" class="btn btn-primary"><i class="fas fa-hand-point-left"></i> Regresar</a>
                                </div>
                                <div class='container'>
                                    <input type="submit" class="button-size-08 btn btn-add btn-warning" value="Guardar Cambios" style="color: white">
                                    <a href="{{route('CancelSponsor')}}" class="btn btn-primary"><i class="fas fa-sync-alt"></i> Cancelar</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
