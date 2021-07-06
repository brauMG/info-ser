<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Actualizar Puesto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form class="form" id="from" method="POST" action="{{ route('UpdatePuesto',$puestoId) }}">
            @method('PUT')
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label>Puesto</label>
                            <input class="form-control" type="text" id="puesto" name="puesto" value="{{$puesto['Puesto']}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token"/>
                            <input type="hidden" name="clave" value="{{$puesto['Clave']}}" id="clave"/>
                            <div class="invalid-feedback" id="error_puesto" style="display: none;"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4" style="display: none;">
                        <div class="form-group">
                            <label>Compañía</label>
                            <select class="form-control" name="compania" id="compania" @if($userRol == 2) disabled @else @endif>
                                @foreach ($company as $item)
                                    <option value="{{$item['Clave']}}">{{$item['Descripcion']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Actualizar</button>
            </div>
        </form>
    </div>
</div>
