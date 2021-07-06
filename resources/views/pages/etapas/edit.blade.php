<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Actualizar Etapa</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form class="form" id="from" method="POST" action="{{ route('UpdateEtapa',$etapaId) }}">
            @method('PUT')
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label>Nombre de la Etapa</label>
                            <input class="form-control" type="text" id="descripcion" name="descripcion" value="{{$etapa['Descripcion']}}" required>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token"/>
                            <input type="hidden" name="clave" value="{{$etapa['Clave']}}" id="clave"/>
                            <div class="invalid-feedback" id="error_descripcion" style="display: none;"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label>Fecha de Vencimiento</label>
                            <input class="form-control" type="date" id="descripcion" name="fechaV" value="{{$etapa['Fecha_Vencimiento']}}" required>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token"/>
                            <div class="invalid-feedback" id="error_orden" style="display: none;"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label>Hora de Vencimiento</label>
                            <input class="form-control" type="time" id="descripcion" name="horaV" value="{{$etapa['Hora_Vencimiento']}}" required>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token"/>
                            <div class="invalid-feedback" id="error_orden" style="display: none;"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Actualizar</button>
                </div>
            </div>
        </form>
    </div>
</div>
