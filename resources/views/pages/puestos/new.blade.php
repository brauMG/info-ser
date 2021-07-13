<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nuevo Puesto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="material-icons">close</i>
            </button>
        </div>
        <form action="{{route('CreatePuesto')}}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Puesto</label>
                            <input class="form-control" type="text" id="puesto" name="puesto">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token"/>
                            <div class="invalid-feedback" id="error_puesto" style="display: none;"></div>
                        </div>
                    </div>
                    @if(\Illuminate\Support\Facades\Auth::user()->id_rol == 1)
                        <div class="col-md-12">
                        <div class="form-group">
                            <label>Compañía</label>
                            <select class="form-control" name="compania" id="compania">
                                @foreach ($company as $item)
                                    <option value="{{$item['id']}}">{{$item['descripcion']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="material-icons">close</i>Cerrar</button>
                <button type="submit" class="btn btn-primary"><i class="material-icons">check</i>Guardar</button>
            </div>
        </form>
    </div>
</div>
