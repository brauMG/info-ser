<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Actualizar compañia</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="material-icons">close</i>
            </button>
        </div>
        <form class="form" id="from" method="POST" action="{{ route('UpdateCompany',[$company['id']]) }}">
            @method('PUT')
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input class="form-control" type="text" id="descripcion" name="descripcion" value="{{$company['descripcion']}}" required>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token"/>
                            <input type="hidden" name="clave" value="{{$company['id']}}" id="clave"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Dominio</label>
                            <input class="form-control" type="text" id="dominio" name="dominio" value="{{$company['dominio']}}" required>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token"/>
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
