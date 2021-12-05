<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nueva Etapa</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="material-icons">close</i>
            </button>
        </div>
        <form action="{{route('CreateEtapa')}}" method="POST">
            @csrf
            <div class="modal-body">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token"/>
                <input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token"/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Descripcion</label>
                            <input name="descripcion" type="text"
                                   class="form-control  @error('descripcion') is-invalid @enderror"
                                   placeholder="Ingresa la descripcion" aria-label="descripcion"
                                   aria-describedby="basic-addon1" required autocomplete="descripcion" autofocus
                                   value={{Request::old('descripcion')}}>
                        </div>
                    </div>

                    <input type="hidden" name="proyecto" value="{{$id}}">

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Fecha de Vencimiento</label>
                            <input name="fechaV" type="date"
                                   class="form-control  @error('fechaV') is-invalid @enderror"
                                   aria-label="fechaV"
                                   aria-describedby="basic-addon1" required autocomplete="fechaV" autofocus
                                   value={{Request::old('fechaV')}}>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Hora de Vencimiento</label>
                            <input name="horaV" type="time"
                                   class="form-control  @error('horaV') is-invalid @enderror"
                                   aria-label="horaV"
                                   aria-describedby="basic-addon1" required autocomplete="horaV" autofocus
                                   value={{Request::old('horaV')}}>
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
