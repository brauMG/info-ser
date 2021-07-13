<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Actualizar Área</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="material-icons">close</i>
            </button>
        </div>
        <form class="form" id="from" method="POST" action="{{ route('UpdateArea', $areaId) }}">
            @method('PUT')
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input class="form-control" type="text" id="descripcion" name="descripcion" value="{{$area['descripcion']}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token"/>
                            <input type="hidden" name="clave" value="{{$area['id']}}" id="clave"/>
                            <div class="invalid-feedback" id="error_descripcion" style="display: none;"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Compañía</label>
                            <select class="form-control" name="compania" id="compania" @if($userRol == 2) disabled @else @endif>
                            @foreach ($company as $item)
                                    <option value="{{$item['id']}}">{{$item['descripcion']}}</option>
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
