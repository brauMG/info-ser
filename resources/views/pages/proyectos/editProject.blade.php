<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Editar Proyecto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="material-icons">close</i>
            </button>
        </div>
        <form class="form" id="from" method="POST" action="{{ route('UpdateProject', $id) }}" style="padding: 2%">
            @method('PUT')
            @csrf
            <div class="row">

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text"
                               class="form-control @error('nombre') is-invalid @enderror"
                               name="nombre" value="{{$proyecto->descripcion}}" required
                               autocomplete="nombre" autofocus>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Objetivo</label>
                        <input type="text"
                               class="form-control @error('objetivo') is-invalid @enderror"
                               name="objetivo" value="{{$proyecto->objetivo}}" required
                               autocomplete="objetivo" autofocus>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Criterio de Exito</label>
                        <input type="text"
                               class="form-control @error('criterio') is-invalid @enderror"
                               name="criterio" value="{{$proyecto->criterio}}" required
                               autocomplete="criterio" autofocus>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Gerencia</label>
                        <select required id="gerencia" type='text' class="custom-select @error('gerencia') is-invalid @enderror"  name="gerencia" >
                            @foreach($gerencias as $gerencia)
                                <option class='min' value="{{$gerencia->id}}" @if($proyecto->id_gerencia === $gerencia->id) selected @endif>{{$gerencia->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Areá</label>
                        <select required id="area" type='text' class="custom-select @error('area') is-invalid @enderror"  name="area" >
                            @foreach($areas as $area)
                                <option class='min' value="{{$area->id}}" @if($proyecto->id_area === $area->id) selected @endif>{{$area->descripcion}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Fase</label>
                        <select required id="fase" type='text' class="custom-select @error('fase') is-invalid @enderror"  name="fase" >
                            @foreach($fases as $fase)
                                <option class='min' value="{{$fase->id}}" @if($proyecto->id_fase === $fase->id) selected @endif>{{$fase->descripcion}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Enfoque</label>
                        <select required id="enfoque" type='text' class="custom-select @error('enfoque') is-invalid @enderror"  name="enfoque" >
                            @foreach($enfoques as $enfoque)
                                <option class='min' value="{{$enfoque->id}}" @if($proyecto->id_enfoque === $enfoque->id) selected @endif>{{$enfoque->descripcion}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Trabajo</label>
                        <select required id="trabajo" type='text' class="custom-select @error('trabajo') is-invalid @enderror"  name="trabajo" >
                            @foreach($trabajos as $trabajo)
                                <option class='min' value="{{$trabajo->id}}" @if($proyecto->id_trabajo === $trabajo->id) selected @endif>{{$trabajo->descripcion}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Indicador</label>
                        <select required id="indicador" type='text' class="custom-select @error('indicador') is-invalid @enderror"  name="indicador" >
                            @foreach($indicadores as $indicador)
                                <option class='min' value="{{$indicador->id}}" @if($proyecto->id_indicador === $indicador->id) selected @endif>{{$indicador->descripcion}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>

            <div class="container mt-3" style="text-align: center">
                <button type="submit" class="btn btn-primary"><i class="material-icons">check</i>Guardar</button>
            </div>
        </form>
    </div>
</div>
