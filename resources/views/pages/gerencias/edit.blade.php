<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Actualizar Gerencia</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="material-icons">close</i>
            </button>
        </div>
        <form class="form" id="from" method="POST" action="{{ route('UpdateGerencia', $gerenciaID) }}">
            @method('PUT')
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input class="form-control" type="text" id="nombre" name="nombre" value="{{$gerencia['nombre']}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token"/>
                            <input type="hidden" name="clave" value="{{$gerencia['id']}}" id="clave"/>
                            <div class="invalid-feedback" id="error_descripcion" style="display: none;"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Gerente</label>
                            <select class="form-control" name="gerente" id="gerente">
                                @foreach($gerentes as $item)
                                    <option value="{{$item['id']}}" @if($item['id'] === $gerencia['id_gerente']) selected @endif>{{$item['nombres']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Dirección</label>
                            <select class="form-control" name="direccion" id="direccion">
                                @foreach($direcciones as $item)
                                    <option value="{{$item['id']}}" @if($item['id'] === $gerencia['id_direccion']) selected @endif>{{$item['nombre']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="material-icons">close</i>Cerrar</button>
                <button type="submit" class="btn btn-primary"><i class="material-icons">check</i>Actualizar</button>
            </div>
        </form>
    </div>
</div>
