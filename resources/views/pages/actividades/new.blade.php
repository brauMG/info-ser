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
            </div>
        </main>
        <div id="Alert"></div>
    </div>
<div class="container">
    <div data-simplebar class="card-height-add-user-to-company" style="height: 700px !important;; padding-top: 0% !important;">
        <div class="col text-center">
            <div class="justify-content-center">
                <div class="card card-add-company">

                    <div class="card-header card-header-cute" style="background-color: #055e76 !important;">
                        <h4 class="no-bottom" style="text-transform: uppercase">Registrar Nueva Actividad</h4>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{route('CreateActivity')}}">
                            @csrf
                            <input type="hidden" name="proyecto" value="{{$proyectoID}}">
                            <input type="hidden" name="compania" value="{{$companiaId}}">
                            <input type="hidden" name="usuario" value="{{$usuarioId}}">
                            <input type="hidden" name="etapa" value="{{$etapa}}">

                            <table class="table-responsive table-card-inline" id="tAdmin">

                                <tr class="tr-card-complete">
                                    <th class="th-card"><i class="fas fa-user-check"></i>Descripción
                                    </th>
                                    <td class="td-card"> <input type="text"
                                                                class="form-control @error('descripcion') is-invalid @enderror"
                                                                name="descripcion" value="{{ old('descripcion') }}" required
                                                                autocomplete="descripcion" autofocus>
                                        @error('descripcion')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </td>
                                </tr>

                                <tr class="tr-card-complete">
                                    <th class="th-card"><i class="fas fa-user-check"></i>Decisión
                                    </th>
                                    <td class="td-card"> <input type="text"
                                                                class="form-control @error('decision') is-invalid @enderror"
                                                                name="decision" value="{{ old('decision') }}" required
                                                                autocomplete="decision" autofocus>
                                        @error('decision')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </td>
                                </tr>
                            </table>

                            <div class="container">
                                <button type="submit" class="button-size-08 btn btn-add btn-primary">Guardar Datos</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
