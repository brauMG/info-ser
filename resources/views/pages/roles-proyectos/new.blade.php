@extends('layouts.app', ['activePage' => 'Roles en Proyectos', 'titlePage' => __('Roles en Proyectos')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @if ( session('mensaje') )
                        <div class="alert alert-success" role="alert" id="message">
                            {{ session('mensaje') }}
                        </div>
                    @endif
                    @if ( session('mensajeAlert') )
                        <div class="alert alert-warning" role="alert" id="message">
                            {{ session('mensajeAlert') }}
                        </div>
                    @endif
                    @if ( session('mensajeDanger') )
                        <div class="alert alert-danger" role="alert" id="message">
                            {{ session('mensajeDanger') }}
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger" role="alert" id="message">
                            Se encontraron los siguientes errores: <br>
                            @foreach($errors->all() as $error)
                                <br>
                                {{'• '.$error }}
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Roles en Proyectos</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{route('CreateProjectUser')}}">
                                @csrf
                                <div class="row">
                                    <input type="hidden" name="proyectoId" value="{{$proyectoId}}">
                                    <input type="hidden" name="faseId" value="{{$faseId}}">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Descripcion</label>
                                            <input name="descripcion" type="text"
                                                   class="form-control  @error('descripcion') is-invalid @enderror"
                                                   placeholder="Ingresa la descripcion" aria-label="descripcion"
                                                   aria-describedby="basic-addon1" required autocomplete="descripcion" autofocus
                                                   value={{Request::old('descripcion')}}>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Usuario</label>
                                            <select name="usuario" type="text" class="custom-select  @error('usuario') is-invalid @enderror" required>
                                                <option disabled selected>Seleccionar...</option>
                                                @php($count=0)
                                                @foreach($usuarios as $item)
                                                    <option value="{{ $item->id }}">{{ $item->nombres }}</option>
                                                    @php($count++)
                                                @endforeach
                                                @if($count ==0)
                                                    <option disabled selected>No hay usuarios</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Rol RASIC</label>
                                            <select name="rol" type="text" class="custom-select  @error('rol') is-invalid @enderror" required>
                                                <option disabled selected>Seleccionar...</option>
                                                @php($count=0)
                                                @foreach($roles as $item)
                                                    <option value="{{ $item->id }}">{{ $item->rol_rasic }}</option>
                                                    @php($count++)
                                                @endforeach
                                                @if($count ==0)
                                                    <option disabled selected>No hay roles rasic</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="container" style="text-align: center">
                                    <button type="submit" class="btn btn-primary"><i class="material-icons">check</i>Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
