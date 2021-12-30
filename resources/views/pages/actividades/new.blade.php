@extends('layouts.app', ['activePage' => 'Actividades', 'titlePage' => __('Actividades')])

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
                            <h4 class="card-title ">Proyecto {{$proyectoName->descripcion}} - Registrar nueva actividad</h4>
                        </div>
                        <div class="card-body">
                        <form method="POST" action="{{route('CreateActivity')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="proyecto" value="{{$proyectoID}}">
                                <input type="hidden" name="compania" value="{{$companiaId}}">
                                <input type="hidden" name="usuario" value="{{$usuarioId}}">
                                <input type="hidden" name="etapa" value="{{$etapa}}">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Descripcion</label>
                                        <input type="text"
                                            class="form-control @error('descripcion') is-invalid @enderror"
                                            name="descripcion" value="{{ old('descripcion') }}" required
                                            autocomplete="descripcion" autofocus>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Seguimiento</label>
                                        <input type="text"
                                               class="form-control @error('decision') is-invalid @enderror"
                                               name="decision" value="{{ old('decision') }}" required
                                               autocomplete="decision" autofocus>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Evidencia (imagen u archivo)</label>
                                    </div>
                                    <input type="file" name="file" id="file" class="form-control"/>
                                </div>
                            </div>

                            <div class="container mt-3" style="text-align: center">
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
