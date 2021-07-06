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
                            <h4 class="no-bottom" style="text-transform: uppercase">Agregar Usuario a Proyecto</h4>
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{route('CreateProjectUser')}}">
                                @csrf
                                <input type="hidden" name="proyectoId" value="{{$proyectoId}}">
                                <input type="hidden" name="faseId" value="{{$faseId}}">

                                <table class="table-responsive table-card-inline" id="tAdmin">

                                    <tr>
                                        <th for="inputGroupSelect01" class="th-card">
                                            <i class="fas fa-address-card"></i> Usuario
                                        </th>
                                        <td class="td-card"> <select name="usuario" type="text" class="custom-select  @error('usuario') is-invalid @enderror" required>
                                                <option disabled selected>Seleccionar...</option>
                                                @php($count=0)
                                                @foreach($usuarios as $item)
                                                    <option value="{{ $item->Clave }}">{{ $item->Nombres }}</option>
                                                    @php($count++)
                                                @endforeach
                                                @if($count ==0)
                                                    <option disabled selected>No hay usuarios</option>
                                                @endif
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th for="inputGroupSelect01" class="th-card">
                                            <i class="fas fa-address-card"></i> Rol RASIC dentro del proyecto
                                        </th>
                                        <td class="td-card"> <select name="rol" type="text" class="custom-select  @error('rol') is-invalid @enderror" required>
                                                <option disabled selected>Seleccionar...</option>
                                                @php($count=0)
                                                @foreach($roles as $item)
                                                    <option value="{{ $item->Clave }}">{{ $item->RolRASIC }}</option>
                                                    @php($count++)
                                                @endforeach
                                                @if($count ==0)
                                                    <option disabled selected>No hay roles rasic</option>
                                                @endif
                                            </select>
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
