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
                            <p class="card-category">Selecciona el proyecto</p>
                        </div>
                        <div class="card-body">
                            <form action="{{route('NewProjectUser')}}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Proyecto</label>
                                            <select required id="proyecto" type='text' class="custom-select @error('proyecto') is-invalid @enderror"  name="proyecto" >
                                                @foreach($proyectos as $proyecto)
                                                    <option class='min' value="{{$proyecto->id}}">{{$proyecto->descripcion}}</option>
                                                @endforeach
                                            </select>
                                            @error('proyecto')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="container" style="text-align: center">
                                        <button type="submit" class="btn btn-primary"><i class="material-icons">check</i>Siguiente</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
