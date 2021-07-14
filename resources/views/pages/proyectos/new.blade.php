<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nuevo Proyecto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="material-icons">close</i>
            </button>
        </div>
        <form action="{{route('CreateProject')}}" method="POST">
            @csrf
            <div class="modal-body">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token"/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Descripcion</label>
                            <input name="descripcion" type="text"
                                   class="form-control  @error('descripcion') is-invalid @enderror"
                                   placeholder="Ingresa la descripción del proyecto (Nombre)" aria-label="descripcion"
                                   aria-describedby="basic-addon1" required autocomplete="nombres" autofocus
                                   value={{Request::old('nombres')}}>
                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Objetivo</label>
                            <input name="objetivo" type="text"
                                   class="form-control  @error('objetivo') is-invalid @enderror"
                                   placeholder="Ingresa el objetivo del proyecto" aria-label="firstName"
                                   aria-describedby="basic-addon1" required autocomplete="objetivo" autofocus
                                   value={{Request::old('objetivo')}}>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Criterio de exito</label>
                            <input name="criterio" type="text"
                                   class="form-control  @error('criterio') is-invalid @enderror"
                                   placeholder="Ingresa el criterio de exito del proyecto" aria-label="criterio"
                                   aria-describedby="basic-addon1" required autocomplete="criterio" autofocus
                                   value={{Request::old('criterio')}}>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Área</label>
                            <select name="area" type="text" class="custom-select  @error('area') is-invalid @enderror" required>
                                <option disabled selected>Seleccionar</option>
                                @php($count=0)
                                @foreach($areas as $item)
                                    <option value="{{ $item->id }}">{{ $item->descripcion}}</option>
                                    @php($count++)
                                @endforeach
                                @if($count ==0)
                                    <option disabled selected>No hay áreas</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Fase</label>
                            <select name="fase" type="text" class="custom-select  @error('fase') is-invalid @enderror" required>
                                <option disabled selected>Seleccionar</option>
                                @php($count=0)
                                @foreach($fases as $item)
                                    <option value="{{ $item->id }}">{{ $item->descripcion }}</option>
                                    @php($count++)
                                @endforeach
                                @if($count ==0)
                                    <option disabled selected>No hay fases</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Enfoque</label>
                            <select name="enfoque" type="text" class="custom-select  @error('enfoque') is-invalid @enderror" required>
                                <option disabled selected>Seleccionar</option>
                                @php($count=0)
                                @foreach($enfoques as $item)
                                    <option value="{{ $item->id }}">{{ $item->descripcion }}</option>
                                    @php($count++)
                                @endforeach
                                @if($count ==0)
                                    <option disabled selected>No hay enfoques</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Trabajo</label>
                            <select name="trabajo" type="text" class="custom-select  @error('trabajo') is-invalid @enderror" required>
                                <option disabled selected>Seleccionar</option>
                                @php($count=0)
                                @foreach($trabajos as $item)
                                    <option value="{{ $item->id }}">{{ $item->descripcion }}</option>
                                    @php($count++)
                                @endforeach
                                @if($count ==0)
                                    <option disabled selected>No hay trabajos</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Indicador</label>
                            <select name="indicador" type="text" class="custom-select  @error('indicador') is-invalid @enderror" required>
                                <option disabled selected>Seleccionar</option>
                                @php($count=0)
                                @foreach($indicadores as $item)
                                    <option value="{{ $item->id }}">{{ $item->descripcion }}</option>
                                    @php($count++)
                                @endforeach
                                @if($count ==0)
                                    <option disabled selected>No hay indicadores</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Estado inicial del proyecto</label>
                            <select name="estado" type="text" class="custom-select  @error('estado') is-invalid @enderror" required>
                                <option disabled selected>Seleccionar</option>
                                @php($count=0)
                                @foreach($estados as $item)
                                    <option value="{{ $item->id }}">{{ $item->estado }}</option>
                                    @php($count++)
                                @endforeach
                                @if($count ==0)
                                    <option disabled selected>No hay estados</option>
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="material-icons">close</i>Cerrar</button>
                <button type="submit" class="btn btn-primary"><i class="material-icons">check</i>Guardar</button>
            </div>
        </form>
    </div>
</div>
