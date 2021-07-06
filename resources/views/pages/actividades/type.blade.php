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
            </div>
        </main>
        <div id="Alert"></div>
    </div>
    <div class="container">
        <div data-simplebar class="card-height-add-admin">
            <div class="col text-center">
                <div class="justify-content-center">
                    <div class="card card-add-company">

                        <div class="card-header card-header-cute" style="background-color: #055e76 !important;">
                            <h4 class="no-bottom" style="text-transform: uppercase">Selecciona la etapa</h4>
                        </div>

                        <form class="card-body" action="{{route('NewActivity', $proyectoID)}}">
                                <table class="table-responsive table-card-inline" id="tAdmin">
                                    <tr class="tr-card-complete">
                                        <div class="input-group mb-3">
                                            <th class="th-card" id="area address"><i class="fas fa-envelope-open-text"></i> Etapas disponibles en este proyecto</th>
                                            <td class="td-card">
                                                <select required id="etapa" type='text' class="custom-select @error('etapa') is-invalid @enderror"  name="etapa" >
                                                    @foreach($etapas as $etapa)
                                                        <option class='min' value="{{$etapa->Clave}}">{{$etapa->Descripcion}}</option>
                                                    @endforeach
                                                </select>
                                                @error('etapa')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </td>
                                        </div>
                                    </tr>
                                </table>
                                <div class="container">
                                    <button type="submit" class="btn btn-info">Siguiente</button>
                                </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
