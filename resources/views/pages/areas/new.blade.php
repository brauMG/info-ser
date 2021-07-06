<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nueva Área</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{route('CreateArea')}}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-6 col-md-4">
                        <div class="form-group">
                            <label>Descripción</label>
                            <input class="form-control" type="text" id="descripcion" name="descripcion" required>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token"/>
                            <div class="invalid-feedback" id="error_descripcion" style="display: none;"></div>
                        </div>
                    </div>
                    @if(\Illuminate\Support\Facades\Auth::user()->Clave_Rol == 1)
                    <div class="col-6 col-md-4">
                        <div class="form-group">
                            <label for="compania">Compañia</label>
                            <select class="form-control" id="compania" name="compania" required>
                                @foreach ($company as $item)
                                    <option value="{{$item['Clave']}}">{{$item['Descripcion']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
            </div>
        </form>
    </div>
</div>
