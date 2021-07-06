@extends('layouts.app')
@if($compania!=null)
    @section('company',$compania->Descripcion)
@endif
@section('content')
    @include('layouts.top-nav')
    <div class="container container-rapi2">
        <main role="main" class="ml-sm-auto">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 h2-less">Agregar Usuario A Proyecto</h1>
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
                            <h4 class="no-bottom" style="text-transform: uppercase">Selecciona el proyecto</h4>
                        </div>

                        <form class="card-body" action="{{route('NewProjectUser')}}">
                            <table class="table-responsive table-card-inline" id="tAdmin">
                                <tr class="tr-card-complete">
                                    <div class="input-group mb-3">
                                        <th class="th-card" id="area address"><i class="fas fa-envelope-open-text"></i> Proyectos de la compañia</th>
                                        <td class="td-card">
                                            <select required id="proyecto" type='text' class="custom-select @error('proyecto') is-invalid @enderror"  name="proyecto" >
                                                @foreach($proyectos as $proyecto)
                                                    <option class='min' value="{{$proyecto->Clave}}">{{$proyecto->Descripcion}}</option>
                                                @endforeach
                                            </select>
                                            @error('proyecto')
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
