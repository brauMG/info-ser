<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nuevo Estado</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{route('CreateStatus')}}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-6 col-md-4">
                        <div class="form-group">
                            <label>Estado</label>
                            <input class="form-control" type="text" id="status" name="status">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token"/>
                            <div class="invalid-feedback" id="error_status" style="display: none;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="form-group">
                        <label>¿Bloquea el proyecto?</label>
                        <select class="form-control" name="activo" id="activo">
                            <option value="1" selected>No</option>
                            <option value="0">Si</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
            </div>
        </form>
    </div>
</div>
