<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nueva Área</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="material-icons">close</i>
            </button>
        </div>
        <form action="{{route('CreateArea')}}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Descripción</label>
                            <input class="form-control" type="text" id="descripcion" name="descripcion" required>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token"/>
                            <div class="invalid-feedback" id="error_descripcion" style="display: none;"></div>
                        </div>
                    </div>
                    @if(\Illuminate\Support\Facades\Auth::user()->id_rol == 1)
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="compania">Compañia</label>
                                <select class="form-control" id="compania" name="compania" required>
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
